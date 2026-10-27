<?php

namespace App\Livewire\Admin;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\Suggestion;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard Admin')]
class Dashboard extends Component
{
    public function render(): View
    {
        $statusCounts = Complaint::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total' => Complaint::query()->count(),
            'baru' => (int) ($statusCounts[ComplaintStatus::Baru->value] ?? 0),
            'diproses' => (int) ($statusCounts[ComplaintStatus::Diproses->value] ?? 0),
            'selesai' => (int) ($statusCounts[ComplaintStatus::Selesai->value] ?? 0),
            'saran_baru' => Suggestion::query()->where('is_reviewed', false)->count(),
        ];

        $total = max($stats['total'], 1);

        $chart = collect(ComplaintStatus::cases())
            ->map(fn (ComplaintStatus $status) => [
                'status' => $status,
                'total' => (int) ($statusCounts[$status->value] ?? 0),
                'percentage' => round(((int) ($statusCounts[$status->value] ?? 0)) / $total * 100),
            ]);

        $recent = Complaint::query()
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $recentSuggestions = Suggestion::query()
            ->with('user')
            ->latest()
            ->limit(4)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'chart' => $chart,
            'recent' => $recent,
            'recentSuggestions' => $recentSuggestions,
        ]);
    }
}
