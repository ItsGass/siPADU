<div class="mx-auto w-full max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-gold-400">
                    <flux:icon.shield-check class="size-3" />
                    Panel Admin
                </span>
                <span class="text-xs text-navy-400">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Dashboard Admin</h1>
            <p class="mt-1 text-sm text-navy-500">Ringkasan pengaduan dan masukan mahasiswa Universitas Pamulang Kampus Serang.</p>
        </div>

        <div class="flex gap-2">
            <flux:button :href="route('admin.complaints.index')" variant="outline" icon="clipboard-document-list">Kelola Pengaduan</flux:button>
            <flux:button :href="route('home')" variant="ghost" icon="globe-alt">Situs Publik</flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ([
            ['label' => 'Total Pengaduan', 'value' => $stats['total'], 'icon' => 'clipboard-document-list', 'tone' => 'bg-navy-50 text-navy-700'],
            ['label' => 'Baru', 'value' => $stats['baru'], 'icon' => 'inbox-arrow-down', 'tone' => 'bg-blue-50 text-blue-600'],
            ['label' => 'Diproses', 'value' => $stats['diproses'], 'icon' => 'arrow-path', 'tone' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Selesai', 'value' => $stats['selesai'], 'icon' => 'check-circle', 'tone' => 'bg-green-50 text-green-600'],
            ['label' => 'Saran Belum Ditinjau', 'value' => $stats['saran_baru'], 'icon' => 'chat-bubble-left-right', 'tone' => 'bg-gold-50 text-gold-700'],
        ] as $card)
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-navy-950">{{ $card['value'] }}</p>
                    </div>
                    <span class="inline-flex size-10 items-center justify-center rounded-xl {{ $card['tone'] }}">
                        <flux:icon :name="$card['icon']" class="size-5" />
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.55fr_0.85fr]">
        <div class="min-w-0 space-y-6">
            <div class="rounded-2xl border border-navy-100 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-navy-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold text-navy-950">Pengaduan Terbaru</h2>
                        <p class="text-xs text-navy-400">Laporan terakhir yang masuk ke sistem</p>
                    </div>
                    <flux:button :href="route('admin.complaints.index')" variant="ghost" size="sm" icon:trailing="arrow-right">Semua</flux:button>
                </div>

                @if ($recent->isEmpty())
                    <div class="px-6 py-12 text-center text-sm text-navy-500">Belum ada pengaduan masuk.</div>
                @else
                    <ul class="divide-y divide-navy-50">
                        @foreach ($recent as $complaint)
                            <li>
                                <a href="{{ route('admin.complaints.show', $complaint) }}" wire:navigate class="group flex items-start gap-4 px-5 py-4 transition hover:bg-navy-50/50 sm:px-6">
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
                                            <span>{{ $complaint->is_anonymous ? 'Anonim' : $complaint->user->name }}</span>
                                            <span>{{ $complaint->created_at->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <flux:icon.chevron-right class="mt-3 size-4 shrink-0 text-navy-300 transition group-hover:translate-x-0.5 group-hover:text-navy-600" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-navy-950">Distribusi Status</h2>
                        <p class="text-xs text-navy-400">Perbandingan pengaduan berdasarkan status</p>
                    </div>
                    <flux:icon.chart-bar class="size-5 text-navy-300" />
                </div>

                <div class="mt-5 space-y-4">
                    @foreach ($chart as $item)
                        @php
                            $barColor = match ($item['status']->value) {
                                'baru' => 'bg-blue-500',
                                'diverifikasi' => 'bg-sky-500',
                                'diproses' => 'bg-amber-500',
                                'selesai' => 'bg-green-500',
                                'ditolak' => 'bg-red-500',
                                default => 'bg-navy-500',
                            };
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-navy-700">{{ $item['status']->label() }}</span>
                                <span class="text-navy-400">{{ $item['total'] }} pengaduan &middot; {{ $item['percentage'] }}%</span>
                            </div>
                            <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-navy-50">
                                <div class="h-2 rounded-full {{ $barColor }}" style="width: {{ max($item['percentage'], 2) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="min-w-0 space-y-4">
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-navy-950">Saran Terbaru</h2>
                    <flux:button :href="route('admin.suggestions.index')" variant="ghost" size="sm" icon:trailing="arrow-right">Kelola</flux:button>
                </div>

                @if ($recentSuggestions->isEmpty())
                    <p class="mt-4 text-xs text-navy-400">Belum ada saran/kritik masuk.</p>
                @else
                    <ul class="mt-4 space-y-3">
                        @foreach ($recentSuggestions as $suggestion)
                            <li class="rounded-xl border border-navy-100 p-3.5">
                                <div class="flex items-center gap-2">
                                    <flux:badge :color="$suggestion->type->color()" size="sm">{{ $suggestion->type->label() }}</flux:badge>
                                    @if (! $suggestion->is_reviewed)
                                        <span class="size-1.5 rounded-full bg-gold-500"></span>
                                    @endif
                                    <span class="ml-auto text-[10px] text-navy-400">{{ $suggestion->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mt-2 truncate text-xs font-semibold text-navy-900">{{ $suggestion->subject }}</p>
                                <p class="mt-1 line-clamp-2 text-xs leading-5 text-navy-500">{{ $suggestion->message }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="rounded-2xl bg-navy-900 p-5 text-white">
                <h2 class="flex items-center gap-2 text-sm font-semibold">
                    <flux:icon.clipboard-document-check class="size-4 text-gold-400" />
                    Pengingat
                </h2>
                <p class="mt-2 text-xs leading-6 text-navy-300">
                    Segera tinjau pengaduan berstatus <span class="font-semibold text-white">Baru</span> dan berikan tanggapan agar mahasiswa mendapatkan kepastian.
                </p>
                <flux:button :href="route('admin.complaints.index', ['status' => 'baru'])" variant="outline" size="sm" class="mt-4 w-full">Tinjau pengaduan baru</flux:button>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5">
                <h2 class="text-sm font-semibold text-navy-950">Akses Cepat</h2>
                <div class="mt-3 space-y-2 text-sm">
                    <a href="{{ route('admin.complaints.index') }}" wire:navigate class="flex items-center justify-between rounded-lg px-3 py-2 text-navy-600 hover:bg-navy-50">
                        Kelola pengaduan <flux:icon.chevron-right class="size-4 text-navy-300" />
                    </a>
                    <a href="{{ route('admin.suggestions.index') }}" wire:navigate class="flex items-center justify-between rounded-lg px-3 py-2 text-navy-600 hover:bg-navy-50">
                        Kelola saran &amp; kritik <flux:icon.chevron-right class="size-4 text-navy-300" />
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center justify-between rounded-lg px-3 py-2 text-navy-600 hover:bg-navy-50">
                        Lihat situs publik <flux:icon.chevron-right class="size-4 text-navy-300" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
