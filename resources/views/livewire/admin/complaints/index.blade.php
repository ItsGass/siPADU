<div class="mx-auto w-full max-w-7xl space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-gold-400">
                    <flux:icon.shield-check class="size-3" /> Panel Admin
                </span>
                <span class="text-xs text-navy-400">{{ $complaints->total() }} total pengaduan</span>
            </div>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Kelola Pengaduan</h1>
            <p class="mt-1 text-sm text-navy-500">Tinjau, ubah status, dan berikan tanggapan untuk setiap pengaduan mahasiswa.</p>
        </div>

        <flux:button :href="route('admin.dashboard')" variant="outline" icon="arrow-left" wire:navigate>Dashboard Admin</flux:button>
    </div>

    <div class="rounded-2xl border border-navy-100 bg-white p-4 shadow-sm sm:p-5">
        <div class="grid gap-3 lg:grid-cols-[1fr_180px_220px_auto] lg:items-end">
            <flux:input
                wire:model.live.debounce.300ms="search"
                label="Cari"
                placeholder="Cari nomor tiket, judul, nama, atau NIM..."
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

            <flux:button wire:click="resetFilters" variant="ghost" icon="arrow-path" class="justify-center">Reset</flux:button>
        </div>
    </div>

    <div class="rounded-2xl border border-navy-100 bg-white p-4 shadow-sm sm:p-6">
        @if ($complaints->isEmpty())
            <div class="py-14 text-center">
                <span class="mx-auto inline-flex size-14 items-center justify-center rounded-2xl bg-navy-50 text-navy-300">
                    <flux:icon.clipboard-document-list class="size-7" />
                </span>
                <h2 class="mt-4 text-sm font-semibold text-navy-950">Tidak ada pengaduan ditemukan</h2>
                <p class="mt-1 text-sm text-navy-500">Coba ubah kata kunci atau filter pencarian.</p>
                <flux:button wire:click="resetFilters" variant="outline" size="sm" class="mt-4" icon="arrow-path">Hapus filter</flux:button>
            </div>
        @else
            <flux:table :paginate="$complaints">
                <flux:table.columns>
                    <flux:table.column>Tiket</flux:table.column>
                    <flux:table.column>Pelapor</flux:table.column>
                    <flux:table.column>Pengaduan</flux:table.column>
                    <flux:table.column>Kategori</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Tanggal</flux:table.column>
                    <flux:table.column align="end">Aksi</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($complaints as $complaint)
                        <flux:table.row :key="$complaint->id">
                            <flux:table.cell class="whitespace-nowrap">
                                <span class="font-mono text-xs font-semibold text-navy-700">{{ $complaint->ticket_number }}</span>
                            </flux:table.cell>

                            <flux:table.cell>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-navy-900">{{ $complaint->is_anonymous ? 'Anonim' : $complaint->user->name }}</p>
                                    <p class="text-[11px] text-navy-400">{{ $complaint->is_anonymous ? 'Identitas disembunyikan' : ($complaint->user->nim ?: '-') }}</p>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell class="max-w-[20rem] whitespace-normal">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" wire:navigate class="group block">
                                    <p class="line-clamp-1 text-sm font-medium text-navy-900 group-hover:text-navy-600">{{ $complaint->title }}</p>
                                    <p class="mt-0.5 flex items-center gap-1.5 text-[11px] text-navy-400">
                                        <flux:icon.paper-clip class="size-3" /> {{ $complaint->attachments_count }} bukti
                                    </p>
                                </a>
                            </flux:table.cell>

                            <flux:table.cell>
                                <span class="inline-flex items-center gap-1.5 text-xs text-navy-600">
                                    <flux:icon :name="$complaint->category->icon()" class="size-3.5 text-navy-400" />
                                    {{ $complaint->category->label() }}
                                </span>
                            </flux:table.cell>

                            <flux:table.cell>
                                <x-status-badge :status="$complaint->status" />
                            </flux:table.cell>

                            <flux:table.cell class="whitespace-nowrap">
                                <span class="text-xs text-navy-500">{{ $complaint->created_at->translatedFormat('d M Y') }}</span>
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <flux:button :href="route('admin.complaints.show', $complaint)" variant="ghost" size="sm" icon="eye" wire:navigate>
                                    Detail
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        @endif
    </div>
</div>
