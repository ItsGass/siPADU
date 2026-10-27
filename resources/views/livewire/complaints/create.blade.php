<div class="mx-auto w-full max-w-5xl space-y-6">
    <div>
        <nav class="flex items-center gap-2 text-xs text-navy-400" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-navy-700">Dashboard</a>
            <flux:icon.chevron-right class="size-3" />
            <a href="{{ route('complaints.index') }}" wire:navigate class="hover:text-navy-700">Pengaduan Saya</a>
            <flux:icon.chevron-right class="size-3" />
            <span class="text-navy-600">Buat Pengaduan</span>
        </nav>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Buat Pengaduan Baru</h1>
        <p class="mt-1 text-sm text-navy-500">Isi data berikut dengan jelas agar laporan dapat segera ditindaklanjuti.</p>
    </div>

    <form wire:submit="submit" class="grid gap-6 lg:grid-cols-[1.5fr_0.8fr] lg:items-start">
        <div class="space-y-6">
            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-3 border-b border-navy-100 pb-4">
                    <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-900 text-xs font-bold text-gold-400">1</span>
                    <div>
                        <h2 class="text-sm font-semibold text-navy-950">Kategori pengaduan</h2>
                        <p class="text-xs text-navy-400">Pilih kategori yang paling sesuai dengan permasalahan Anda.</p>
                    </div>
                </div>

                <flux:radio.group wire:model="category" variant="cards" class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ($categories as $category)
                        <flux:radio
                            :value="$category->value"
                            :label="$category->label()"
                            :description="$category->description()"
                            :icon="$category->icon()"
                        />
                    @endforeach
                </flux:radio.group>

                <flux:error name="category" class="mt-2" />
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-3 border-b border-navy-100 pb-4">
                    <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-900 text-xs font-bold text-gold-400">2</span>
                    <div>
                        <h2 class="text-sm font-semibold text-navy-950">Detail permasalahan</h2>
                        <p class="text-xs text-navy-400">Jelaskan kronologi secara singkat, jelas, dan objektif.</p>
                    </div>
                </div>

                <div class="mt-4 space-y-4">
                    <flux:input
                        wire:model="title"
                        label="Judul pengaduan"
                        placeholder="Contoh: AC ruang laboratorium komputer tidak berfungsi"
                        maxlength="150"
                        required
                    />

                    <flux:textarea
                        wire:model="description"
                        label="Kronologi pengaduan"
                        placeholder="Ceritakan apa yang terjadi, kapan, dan dampaknya terhadap kegiatan Anda..."
                        rows="6"
                        required
                    />
                    <div class="flex justify-between text-xs text-navy-400">
                        <span>Minimal 30 karakter.</span>
                        <span x-data="{ count: $wire.entangle('description').live }" x-text="(count || '').length + '/5000'">0/5000</span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <flux:input
                            wire:model="location"
                            label="Lokasi kejadian (opsional)"
                            placeholder="Contoh: Gedung C, Lantai 2"
                            icon="map-pin"
                            maxlength="255"
                        />

                        <flux:input
                            wire:model="incident_date"
                            label="Tanggal kejadian (opsional)"
                            type="date"
                            max="{{ now()->toDateString() }}"
                        />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-3 border-b border-navy-100 pb-4">
                    <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-900 text-xs font-bold text-gold-400">3</span>
                    <div>
                        <h2 class="text-sm font-semibold text-navy-950">Bukti pendukung</h2>
                        <p class="text-xs text-navy-400">Unggah foto atau dokumen untuk memperkuat laporan Anda.</p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm font-medium text-navy-900">Foto / dokumen (opsional)</p>
                    <label for="complaint-photos" class="mt-2 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-navy-200 bg-navy-50/40 px-6 py-8 text-center transition hover:border-gold-400 hover:bg-gold-50/40">
                        <span class="inline-flex size-11 items-center justify-center rounded-full bg-white text-navy-700 shadow-sm">
                            <flux:icon.arrow-up-tray class="size-5" />
                        </span>
                        <span class="text-sm font-semibold text-navy-800">Klik untuk memilih file</span>
                        <span class="text-xs leading-5 text-navy-500">Maksimal 5 file. Format JPG, PNG, WEBP, atau PDF. Ukuran maks. 5 MB per file.</span>
                        <input
                            id="complaint-photos"
                            type="file"
                            wire:model="photos"
                            multiple
                            accept=".jpg,.jpeg,.png,.webp,.pdf"
                            class="sr-only"
                        >
                    </label>

                    <div wire:loading wire:target="photos" class="mt-3 flex items-center gap-2 text-xs text-navy-500">
                        <flux:icon.loading class="size-4" />
                        Mengunggah file...
                    </div>

                    <flux:error name="photos" class="mt-2" />
                    <flux:error name="photos.*" class="mt-2" />

                    @if (count($photos) > 0)
                        <p class="mt-4 text-xs font-medium text-navy-600">{{ count($photos) }} file dipilih</p>
                        <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            @foreach ($photos as $index => $photo)
                                <div class="group relative overflow-hidden rounded-xl border border-navy-100 bg-navy-50" wire:key="photo-{{ $index }}-{{ $photo->getFilename() }}">
                                    @if (str_starts_with((string) $photo->getMimeType(), 'image/'))
                                        <img src="{{ $photo->temporaryUrl() }}" alt="Pratinjau bukti {{ $index + 1 }}" class="h-28 w-full object-cover">
                                    @else
                                        <div class="flex h-28 flex-col items-center justify-center gap-2 p-3 text-center">
                                            <flux:icon.document-text class="size-7 text-navy-400" />
                                            <span class="line-clamp-2 text-[11px] font-medium text-navy-600">{{ $photo->getClientOriginalName() }}</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between gap-2 bg-white px-2 py-1.5">
                                        <span class="truncate text-[10px] text-navy-500">{{ $photo->getClientOriginalName() }}</span>
                                        <button type="button" wire:click="removePhoto({{ $index }})" class="inline-flex size-6 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-500 transition hover:bg-red-100" aria-label="Hapus file">
                                            <flux:icon.x-mark class="size-3.5" />
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-3 border-b border-navy-100 pb-4">
                    <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-900 text-xs font-bold text-gold-400">4</span>
                    <div>
                        <h2 class="text-sm font-semibold text-navy-950">Privasi pelaporan</h2>
                        <p class="text-xs text-navy-400">Tentukan apakah identitas Anda ditampilkan.</p>
                    </div>
                </div>

                <div class="mt-4 rounded-xl border border-navy-100 bg-navy-50/60 p-4">
                    <flux:switch
                        wire:model="is_anonymous"
                        label="Sembunyikan identitas saya (anonim)"
                        description="Nama Anda tidak akan ditampilkan. Admin tetap dapat menindaklanjuti laporan."
                    />
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <flux:button :href="route('complaints.index')" variant="ghost" wire:navigate>Batal</flux:button>
                <flux:button type="submit" variant="primary" icon="paper-airplane" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Kirim Pengaduan</span>
                    <span wire:loading wire:target="submit">Mengirim...</span>
                </flux:button>
            </div>
        </div>

        <aside class="space-y-4 lg:sticky lg:top-24">
            <div class="rounded-2xl border border-gold-200 bg-gold-50/70 p-5">
                <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                    <flux:icon.light-bulb class="size-4 text-gold-700" />
                    Tips pengaduan efektif
                </h2>
                <ul class="mt-3 space-y-2.5 text-xs leading-5 text-navy-600">
                    @foreach ([
                        'Tulis kronologi secara runtut: apa, kapan, di mana, dan dampaknya.',
                        'Sertakan bukti berupa foto atau dokumen bila tersedia.',
                        'Gunakan bahasa yang sopan dan hindari ujaran kebencian.',
                        'Satu pengaduan untuk satu permasalahan.',
                    ] as $tip)
                        <li class="flex gap-2">
                            <flux:icon.check class="mt-0.5 size-3.5 shrink-0 text-gold-700" />
                            <span>{{ $tip }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-2xl border border-navy-100 bg-white p-5">
                <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                    <flux:icon.clock class="size-4 text-navy-500" />
                    Setelah dikirim
                </h2>
                <ol class="mt-3 space-y-3 text-xs leading-5 text-navy-600">
                    <li class="flex gap-2"><span class="font-semibold text-navy-900">1.</span> Anda menerima nomor tiket unik.</li>
                    <li class="flex gap-2"><span class="font-semibold text-navy-900">2.</span> Admin memverifikasi laporan.</li>
                    <li class="flex gap-2"><span class="font-semibold text-navy-900">3.</span> Laporan diteruskan ke unit terkait.</li>
                    <li class="flex gap-2"><span class="font-semibold text-navy-900">4.</span> Anda dapat memantau status dan tanggapan.</li>
                </ol>
            </div>

            <div class="rounded-2xl bg-navy-900 p-5 text-white">
                <div class="flex items-center gap-2">
                    <flux:icon.shield-check class="size-4 text-gold-400" />
                    <h2 class="text-sm font-semibold">Data Anda aman</h2>
                </div>
                <p class="mt-2 text-xs leading-5 text-navy-300">
                    Bukti dan data pengaduan hanya dapat diakses oleh Anda dan admin kampus. File disimpan secara privat.
                </p>
            </div>
        </aside>
    </form>
</div>
