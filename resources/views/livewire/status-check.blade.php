<div class="space-y-6">
    <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-7">
        <form wire:submit="search" class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="inline-flex size-11 items-center justify-center rounded-xl bg-navy-900 text-gold-400">
                    <flux:icon.ticket class="size-5" />
                </span>
                <div>
                    <h2 class="text-base font-semibold text-navy-950">Masukkan nomor tiket</h2>
                    <p class="text-xs text-navy-400">Contoh: SPD-261027-A1B2C</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <flux:input
                        wire:model="ticket"
                        label="Nomor tiket pengaduan"
                        placeholder="SPD-XXXXXXXX-XXXXX"
                        icon="magnifying-glass"
                        autocomplete="off"
                        maxlength="30"
                    />
                </div>
                <flux:button type="submit" variant="primary" icon="magnifying-glass" class="justify-center sm:mb-0.5" wire:loading.attr="disabled" wire:target="search">
                    <span wire:loading.remove wire:target="search">Cek Status</span>
                    <span wire:loading wire:target="search">Mencari...</span>
                </flux:button>
            </div>

            <flux:error name="ticket" />
        </form>
    </div>

    @if ($complaint)
        <div class="overflow-hidden rounded-2xl border border-navy-100 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-navy-100 bg-navy-50/50 p-5 sm:flex-row sm:items-start sm:justify-between sm:p-6">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-status-badge :status="$complaint->status" />
                        <span class="rounded-md bg-white px-2 py-1 font-mono text-[11px] font-semibold text-navy-600 ring-1 ring-navy-100">{{ $complaint->ticket_number }}</span>
                    </div>
                    <h2 class="mt-3 text-lg font-bold leading-7 text-navy-950">{{ $complaint->title }}</h2>
                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-navy-500">
                        <span class="inline-flex items-center gap-1.5"><flux:icon.tag class="size-3.5" /> {{ $complaint->category->label() }}</span>
                        <span class="inline-flex items-center gap-1.5"><flux:icon.calendar-days class="size-3.5" /> Dikirim {{ $complaint->created_at->translatedFormat('d M Y') }}</span>
                        <span class="inline-flex items-center gap-1.5"><flux:icon.arrow-path class="size-3.5" /> Diperbarui {{ $complaint->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <flux:button wire:click="resetSearch" variant="outline" size="sm" icon="arrow-path" class="shrink-0">
                    Cek tiket lain
                </flux:button>
            </div>

            <div class="p-5 sm:p-6">
                <div class="rounded-xl border border-navy-100 bg-navy-50/60 p-4">
                    <div class="flex items-start gap-3">
                        <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg bg-white text-navy-700 ring-1 ring-navy-100">
                            <flux:icon :name="$complaint->status->icon()" class="size-4" />
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-navy-950">Status saat ini: {{ $complaint->status->label() }}</p>
                            <p class="mt-1 text-xs leading-5 text-navy-600">{{ $complaint->status->description() }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-navy-950">Riwayat Penanganan</h3>
                    <p class="mb-5 mt-1 text-xs text-navy-400">Pembaruan dari admin kampus akan tampil di sini.</p>
                    <x-complaint-timeline :complaint="$complaint" />
                </div>

                <div class="mt-6 flex flex-col gap-3 border-t border-navy-100 pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="flex items-center gap-1.5 text-xs text-navy-400">
                        <flux:icon.shield-check class="size-4 text-gold-600" />
                        Halaman ini hanya menampilkan status. Detail lengkap tersedia setelah login.
                    </p>
                    <flux:button :href="route('login')" variant="outline" size="sm" icon="arrow-right-end-on-rectangle">Masuk untuk detail</flux:button>
                </div>
            </div>
        </div>
    @elseif ($searched)
        <div class="rounded-2xl border border-dashed border-navy-200 bg-white px-6 py-14 text-center">
            <span class="mx-auto inline-flex size-14 items-center justify-center rounded-2xl bg-navy-50 text-navy-300">
                <flux:icon.magnifying-glass class="size-7" />
            </span>
            <h2 class="mt-4 text-sm font-semibold text-navy-950">Tiket tidak ditemukan</h2>
            <p class="mt-1 text-sm text-navy-500">Periksa kembali nomor tiket Anda, lalu coba lagi.</p>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['icon' => 'ticket', 'title' => 'Nomor tiket', 'text' => 'Diterima setelah pengaduan berhasil dikirim.'],
                ['icon' => 'magnifying-glass', 'title' => 'Masukkan tiket', 'text' => 'Ketik nomor tiket pada kolom di atas.'],
                ['icon' => 'clock', 'title' => 'Pantau status', 'text' => 'Lihat status dan riwayat penanganan terbaru.'],
            ] as $item)
                <div class="rounded-2xl border border-navy-100 bg-white p-5">
                    <span class="inline-flex size-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                        <flux:icon :name="$item['icon']" class="size-5" />
                    </span>
                    <h2 class="mt-3 text-sm font-semibold text-navy-950">{{ $item['title'] }}</h2>
                    <p class="mt-1 text-xs leading-5 text-navy-500">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
