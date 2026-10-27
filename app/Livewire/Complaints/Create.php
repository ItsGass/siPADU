<?php

namespace App\Livewire\Complaints;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Buat Pengaduan')]
class Create extends Component
{
    use WithFileUploads;

    public string $category = '';

    public string $title = '';

    public string $description = '';

    public string $location = '';

    public string $incident_date = '';

    public bool $is_anonymous = false;

    /**
     * @var array<int, TemporaryUploadedFile>
     */
    public array $photos = [];

    /**
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'category' => ['required', Rule::enum(ComplaintCategory::class)],
            'title' => ['required', 'string', 'min:8', 'max:150'],
            'description' => ['required', 'string', 'min:30', 'max:5000'],
            'location' => ['nullable', 'string', 'max:255'],
            'incident_date' => ['nullable', 'date', 'before_or_equal:today'],
            'is_anonymous' => ['boolean'],
            'photos' => ['array', 'max:5'],
            'photos.*' => ['file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'category.required' => 'Pilih kategori pengaduan terlebih dahulu.',
            'title.required' => 'Judul pengaduan wajib diisi.',
            'title.min' => 'Judul minimal 8 karakter.',
            'description.required' => 'Kronologi pengaduan wajib diisi.',
            'description.min' => 'Kronologi minimal 30 karakter agar mudah dipahami.',
            'photos.max' => 'Maksimal 5 file bukti yang dapat diunggah.',
            'photos.*.mimes' => 'Format bukti harus JPG, PNG, WEBP, atau PDF.',
            'photos.*.max' => 'Ukuran setiap file maksimal 5 MB.',
            'incident_date.before_or_equal' => 'Tanggal kejadian tidak boleh melebihi hari ini.',
        ];
    }

    public function updatedPhotos(): void
    {
        $this->validateOnly('photos');
        $this->validateOnly('photos.*');
    }

    public function removePhoto(int $index): void
    {
        unset($this->photos[$index]);

        $this->photos = array_values($this->photos);
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $complaint = DB::transaction(function () use ($validated): Complaint {
            $complaint = Complaint::create([
                'user_id' => auth()->id(),
                'category' => $validated['category'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'] ?: null,
                'incident_date' => $validated['incident_date'] ?: null,
                'is_anonymous' => $validated['is_anonymous'],
                'status' => ComplaintStatus::Baru,
                'priority' => 'sedang',
            ]);

            foreach ($this->photos as $photo) {
                $path = $photo->store('complaints/'.$complaint->id, 'local');

                $complaint->attachments()->create([
                    'path' => $path,
                    'original_name' => $photo->getClientOriginalName(),
                    'mime_type' => $photo->getMimeType() ?: 'application/octet-stream',
                    'size' => $photo->getSize(),
                ]);
            }

            return $complaint;
        });

        Flux::toast(variant: 'success', text: 'Pengaduan berhasil dikirim. Simpan nomor tiket Anda: '.$complaint->ticket_number);

        $this->redirectRoute('complaints.show', ['complaint' => $complaint->ticket_number], navigate: true);
    }

    public function render(): View
    {
        return view('livewire.complaints.create', [
            'categories' => ComplaintCategory::cases(),
        ]);
    }
}
