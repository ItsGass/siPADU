<?php

namespace App\Livewire;

use App\Enums\ComplaintStatus;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function mount(): void
    {
        if (auth()->user()->isAdmin()) {
            $this->redirectRoute('admin.dashboard', navigate: true);
        }
    }

    public function render(): View
    {
        $user = auth()->user();

        $complaints = $user->complaints()
            ->withCount('attachments')
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'total' => $user->complaints()->count(),
            'diproses' => $user->complaints()->where('status', ComplaintStatus::Diproses)->count(),
            'selesai' => $user->complaints()->where('status', ComplaintStatus::Selesai)->count(),
            'saran' => $user->suggestions()->count(),
        ];

        return view('livewire.dashboard', [
            'complaints' => $complaints,
            'stats' => $stats,
        ]);
    }
}
