<div class="mx-auto w-full max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-navy-400" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-navy-700">Dashboard</a>
                <flux:icon.chevron-right class="size-3" />
                <span class="text-navy-600">Pengaduan Saya</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Pengaduan Saya</h1>
            <p class="mt-1 text-sm text-navy-500">Kelola dan pantau seluruh pengaduan yang telah Anda kirim.</p>
        </div>

        <flux:button :href="route('complaints.create')" variant="primary" icon="plus" class="justify-center">
            Buat Pengaduan
        </flux:button>
    </div>

    <div class="rounded-2xl border border-navy-100 bg-white p-4 shadow-sm sm:p-5">
        <div class="grid gap-3 lg:grid-cols-[1fr_190px_220px_auto] lg:items-end">
            <flux:input
                wire:model.live.debounce.300ms="search"
                label="Cari pengaduan"
                placeholder="Cari judul, nomor tiket, atau isi laporan..."
                icon="magnifying-glass"
            />

            <flux:select wire:model.live="status" label="Status">
                <flux:select.option value="">Semua status</flux:select.option>
                @foreach ($statuses as $value => $label)
                    <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="category" label="Kategori">
                <flux:select.option value="">Semua kategori</flux:select.option>
                @foreach ($categories as $value => $label)
                    <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:button wire:click="resetFilters" variant="ghost" icon="arrow-path" class="justify-center lg:mb-0.5">
                Reset
            </flux:button>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <p class="text-sm text-navy-500">
            Menampilkan <span class="font-semibold text-navy-800">{{ $complaints->count() }}</span> dari
            <span class="font-semibold text-navy-800">{{ $complaints->total() }}</span> pengaduan
        </p>
        <div wire:loading class="flex items-center gap-2 text-xs text-navy-400">
            <flux:icon.loading class="size-4" />
            Memuat...
        </div>
    </div>

    @if ($complaints->isEmpty())
        <div class="rounded-2xl border border-dashed border-navy-200 bg-white px-6 py-16 text-center">
            <span class="mx-auto inline-flex size-16 items-center justify-center rounded-2xl bg-navy-50 text-navy-400">
                <flux:icon.clipboard-document-list class="size-8" />
            </span>
            <h2 class="mt-4 text-base font-semibold text-navy-950">Belum ada pengaduan yang cocok</h2>
            <p class="mx-auto mt-1 max-w-md text-sm text-navy-500">
                @if ($search !== '' || $status !== '' || $category !== '')
                    Coba ubah kata kunci atau filter untuk menemukan pengaduan Anda.
                @else
                    Anda belum pernah mengirim pengaduan. Mulai dengan membuat laporan pertama.
                @endif
            </p>
            <div class="mt-5 flex flex-col items-center justify-center gap-2 sm:flex-row">
                @if ($search !== '' || $status !== '' || $category !== '')
                    <flux:button wire:click="resetFilters" variant="outline" icon="arrow-path">Hapus filter</flux:button>
                @endif
                <flux:button :href="route('complaints.create')" variant="primary" icon="plus">Buat Pengaduan</flux:button>
            </div>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($complaints as $complaint)
                <a
                    href="{{ route('complaints.show', $complaint->ticket_number) }}"
                    wire:navigate
                    wire:key="complaint-{{ $complaint->id }}"
                    class="group block rounded-2xl border border-navy-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-navy-200 hover:shadow-lg hover:shadow-navy-900/5"
                >
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                        <span class="inline-flex size-12 shrink-0 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                            <flux:icon :name="$complaint->category->icon()" class="size-6" />
                        </span>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-status-badge :status="$complaint->status" />
                                <span class="rounded-md bg-navy-50 px-2 py-1 font-mono text-[11px] font-semibold text-navy-600">{{ $complaint->ticket_number }}</span>
                                @if ($complaint->is_anonymous)
                                    <span class="inline-flex items-center gap-1 text-[11px] text-navy-400"><flux:icon.eye-slash class="size-3" /> Anonim</span>
                                @endif
                            </div>

                            <h2 class="mt-2 truncate text-base font-semibold text-navy-950 group-hover:text-navy-700">{{ $complaint->title }}</h2>
                            <p class="mt-1 line-clamp-2 text-sm leading-6 text-navy-500">{{ $complaint->description }}</p>

                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-navy-400">
                                <span class="inline-flex items-center gap-1.5"><flux:icon.tag class="size-3.5" /> {{ $complaint->category->label() }}</span>
                                <span class="inline-flex items-center gap-1.5"><flux:icon.calendar-days class="size-3.5" /> {{ $complaint->created_at->translatedFormat('d M Y') }}</span>
                                @if ($complaint->attachments_count > 0)
                                    <span class="inline-flex items-center gap-1.5"><flux:icon.paper-clip class="size-3.5" /> {{ $complaint->attachments_count }} bukti</span>
                                @endif
                                @if ($complaint->location)
                                    <span class="inline-flex items-center gap-1.5"><flux:icon.map-pin class="size-3.5" /> {{ $complaint->location }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-1 self-start text-xs font-semibold text-navy-500 transition group-hover:text-navy-800">
                            Detail
                            <flux:icon.chevron-right class="size-4 transition group-hover:translate-x-0.5" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pt-2">
            {{ $complaints->links() }}
        </div>
    @endif
</div>
