<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public string $website = '';

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'min:5', 'max:150'],
            'message' => ['required', 'string', 'min:15', 'max:3000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.min' => 'Subjek minimal 5 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 15 karakter.',
        ];
    }

    public function submit(): void
    {
        if (filled($this->website)) {
            return;
        }

        $validated = $this->validate();

        ContactMessage::create($validated);

        $this->reset('name', 'email', 'subject', 'message');

        Flux::toast(variant: 'success', text: 'Pesan Anda berhasil dikirim. Terima kasih telah menghubungi SIPADU.');
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
