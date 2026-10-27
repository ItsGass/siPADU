<?php

namespace App\Livewire;

use App\Models\Complaint;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class StatusCheck extends Component
{
    public string $ticket = '';

    public bool $searched = false;

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'ticket' => ['required', 'string', 'max:30'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'ticket.required' => 'Masukkan nomor tiket pengaduan terlebih dahulu.',
        ];
    }

    public function search(): void
    {
        $this->validate();

        $key = 'status-check:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $this->addError('ticket', 'Terlalu banyak percobaan. Silakan coba lagi dalam satu menit.');

            return;
        }

        RateLimiter::hit($key, 60);

        $this->ticket = strtoupper(trim($this->ticket));
        $this->searched = true;

        if (! Complaint::query()->where('ticket_number', $this->ticket)->exists()) {
            $this->addError('ticket', 'Nomor tiket tidak ditemukan. Periksa kembali nomor tiket Anda.');
        }
    }

    public function resetSearch(): void
    {
        $this->reset('ticket', 'searched');
        $this->resetErrorBag();
    }

    public function render(): View
    {
        $complaint = null;

        if ($this->searched && ! $this->getErrorBag()->has('ticket')) {
            $complaint = Complaint::query()
                ->with(['updates' => fn ($query) => $query->oldest()])
                ->where('ticket_number', $this->ticket)
                ->first();
        }

        return view('livewire.status-check', [
            'complaint' => $complaint,
        ]);
    }
}
