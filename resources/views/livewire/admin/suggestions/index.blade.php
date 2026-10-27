<div class="mx-auto w-full max-w-7xl space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-gold-400">
                    <flux:icon.shield-check class="size-3" /> Panel Admin
                </span>
                <span class="text-xs text-navy-400">{{ $suggestions->total() }} masukan</span>
            </div>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Kelola Saran &amp; Kritik</h1>
            <p class="mt-1 text-sm text-navy-500">Tinjau masukan mahasiswa dan tandai yang sudah ditindaklanjuti.</p>
        </div>

        <flux:button :href="route('admin.dashboard')" variant="outline" icon="arrow-left" wire:navigate>Dashboard Admin</flux:button>
    </div>

    <div class="rounded-2xl border border-navy-100 bg-white p-4 shadow-sm sm:p-5">
        <div class="grid gap-3 sm:grid-cols-[220px_220px_auto] sm:items-end">
            <flux:select wire:model.live="type" label="Jenis masukan">
                <flux:select.option value="">Semua jenis</flux:select.option>
                @foreach ($types as $type)
                    <flux:select.option :value="$type->value">{{ $type->label() }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="reviewed" label="Status tinjauan">
                <flux:select.option value="">Semua status</flux:select.option>
                <flux:select.option value="0">Belum ditinjau</flux:select.option>
                <flux:select.option value="1">Sudah ditinjau</flux:select.option>
            </flux:select>

            <div class="flex items-center gap-2">
                <flux:button wire:click="$set('type', '')" variant="ghost" icon="arrow-path" class="justify-center">Reset</flux:button>
                <div wire:loading class="flex items-center gap-1.5 text-xs text-navy-400">
                    <flux:icon.loading class="size-4" /> Memuat...
                </div>
            </div>
        </div>
    </div>

    @if ($suggestions->isEmpty())
        <div class="rounded-2xl border border-dashed border-navy-200 bg-white px-6 py-16 text-center">
            <span class="mx-auto inline-flex size-16 items-center justify-center rounded-2xl bg-navy-50 text-navy-300">
                <flux:icon.chat-bubble-left-right class="size-8" />
            </span>
            <h2 class="mt-4 text-base font-semibold text-navy-950">Belum ada masukan</h2>
            <p class="mt-1 text-sm text-navy-500">Saran dan kritik dari mahasiswa akan tampil di sini.</p>
        </div>
    @else
        <div class="grid gap-4 lg:grid-cols-2">
            @foreach ($suggestions as $suggestion)
                <div class="flex flex-col rounded-2xl border border-navy-100 bg-white p-5 shadow-sm" wire:key="suggestion-{{ $suggestion->id }}">
                    <div class="flex flex-wrap items-center gap-2">
                        <flux:badge :color="$suggestion->type->color()" size="sm" :icon="$suggestion->type->icon()">{{ $suggestion->type->label() }}</flux:badge>
                        @if ($suggestion->is_reviewed)
                            <flux:badge color="green" size="sm" icon="check-badge">Sudah ditinjau</flux:badge>
                        @else
                            <flux:badge color="amber" size="sm" icon="clock">Belum ditinjau</flux:badge>
                        @endif
                        <span class="ml-auto text-[11px] text-navy-400">{{ $suggestion->created_at->translatedFormat('d M Y, H.i') }}</span>
                    </div>

                    <h2 class="mt-3 text-sm font-semibold text-navy-950">{{ $suggestion->subject }}</h2>
                    <p class="mt-2 flex-1 whitespace-pre-line text-sm leading-6 text-navy-600">{{ $suggestion->message }}</p>

                    <div class="mt-4 flex items-center justify-between gap-3 border-t border-navy-50 pt-3">
                        <div class="flex items-center gap-2">
                            <flux:avatar :name="$suggestion->reporterName()" :initials="$suggestion->is_anonymous ? 'AN' : ($suggestion->user?->initials() ?? 'AN')" size="sm" />
                            <div>
                                <p class="text-xs font-medium text-navy-800">{{ $suggestion->reporterName() }}</p>
                                <p class="text-[10px] text-navy-400">{{ $suggestion->is_anonymous ? 'Identitas disembunyikan' : ($suggestion->user?->nim ?? '-') }}</p>
                            </div>
                        </div>

                        <flux:button
                            wire:click="toggleReviewed({{ $suggestion->id }})"
                            variant="{{ $suggestion->is_reviewed ? 'ghost' : 'outline' }}"
                            size="sm"
                            :icon="$suggestion->is_reviewed ? 'arrow-uturn-left' : 'check'"
                        >
                            {{ $suggestion->is_reviewed ? 'Batal tinjau' : 'Tandai ditinjau' }}
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-2">
            {{ $suggestions->links() }}
        </div>
    @endif
</div>
