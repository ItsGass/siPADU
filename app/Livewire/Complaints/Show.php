<?php

namespace App\Livewire\Complaints;

use App\Models\Complaint;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Detail Pengaduan')]
class Show extends Component
{
    public Complaint $complaint;

    public function mount(Complaint $complaint): void
    {
        abort_unless($complaint->isOwnedBy(auth()->user()), 403);

        $this->complaint = $complaint->load(['attachments', 'updates.user']);
    }

    public function render(): View
    {
        return view('livewire.complaints.show');
    }
}
