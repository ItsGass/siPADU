<div class="mx-auto w-full max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-navy-400" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-navy-700">Dashboard</a>
                <flux:icon.chevron-right class="size-3" />
                <a href="{{ route('complaints.index') }}" wire:navigate class="hover:text-navy-700">Pengaduan Saya</a>
                <flux:icon.chevron-right class="size-3" />
                <span class="text-navy-600">Detail</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Detail Pengaduan</h1>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <flux:button :href="route('complaints.index')" variant="outline" icon="arrow-left" wire:navigate>Kembali</flux:button>
            <flux:button :href="route('complaints.create')" variant="primary" icon="plus" wire:navigate>Pengaduan Baru</flux:button>
        </div>
    </div>

    <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <x-status-badge :status="$complaint->status" />
                    <flux:badge :color="$complaint->priority->color()" size="sm" icon="flag">{{ $complaint->priority->label() }}</flux:badge>
                    @if ($complaint->is_anonymous)
                        <span class="inline-flex items-center gap-1 rounded-md bg-navy-50 px-2 py-1 text-[11px] font-medium text-navy-500">
                            <flux:icon.eye-slash class="size-3" /> Anonim
                        </span>
                    @endif
                </div>
                <h2 class="mt-3 text-xl font-bold leading-8 text-navy-950">{{ $complaint->title }}</h2>
                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-navy-500">
                    <span class="inline-flex items-center gap-1.5 font-mono font-semibold text-navy-700">{{ $complaint->ticket_number }}</span>
                    <span class="inline-flex items-center gap-1.5"><flux:icon.tag class="size-3.5" /> {{ $complaint->category->label() }}</span>
                    <span class="inline-flex items-center gap-1.5"><flux:icon.calendar-days class="size-3.5" /> {{ $complaint->created_at->translatedFormat('d M Y, H.i') }} WIB</span>
                    @if ($complaint->incident_date)
                        <span class="inline-flex items-center gap-1.5"><flux:icon.clock class="size-3.5" /> Kejadian: {{ $complaint->incident_date->translatedFormat('d M Y') }}</span>
                    @endif
                </div>
            </div>

            <button
                type="button"
                x-data="{ copied: false }"
                x-on:click="navigator.clipboard.writeText('{{ $complaint->ticket_number }}'); copied = true; setTimeout(() => copied = false, 2000)"
                class="inline-flex shrink-0 items-center gap-2 rounded-xl border border-navy-200 px-3 py-2 text-xs font-semibold text-navy-700 transition hover:bg-navy-50"
            >
                <flux:icon.clipboard-document class="size-4" />
                <span x-text="copied ? 'Tersalin!' : 'Salin tiket'">Salin tiket</span>
            </button>
        </div>

        <div class="mt-5 rounded-xl border border-navy-100 bg-navy-50/60 p-4">
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
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.5fr_0.8fr] lg:items-start">
        <div class="space-y-6">
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-navy-950">Kronologi</h2>
                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-navy-700">{{ $complaint->description }}</p>

                <div class="mt-6 grid gap-3 border-t border-navy-100 pt-5 sm:grid-cols-2">
                    <div class="rounded-xl bg-navy-50/70 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">Lokasi kejadian</p>
                        <p class="mt-1 text-sm font-medium text-navy-800">{{ $complaint->location ?: 'Tidak disebutkan' }}</p>
                    </div>
                    <div class="rounded-xl bg-navy-50/70 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">Pelapor</p>
                        <p class="mt-1 text-sm font-medium text-navy-800">{{ $complaint->reporterName() }}</p>
                    </div>
                </div>
            </div>

            @if ($complaint->attachments->isNotEmpty())
                <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold text-navy-950">Bukti Pendukung</h2>
                        <span class="text-xs text-navy-400">{{ $complaint->attachments->count() }} file</span>
                    </div>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach ($complaint->attachments as $attachment)
                            @php
                                $url = route('complaints.attachment', ['complaint' => $complaint->ticket_number, 'attachment' => $attachment->id]);
                            @endphp

                            <div class="overflow-hidden rounded-xl border border-navy-100 bg-navy-50/50">
                                @if ($attachment->isImage())
                                    <a href="{{ $url }}" target="_blank" rel="noopener" class="group block">
                                        <img src="{{ $url }}" alt="Bukti {{ $loop->iteration }}" class="h-44 w-full object-cover transition group-hover:scale-[1.02]">
                                    </a>
                                @else
                                    <a href="{{ $url }}" target="_blank" rel="noopener" class="flex h-44 flex-col items-center justify-center gap-2 bg-white text-navy-500">
                                        <flux:icon.document-text class="size-10 text-navy-300" />
                                        <span class="px-4 text-center text-xs font-medium">{{ $attachment->original_name }}</span>
                                    </a>
                                @endif

                                <div class="flex items-center justify-between gap-3 bg-white px-3 py-2.5">
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-medium text-navy-800">{{ $attachment->original_name }}</p>
                                        <p class="text-[10px] text-navy-400">{{ $attachment->humanSize() }}</p>
                                    </div>
                                    <a href="{{ $url }}?download=1" class="inline-flex size-8 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-600 transition hover:bg-navy-100" aria-label="Unduh {{ $attachment->original_name }}">
                                        <flux:icon.arrow-down-tray class="size-4" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-navy-950">Bukti Pendukung</h2>
                    <div class="mt-4 flex flex-col items-center justify-center rounded-xl border border-dashed border-navy-200 bg-navy-50/40 px-6 py-10 text-center">
                        <flux:icon.photo class="size-8 text-navy-300" />
                        <p class="mt-2 text-sm font-medium text-navy-700">Tidak ada bukti dilampirkan</p>
                        <p class="text-xs text-navy-400">Pengaduan ini dikirim tanpa foto atau dokumen pendukung.</p>
                    </div>
                </div>
            @endif

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-navy-950">Riwayat Penanganan</h2>
                <p class="mb-5 mt-1 text-xs text-navy-400">Setiap pembaruan dari admin kampus akan muncul di sini.</p>

                <x-complaint-timeline :complaint="$complaint" />
            </div>
        </div>

        <aside class="space-y-4 lg:sticky lg:top-24">
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-navy-950">Informasi Tiket</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Nomor tiket</dt>
                        <dd class="text-right font-mono text-xs font-semibold text-navy-800">{{ $complaint->ticket_number }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Kategori</dt>
                        <dd class="text-right font-medium text-navy-800">{{ $complaint->category->label() }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Prioritas</dt>
                        <dd class="text-right"><flux:badge :color="$complaint->priority->color()" size="sm">{{ $complaint->priority->label() }}</flux:badge></dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Dikirim</dt>
                        <dd class="text-right font-medium text-navy-800">{{ $complaint->created_at->translatedFormat('d M Y') }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Pembaruan</dt>
                        <dd class="text-right font-medium text-navy-800">{{ $complaint->updated_at->diffForHumans() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-gold-200 bg-gold-50/70 p-5">
                <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                    <flux:icon.information-circle class="size-4 text-gold-700" />
                    Catatan
                </h2>
                <p class="mt-2 text-xs leading-6 text-navy-600">
                    Pengaduan yang sudah dikirim tidak dapat diubah. Jika ada informasi tambahan, silakan hubungi admin melalui halaman kontak dengan menyertakan nomor tiket.
                </p>
                <flux:button :href="route('contact')" variant="outline" size="sm" class="mt-3 w-full" icon:trailing="arrow-right">Hubungi SIPADU</flux:button>
            </div>

            <div class="rounded-2xl bg-navy-900 p-5 text-white">
                <h2 class="flex items-center gap-2 text-sm font-semibold">
                    <flux:icon.magnifying-glass class="size-4 text-gold-400" />
                    Cek tanpa login
                </h2>
                <p class="mt-2 text-xs leading-5 text-navy-300">Gunakan nomor tiket untuk memeriksa status kapan saja.</p>
                <flux:button :href="route('status.check')" variant="outline" size="sm" class="mt-3 w-full">Buka halaman cek status</flux:button>
            </div>
        </aside>
    </div>
</div>
