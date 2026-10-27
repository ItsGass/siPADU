<?php

namespace App\Livewire\Admin\Suggestions;

use App\Enums\SuggestionType;
use App\Models\Suggestion;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Kelola Saran & Kritik')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $type = '';

    #[Url]
    public string $reviewed = '';

    public function updatedType(): void
    {
        $this->resetPage();
    }

    public function updatedReviewed(): void
    {
        $this->resetPage();
    }

    public function toggleReviewed(int $suggestionId): void
    {
        $suggestion = Suggestion::query()->findOrFail($suggestionId);
        $suggestion->update(['is_reviewed' => ! $suggestion->is_reviewed]);

        Flux::toast(variant: 'success', text: $suggestion->is_reviewed ? 'Saran ditandai sudah ditinjau.' : 'Saran ditandai belum ditinjau.');
    }

    public function render(): View
    {
        $suggestions = Suggestion::query()
            ->with('user')
            ->when($this->type !== '', fn ($query) => $query->where('type', $this->type))
            ->when($this->reviewed !== '', fn ($query) => $query->where('is_reviewed', $this->reviewed === '1'))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.suggestions.index', [
            'suggestions' => $suggestions,
            'types' => SuggestionType::cases(),
        ]);
    }
}
