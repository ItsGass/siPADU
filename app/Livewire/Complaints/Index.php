<?php

namespace App\Livewire\Complaints;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintStatus;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Pengaduan Saya')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $category = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'status', 'category');
        $this->resetPage();
    }

    public function render(): View
    {
        $complaints = auth()->user()->complaints()
            ->when($this->search !== '', function ($query): void {
                $term = '%'.$this->search.'%';

                $query->where(function ($query) use ($term): void {
                    $query->where('title', 'like', $term)
                        ->orWhere('ticket_number', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->when($this->category !== '', fn ($query) => $query->where('category', $this->category))
            ->withCount('attachments')
            ->latest()
            ->paginate(8);

        return view('livewire.complaints.index', [
            'complaints' => $complaints,
            'statuses' => ComplaintStatus::options(),
            'categories' => ComplaintCategory::options(),
        ]);
    }
}
