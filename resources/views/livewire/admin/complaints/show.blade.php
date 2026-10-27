<div class="mx-auto w-full max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-navy-400" aria-label="Breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="hover:text-navy-700">Dashboard Admin</a>
                <flux:icon.chevron-right class="size-3" />
                <a href="{{ route('admin.complaints.index') }}" wire:navigate class="hover:text-navy-700">Kelola Pengaduan</a>
                <flux:icon.chevron-right class="size-3" />
                <span class="text-navy-600">Detail</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Detail Pengaduan</h1>
        </div>

        <flux:button :href="route('admin.complaints.index')" variant="outline" icon="arrow-left" wire:navigate>Kembali ke daftar</flux:button>
    </div>

    <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-wrap items-center gap-2">
            <x-status-badge :status="$complaint->status" />
            <flux:badge :color="$complaint->priority->color()" size="sm" icon="flag">Prioritas {{ $complaint->priority->label() }}</flux:badge>
            @if ($complaint->is_anonymous)
                <span class="inline-flex items-center gap-1 rounded-md bg-navy-50 px-2 py-1 text-[11px] font-medium text-navy-500">
                    <flux:icon.eye-slash class="size-3" /> Anonim
                </span>
            @endif
            <span class="rounded-md bg-navy-50 px-2 py-1 font-mono text-[11px] font-semibold text-navy-600">{{ $complaint->ticket_number }}</span>
        </div>

        <h2 class="mt-3 text-xl font-bold leading-8 text-navy-950">{{ $complaint->title }}</h2>
        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-navy-500">
            <span class="inline-flex items-center gap-1.5"><flux:icon.user class="size-3.5" /> {{ $complaint->reporterName() }}</span>
            <span class="inline-flex items-center gap-1.5"><flux:icon.tag class="size-3.5" /> {{ $complaint->category->label() }}</span>
            <span class="inline-flex items-center gap-1.5"><flux:icon.calendar-days class="size-3.5" /> {{ $complaint->created_at->translatedFormat('d M Y, H.i') }} WIB</span>
            @if ($complaint->location)
                <span class="inline-flex items-center gap-1.5"><flux:icon.map-pin class="size-3.5" /> {{ $complaint->location }}</span>
            @endif
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.45fr_0.85fr] xl:items-start">
        <div class="space-y-6">
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-navy-950">Kronologi Pengaduan</h2>
                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-navy-700">{{ $complaint->description }}</p>

                <div class="mt-6 grid gap-3 border-t border-navy-100 pt-5 sm:grid-cols-3">
                    <div class="rounded-xl bg-navy-50/70 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">Tanggal kejadian</p>
                        <p class="mt-1 text-sm font-medium text-navy-800">{{ $complaint->incident_date ? $complaint->incident_date->translatedFormat('d M Y') : 'Tidak disebutkan' }}</p>
                    </div>
                    <div class="rounded-xl bg-navy-50/70 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">Lokasi</p>
                        <p class="mt-1 text-sm font-medium text-navy-800">{{ $complaint->location ?: 'Tidak disebutkan' }}</p>
                    </div>
                    <div class="rounded-xl bg-navy-50/70 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">Lampiran</p>
                        <p class="mt-1 text-sm font-medium text-navy-800">{{ $complaint->attachments->count() }} file</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-navy-950">Informasi Pelapor</h2>
                <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center">
                    <flux:avatar :name="$complaint->reporterName()" :initials="$complaint->reporterInitials()" size="lg" />
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-navy-950">{{ $complaint->reporterName() }}</p>
                        @if ($complaint->is_anonymous)
                            <p class="mt-0.5 text-xs leading-5 text-navy-500">Mahasiswa memilih mode anonim. Identitas tidak ditampilkan pada halaman publik.</p>
                        @else
                            <p class="mt-0.5 text-xs text-navy-500">{{ $complaint->user->nim ?: '-' }} &middot; {{ $complaint->user->program_studi ?: '-' }}</p>
                            <p class="text-xs text-navy-400">{{ $complaint->user->email }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-navy-950">Bukti Pendukung</h2>
                    <span class="text-xs text-navy-400">{{ $complaint->attachments->count() }} file</span>
                </div>

                @if ($complaint->attachments->isEmpty())
                    <div class="mt-4 rounded-xl border border-dashed border-navy-200 bg-navy-50/40 px-6 py-8 text-center text-sm text-navy-500">
                        Tidak ada bukti yang dilampirkan.
                    </div>
                @else
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach ($complaint->attachments as $attachment)
                            @php
                                $url = route('complaints.attachment', ['complaint' => $complaint->ticket_number, 'attachment' => $attachment->id]);
                            @endphp
                            <div class="overflow-hidden rounded-xl border border-navy-100">
                                @if ($attachment->isImage())
                                    <a href="{{ $url }}" target="_blank" rel="noopener">
                                        <img src="{{ $url }}" alt="Bukti {{ $loop->iteration }}" class="h-40 w-full object-cover">
                                    </a>
                                @else
                                    <a href="{{ $url }}" target="_blank" rel="noopener" class="flex h-40 flex-col items-center justify-center gap-2 bg-navy-50/50">
                                        <flux:icon.document-text class="size-9 text-navy-300" />
                                        <span class="px-3 text-center text-xs font-medium text-navy-600">{{ $attachment->original_name }}</span>
                                    </a>
                                @endif
                                <div class="flex items-center justify-between gap-2 bg-white px-3 py-2">
                                    <span class="truncate text-[11px] text-navy-500">{{ $attachment->original_name }} &middot; {{ $attachment->humanSize() }}</span>
                                    <a href="{{ $url }}?download=1" class="inline-flex size-7 shrink-0 items-center justify-center rounded-md bg-navy-50 text-navy-600 hover:bg-navy-100" aria-label="Unduh">
                                        <flux:icon.arrow-down-tray class="size-3.5" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-navy-950">Riwayat Penanganan</h2>
                <p class="mb-5 mt-1 text-xs text-navy-400">Seluruh pembaruan yang terlihat oleh mahasiswa.</p>
                <x-complaint-timeline :complaint="$complaint" />
            </div>
        </div>

        <aside class="xl:sticky xl:top-24">
            <form wire:submit="update" class="space-y-4 rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div>
                    <h2 class="flex items-center gap-2 text-base font-semibold text-navy-950">
                        <flux:icon.clipboard-document-check class="size-4 text-navy-500" />
                        Tindak Lanjut
                    </h2>
                    <p class="mt-1 text-xs text-navy-400">Perbarui status dan kirim tanggapan resmi.</p>
                </div>

                <div class="grid gap-2 rounded-xl bg-navy-50/70 p-3 sm:grid-cols-2">
                    <flux:button type="button" wire:click="$set('status', 'diverifikasi')" variant="outline" size="sm" class="justify-center">Verifikasi</flux:button>
                    <flux:button type="button" wire:click="$set('status', 'diproses')" variant="outline" size="sm" class="justify-center">Proses</flux:button>
                    <flux:button type="button" wire:click="$set('status', 'selesai')" variant="outline" size="sm" class="justify-center">Selesai</flux:button>
                    <flux:button type="button" wire:click="$set('status', 'ditolak')" variant="outline" size="sm" class="justify-center">Tolak</flux:button>
                </div>

                <flux:select wire:model="status" label="Status pengaduan" required>
                    @foreach ($statuses as $value => $label)
                        <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="priority" label="Prioritas" required>
                    @foreach ($priorities as $value => $label)
                        <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:textarea
                    wire:model="message"
                    label="Tanggapan untuk mahasiswa"
                    placeholder="Tuliskan tanggapan, tindakan yang dilakukan, atau alasan penolakan..."
                    rows="5"
                />
                <flux:error name="message" />

                <flux:button type="submit" variant="primary" icon="paper-airplane" class="w-full" wire:loading.attr="disabled" wire:target="update">
                    <span wire:loading.remove wire:target="update">Simpan &amp; Kirim Tanggapan</span>
                    <span wire:loading wire:target="update">Menyimpan...</span>
                </flux:button>

                <p class="text-center text-[11px] leading-5 text-navy-400">
                    Tanggapan akan muncul pada riwayat pengaduan mahasiswa.
                </p>
            </form>

            <div class="mt-4 rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-navy-950">Informasi Sistem</h2>
                <dl class="mt-3 space-y-2.5 text-xs">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-navy-400">Dikirim</dt>
                        <dd class="font-medium text-navy-800">{{ $complaint->created_at->translatedFormat('d M Y, H.i') }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-navy-400">Pembaruan terakhir</dt>
                        <dd class="font-medium text-navy-800">{{ $complaint->updated_at->diffForHumans() }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-navy-400">Jumlah tanggapan</dt>
                        <dd class="font-medium text-navy-800">{{ $complaint->updates->count() }}</dd>
                    </div>
                </dl>
            </div>
        </aside>
    </div>
</div>
