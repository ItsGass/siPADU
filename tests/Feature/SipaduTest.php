<?php

use App\Enums\ComplaintStatus;
use App\Livewire\Admin\Complaints\Show as AdminComplaintShow;
use App\Livewire\Complaints\Create as ComplaintCreate;
use App\Livewire\ContactForm;
use App\Livewire\StatusCheck;
use App\Livewire\Suggestions\Index as SuggestionsIndex;
use App\Models\Complaint;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

function sipaduUser(array $attributes = []): User
{
    $user = User::factory()->create($attributes);
    $user->forceFill(['email_verified_at' => now()])->save();

    return $user;
}

test('public pages can be rendered', function (string $path) {
    $this->get($path)
        ->assertOk()
        ->assertSee('SIPADU')
        ->assertSee('Universitas Pamulang Kampus Serang');
})->with([
    '/',
    '/tentang',
    '/cara-pengaduan',
    '/kontak',
    '/cek-status',
]);

test('guests are redirected from the dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('students can visit their dashboard and complaint pages', function () {
    $this->actingAs(sipaduUser());

    $this->get(route('dashboard'))->assertOk();
    $this->get(route('complaints.index'))->assertOk();
    $this->get(route('complaints.create'))->assertOk();
    $this->get(route('suggestions.index'))->assertOk();
});

test('admins are redirected from the student dashboard to the admin dashboard', function () {
    $this->actingAs(sipaduUser(['role' => User::ROLE_ADMIN]));

    $this->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
});

test('a student can submit a complaint with attachments', function () {
    Storage::fake('local');

    $user = sipaduUser();

    $this->actingAs($user);

    Livewire::test(ComplaintCreate::class)
        ->set('category', 'fasilitas')
        ->set('title', 'AC ruang kelas tidak berfungsi')
        ->set('description', 'AC di ruang kelas Gedung C tidak berfungsi sejak dua minggu terakhir sehingga ruangan menjadi panas.')
        ->set('location', 'Gedung C, Lantai 2')
        ->set('photos', [UploadedFile::fake()->image('bukti.jpg')])
        ->call('submit')
        ->assertHasNoErrors();

    $complaint = Complaint::query()->firstOrFail();

    expect($complaint->user_id)->toBe($user->id)
        ->and($complaint->status)->toBe(ComplaintStatus::Baru)
        ->and($complaint->ticket_number)->toStartWith('SPD-')
        ->and($complaint->attachments)->toHaveCount(1);

    Storage::disk('local')->assertExists($complaint->attachments->first()->path);
});

test('a student cannot view another students complaint', function () {
    $owner = sipaduUser();
    $other = sipaduUser();

    $complaint = Complaint::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($other)
        ->get(route('complaints.show', $complaint->ticket_number))
        ->assertForbidden();
});

test('the complaint detail page renders for its owner', function () {
    $owner = sipaduUser();
    $complaint = Complaint::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($owner)
        ->get(route('complaints.show', $complaint->ticket_number))
        ->assertOk()
        ->assertSee($complaint->ticket_number);
});

test('admin pages render for admins', function () {
    $admin = sipaduUser(['role' => User::ROLE_ADMIN]);
    $complaint = Complaint::factory()->create(['user_id' => sipaduUser()->id]);

    $this->actingAs($admin);

    $this->get(route('admin.dashboard'))->assertOk();
    $this->get(route('admin.complaints.index'))->assertOk();
    $this->get(route('admin.complaints.show', $complaint))->assertOk();
    $this->get(route('admin.suggestions.index'))->assertOk();
});

test('students can send suggestions and criticisms', function () {
    $user = sipaduUser();

    $this->actingAs($user);

    Livewire::test(SuggestionsIndex::class)
        ->set('type', 'saran')
        ->set('subject', 'Tambahkan notifikasi WhatsApp')
        ->set('message', 'Mohon tambahkan notifikasi WhatsApp agar mahasiswa tidak perlu terus membuka dashboard.')
        ->set('is_anonymous', true)
        ->call('submit')
        ->assertHasNoErrors();

    $suggestion = Suggestion::query()->firstOrFail();

    expect($suggestion->user_id)->toBe($user->id)
        ->and($suggestion->type->value)->toBe('saran')
        ->and($suggestion->is_anonymous)->toBeTrue();
});

test('a student cannot access the admin area', function () {
    $this->actingAs(sipaduUser());

    $this->get(route('admin.dashboard'))->assertForbidden();
    $this->get(route('admin.complaints.index'))->assertForbidden();
    $this->get(route('admin.suggestions.index'))->assertForbidden();
});

test('an admin can update complaint status and add a response', function () {
    $admin = sipaduUser(['role' => User::ROLE_ADMIN]);
    $student = sipaduUser();

    $complaint = Complaint::factory()->create([
        'user_id' => $student->id,
        'status' => ComplaintStatus::Baru,
    ]);

    $this->actingAs($admin);

    Livewire::test(AdminComplaintShow::class, ['complaint' => $complaint])
        ->set('status', 'diproses')
        ->set('priority', 'tinggi')
        ->set('message', 'Laporan sedang ditindaklanjuti oleh unit sarana dan prasarana.')
        ->call('update')
        ->assertHasNoErrors();

    $complaint->refresh();

    expect($complaint->status)->toBe(ComplaintStatus::Diproses)
        ->and($complaint->priority->value)->toBe('tinggi');

    $this->assertDatabaseHas('complaint_updates', [
        'complaint_id' => $complaint->id,
        'user_id' => $admin->id,
        'status' => 'diproses',
        'message' => 'Laporan sedang ditindaklanjuti oleh unit sarana dan prasarana.',
    ]);
});

test('a complaint can be found by ticket number without login', function () {
    $user = sipaduUser();
    $complaint = Complaint::factory()->create([
        'user_id' => $user->id,
        'title' => 'WiFi perpustakaan sering terputus',
        'is_anonymous' => true,
    ]);

    Livewire::test(StatusCheck::class)
        ->set('ticket', strtolower($complaint->ticket_number))
        ->call('search')
        ->assertHasNoErrors()
        ->assertSee('WiFi perpustakaan sering terputus')
        ->assertDontSee($user->name);
});

test('the contact form stores a message', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'Dewi Lestari')
        ->set('email', 'dewi@unpam.ac.id')
        ->set('subject', 'Pertanyaan layanan SIPADU')
        ->set('message', 'Apakah SIPADU juga menerima pertanyaan seputar layanan akademik?')
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Dewi Lestari',
        'email' => 'dewi@unpam.ac.id',
    ]);
});

test('attachments are only accessible to the owner and admins', function () {
    Storage::fake('local');

    $owner = sipaduUser();
    $other = sipaduUser();
    $admin = sipaduUser(['role' => User::ROLE_ADMIN]);

    $complaint = Complaint::factory()->create(['user_id' => $owner->id]);
    $attachment = $complaint->attachments()->create([
        'path' => 'complaints/'.$complaint->id.'/bukti.jpg',
        'original_name' => 'bukti.jpg',
        'mime_type' => 'image/jpeg',
        'size' => 1024,
    ]);

    Storage::disk('local')->put($attachment->path, 'file-content');

    $url = route('complaints.attachment', [
        'complaint' => $complaint->ticket_number,
        'attachment' => $attachment->id,
    ]);

    $this->actingAs($owner)->get($url)->assertOk();
    $this->actingAs($admin)->get($url)->assertOk();
    $this->actingAs($other)->get($url)->assertForbidden();
});
