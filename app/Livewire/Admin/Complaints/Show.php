<?php

namespace App\Livewire\Admin\Complaints;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Detail Pengaduan')]
class Show extends Component
{
    public Complaint $complaint;

    public string $status = '';

    public string $priority = '';

    public string $message = '';

    public function mount(Complaint $complaint): void
    {
        $this->complaint = $complaint->load(['attachments', 'updates.user', 'user']);
        $this->status = $complaint->status->value;
        $this->priority = $complaint->priority->value;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'status' => ['required', Rule::enum(ComplaintStatus::class)],
            'priority' => ['required', Rule::enum(ComplaintPriority::class)],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        $statusChanged = $this->complaint->status->value !== $validated['status'];
        $priorityChanged = $this->complaint->priority->value !== $validated['priority'];
        $hasMessage = filled($validated['message']);

        if (! $statusChanged && ! $priorityChanged && ! $hasMessage) {
            $this->addError('message', 'Ubah status, prioritas, atau tulis tanggapan terlebih dahulu.');

            return;
        }

        $this->complaint->update([
            'status' => $validated['status'],
            'priority' => $validated['priority'],
        ]);

        if ($statusChanged || $hasMessage) {
            $this->complaint->updates()->create([
                'user_id' => auth()->id(),
                'status' => $validated['status'],
                'message' => $validated['message'] ?: null,
            ]);
        }

        $this->complaint->refresh()->load(['attachments', 'updates.user', 'user']);
        $this->message = '';

        Flux::toast(variant: 'success', text: 'Pengaduan berhasil diperbarui.');
    }

    public function render(): View
    {
        return view('livewire.admin.complaints.show', [
            'statuses' => ComplaintStatus::options(),
            'priorities' => ComplaintPriority::options(),
            'categories' => ComplaintCategory::options(),
            'statusCases' => ComplaintStatus::cases(),
        ]);
    }
}
