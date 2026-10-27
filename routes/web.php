<?php

use App\Http\Controllers\ComplaintAttachmentController;
use App\Livewire\Admin\Complaints\Index as AdminComplaintsIndex;
use App\Livewire\Admin\Complaints\Show as AdminComplaintsShow;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Suggestions\Index as AdminSuggestionsIndex;
use App\Livewire\Complaints\Create as ComplaintCreate;
use App\Livewire\Complaints\Index as ComplaintsIndex;
use App\Livewire\Complaints\Show as ComplaintShow;
use App\Livewire\Dashboard;
use App\Livewire\Suggestions\Index as SuggestionsIndex;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::view('/', 'public.home')->name('home');
Route::view('/tentang', 'public.about')->name('about');
Route::view('/cara-pengaduan', 'public.how-to')->name('how-to');
Route::view('/kontak', 'public.contact')->name('contact');
Route::view('/cek-status', 'public.status-check')->name('status.check');

/*
|--------------------------------------------------------------------------
| Area Mahasiswa & Admin
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/beranda', fn () => auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('dashboard'))->name('beranda');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/pengaduan', ComplaintsIndex::class)->name('complaints.index');
    Route::get('/pengaduan/buat', ComplaintCreate::class)->name('complaints.create');
    Route::get('/pengaduan/{complaint:ticket_number}', ComplaintShow::class)->name('complaints.show');
    Route::get('/pengaduan/{complaint:ticket_number}/bukti/{attachment}', ComplaintAttachmentController::class)
        ->name('complaints.attachment');

    Route::get('/saran', SuggestionsIndex::class)->name('suggestions.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/pengaduan', AdminComplaintsIndex::class)->name('complaints.index');
    Route::get('/pengaduan/{complaint}', AdminComplaintsShow::class)->name('complaints.show');
    Route::get('/saran', AdminSuggestionsIndex::class)->name('suggestions.index');
});

require __DIR__.'/settings.php';
