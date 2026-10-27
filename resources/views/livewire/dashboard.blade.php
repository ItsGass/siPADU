@php
    $hour = now()->hour;
    $greeting = $hour < 11 ? 'pagi' : ($hour < 15 ? 'siang' : ($hour < 18 ? 'sore' : 'malam'));
    $firstName = \Illuminate\Support\Str::before(auth()->user()->name, ' ');
@endphp

<div class="mx-auto w-full max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-navy-500">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Selamat {{ $greeting }}, {{ $firstName }}!</h1>
            <p class="mt-1 text-sm text-navy-500">Pantau pengaduan dan saran Anda di satu tempat.</p>
        </div>

        <flux:button :href="route('complaints.create')" variant="primary" icon="plus" class="justify-center">
            Buat Pengaduan
        </flux:button>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Total Pengaduan', 'value' => $stats['total'], 'icon' => 'clipboard-document-list', 'tone' => 'bg-navy-50 text-navy-700', 'hint' => 'Seluruh laporan Anda'],
            ['label' => 'Sedang Diproses', 'value' => $stats['diproses'], 'icon' => 'arrow-path', 'tone' => 'bg-amber-50 text-amber-600', 'hint' => 'Sedang ditindaklanjuti'],
            ['label' => 'Selesai', 'value' => $stats['selesai'], 'icon' => 'check-circle', 'tone' => 'bg-green-50 text-green-600', 'hint' => 'Telah ditangani'],
            ['label' => 'Saran & Kritik', 'value' => $stats['saran'], 'icon' => 'chat-bubble-left-right', 'tone' => 'bg-gold-50 text-gold-700', 'hint' => 'Masukan yang dikirim'],
        ] as $card)
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-navy-400">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-navy-950">{{ $card['value'] }}</p>
                    </div>
                    <span class="inline-flex size-11 items-center justify-center rounded-xl {{ $card['tone'] }}">
                        <flux:icon :name="$card['icon']" class="size-5" />
                    </span>
                </div>
                <p class="mt-3 text-xs text-navy-400">{{ $card['hint'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.55fr_0.85fr]">
        <div class="min-w-0 rounded-2xl border border-navy-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-navy-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-base font-semibold text-navy-950">Pengaduan Terbaru</h2>
                    <p class="text-xs text-navy-400">5 laporan terakhir yang Anda kirim</p>
                </div>
                <flux:button :href="route('complaints.index')" variant="ghost" size="sm" icon:trailing="arrow-right">Lihat semua</flux:button>
            </div>

            @if ($complaints->isEmpty())
                <div class="flex flex-col items-center justify-center px-6 py-14 text-center">
                    <span class="inline-flex size-14 items-center justify-center rounded-2xl bg-navy-50 text-navy-400">
                        <flux:icon.inbox class="size-7" />
                    </span>
                    <h3 class="mt-4 text-sm font-semibold text-navy-950">Belum ada pengaduan</h3>
                    <p class="mt-1 max-w-sm text-sm text-navy-500">Sampaikan keluhan atau aspirasi pertama Anda melalui SIPADU.</p>
                    <flux:button :href="route('complaints.create')" variant="primary" size="sm" class="mt-4" icon="plus">Buat Pengaduan</flux:button>
                </div>
            @else
                <ul class="divide-y divide-navy-50">
                    @foreach ($complaints as $complaint)
                        <li>
                            <a href="{{ route('complaints.show', $complaint->ticket_number) }}" wire:navigate class="group flex items-start gap-4 px-5 py-4 transition hover:bg-navy-50/50 sm:px-6">
                                <span class="mt-0.5 inline-flex size-10 shrink-0 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                    <flux:icon :name="$complaint->category->icon()" class="size-5" />
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="min-w-0 truncate text-sm font-semibold text-navy-950 group-hover:text-navy-700">{{ $complaint->title }}</p>
                                        <x-status-badge :status="$complaint->status" />
                                    </div>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-navy-400">
                                        <span class="font-mono">{{ $complaint->ticket_number }}</span>
                                        <span>{{ $complaint->created_at->translatedFormat('d M Y') }}</span>
                                        <span>{{ $complaint->category->label() }}</span>
                                        @if ($complaint->attachments_count > 0)
                                            <span class="inline-flex items-center gap-1"><flux:icon.paper-clip class="size-3" /> {{ $complaint->attachments_count }} bukti</span>
                                        @endif
                                    </div>
                                </div>
                                <flux:icon.chevron-right class="mt-3 size-4 shrink-0 text-navy-300 transition group-hover:translate-x-0.5 group-hover:text-navy-600" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="min-w-0 space-y-4">
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-navy-950">Aksi Cepat</h2>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('complaints.create') }}" wire:navigate class="flex items-center gap-3 rounded-xl border border-navy-100 p-3 transition hover:border-navy-200 hover:bg-navy-50/60">
                        <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-900 text-white"><flux:icon.plus class="size-4" /></span>
                        <span class="flex-1">
                            <span class="block text-sm font-medium text-navy-900">Buat pengaduan baru</span>
                            <span class="block text-xs text-navy-400">Laporkan masalah kampus</span>
                        </span>
                        <flux:icon.chevron-right class="size-4 text-navy-300" />
                    </a>
                    <a href="{{ route('suggestions.index') }}" wire:navigate class="flex items-center gap-3 rounded-xl border border-navy-100 p-3 transition hover:border-navy-200 hover:bg-navy-50/60">
                        <span class="inline-flex size-9 items-center justify-center rounded-lg bg-gold-400 text-navy-950"><flux:icon.light-bulb class="size-4" /></span>
                        <span class="flex-1">
                            <span class="block text-sm font-medium text-navy-900">Kirim saran &amp; kritik</span>
                            <span class="block text-xs text-navy-400">Bantu perbaiki layanan</span>
                        </span>
                        <flux:icon.chevron-right class="size-4 text-navy-300" />
                    </a>
                    <a href="{{ route('status.check') }}" class="flex items-center gap-3 rounded-xl border border-navy-100 p-3 transition hover:border-navy-200 hover:bg-navy-50/60">
                        <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-50 text-navy-700"><flux:icon.magnifying-glass class="size-4" /></span>
                        <span class="flex-1">
                            <span class="block text-sm font-medium text-navy-900">Cek status tiket</span>
                            <span class="block text-xs text-navy-400">Tanpa perlu login</span>
                        </span>
                        <flux:icon.chevron-right class="size-4 text-navy-300" />
                    </a>
                </div>
            </div>

            <div class="rounded-2xl bg-navy-900 p-5 text-white">
                <div class="flex items-center gap-2">
                    <flux:icon.shield-check class="size-5 text-gold-400" />
                    <h2 class="text-sm font-semibold">Privasi Anda terjaga</h2>
                </div>
                <p class="mt-2 text-xs leading-6 text-navy-300">
                    Identitas pelapor dapat disembunyikan saat mengirim pengaduan. Data hanya diakses oleh Anda dan admin kampus.
                </p>
                <a href="{{ route('how-to') }}" class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-gold-400 hover:text-gold-300">
                    Pelajari panduan
                    <flux:icon.arrow-right class="size-3.5" />
                </a>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5">
                <h2 class="text-sm font-semibold text-navy-950">Profil Singkat</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Nama</dt>
                        <dd class="text-right font-medium text-navy-800">{{ auth()->user()->name }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">NIM</dt>
                        <dd class="text-right font-medium text-navy-800">{{ auth()->user()->nim ?: '-' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-navy-400">Program Studi</dt>
                        <dd class="text-right font-medium text-navy-800">{{ auth()->user()->program_studi ?: '-' }}</dd>
                    </div>
                </dl>
                <flux:button :href="route('profile.edit')" variant="outline" size="sm" class="mt-4 w-full" icon="cog">Pengaturan akun</flux:button>
            </div>
        </div>
    </div>
</div>
