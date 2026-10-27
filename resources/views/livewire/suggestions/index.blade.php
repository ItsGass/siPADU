<div class="mx-auto w-full max-w-6xl space-y-6">
    <div>
        <nav class="flex items-center gap-2 text-xs text-navy-400" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-navy-700">Dashboard</a>
            <flux:icon.chevron-right class="size-3" />
            <span class="text-navy-600">Saran &amp; Kritik</span>
        </nav>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Saran &amp; Kritik</h1>
        <p class="mt-1 text-sm text-navy-500">Bantu kami meningkatkan layanan kampus dengan ide dan masukan Anda.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_1fr] lg:items-start">
        <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-center gap-3 border-b border-navy-100 pb-4">
                <span class="inline-flex size-10 items-center justify-center rounded-xl bg-gold-400 text-navy-950">
                    <flux:icon.light-bulb class="size-5" />
                </span>
                <div>
                    <h2 class="text-sm font-semibold text-navy-950">Kirim masukan baru</h2>
                    <p class="text-xs text-navy-400">Sampaikan saran atau kritik yang membangun.</p>
                </div>
            </div>

            <form wire:submit="submit" class="mt-4 space-y-4">
                <flux:radio.group wire:model="type" variant="cards" class="grid gap-3 sm:grid-cols-2">
                    @foreach ($types as $type)
                        <flux:radio
                            :value="$type->value"
                            :label="$type->label()"
                            :description="$type === \App\Enums\SuggestionType::Saran ? 'Ide atau usulan perbaikan' : 'Masukan terhadap layanan kampus'"
                            :icon="$type->icon()"
                        />
                    @endforeach
                </flux:radio.group>

                <flux:input
                    wire:model="subject"
                    label="Subjek"
                    placeholder="Ringkasan singkat masukan Anda"
                    maxlength="150"
                    required
                />

                <flux:textarea
                    wire:model="message"
                    label="Isi saran / kritik"
                    placeholder="Tuliskan masukan Anda secara jelas dan konstruktif..."
                    rows="6"
                    required
                />
                <p class="text-xs text-navy-400">Minimal 15 karakter. Hindari kata kasar atau ujaran kebencian.</p>

                <div class="rounded-xl border border-navy-100 bg-navy-50/60 p-4">
                    <flux:switch
                        wire:model="is_anonymous"
                        label="Kirim sebagai anonim"
                        description="Nama Anda tidak akan ditampilkan pada daftar masukan."
                    />
                </div>

                <flux:button type="submit" variant="primary" icon="paper-airplane" class="w-full" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Kirim Masukan</span>
                    <span wire:loading wire:target="submit">Mengirim...</span>
                </flux:button>
            </form>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-navy-950">Masukan Anda</h2>
                    <p class="text-xs text-navy-400">{{ $suggestions->total() }} masukan terkirim</p>
                </div>
                <div wire:loading class="flex items-center gap-2 text-xs text-navy-400">
                    <flux:icon.loading class="size-4" /> Memuat...
                </div>
            </div>

            @if ($suggestions->isEmpty())
                <div class="rounded-2xl border border-dashed border-navy-200 bg-white px-6 py-14 text-center">
                    <span class="mx-auto inline-flex size-14 items-center justify-center rounded-2xl bg-navy-50 text-navy-300">
                        <flux:icon.chat-bubble-left-right class="size-7" />
                    </span>
                    <h3 class="mt-4 text-sm font-semibold text-navy-950">Belum ada masukan</h3>
                    <p class="mt-1 text-sm text-navy-500">Saran atau kritik pertama Anda akan tampil di sini.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($suggestions as $suggestion)
                        <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm" wire:key="suggestion-{{ $suggestion->id }}">
                            <div class="flex flex-wrap items-center gap-2">
                                <flux:badge :color="$suggestion->type->color()" size="sm" :icon="$suggestion->type->icon()">{{ $suggestion->type->label() }}</flux:badge>
                                @if ($suggestion->is_reviewed)
                                    <flux:badge color="green" size="sm" icon="check-badge">Sudah ditinjau</flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm" icon="clock">Menunggu tinjauan</flux:badge>
                                @endif
                                <span class="ml-auto text-xs text-navy-400">{{ $suggestion->created_at->translatedFormat('d M Y') }}</span>
                            </div>

                            <h3 class="mt-3 text-sm font-semibold text-navy-950">{{ $suggestion->subject }}</h3>
                            <p class="mt-1.5 whitespace-pre-line text-sm leading-6 text-navy-600">{{ $suggestion->message }}</p>

                            @if ($suggestion->is_anonymous)
                                <p class="mt-3 inline-flex items-center gap-1 text-[11px] text-navy-400">
                                    <flux:icon.eye-slash class="size-3" /> Dikirim sebagai anonim
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="pt-2">
                    {{ $suggestions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
