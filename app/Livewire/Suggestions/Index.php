<?php

namespace App\Livewire\Suggestions;

use App\Enums\SuggestionType;
use App\Models\Suggestion;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Saran & Kritik')]
class Index extends Component
{
    use WithPagination;

    public string $type = 'saran';

    public string $subject = '';

    public string $message = '';

    public bool $is_anonymous = false;

    /**
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(SuggestionType::class)],
            'subject' => ['required', 'string', 'min:5', 'max:150'],
            'message' => ['required', 'string', 'min:15', 'max:3000'],
            'is_anonymous' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'subject.required' => 'Subjek saran/kritik wajib diisi.',
            'subject.min' => 'Subjek minimal 5 karakter.',
            'message.required' => 'Isi saran/kritik wajib diisi.',
            'message.min' => 'Isi minimal 15 karakter.',
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        Suggestion::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'is_anonymous' => $validated['is_anonymous'],
        ]);

        $this->reset('subject', 'message', 'is_anonymous');
        $this->resetPage();

        Flux::toast(variant: 'success', text: 'Terima kasih! Saran/kritik Anda sudah kami terima.');
    }

    public function render(): View
    {
        $suggestions = auth()->user()->suggestions()
            ->latest()
            ->paginate(6);

        return view('livewire.suggestions.index', [
            'suggestions' => $suggestions,
            'types' => SuggestionType::cases(),
        ]);
    }
}
