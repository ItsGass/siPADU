<x-layouts::public :title="__('Kontak')">
    <section class="relative overflow-hidden border-b border-navy-100 bg-gradient-to-b from-navy-50/80 to-white">
        <div class="absolute inset-0 bg-grid-navy opacity-60"></div>
        <div class="absolute -bottom-32 left-1/3 size-96 rounded-full bg-gold-200/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <nav class="flex items-center gap-2 text-xs font-medium text-navy-500" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-navy-900">Home</a>
                <flux:icon.chevron-right class="size-3.5 text-navy-300" />
                <span class="text-navy-800">Kontak</span>
            </nav>

            <div class="mt-8 max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-navy-200 bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-navy-700 shadow-sm">
                    Hubungi Kami
                </span>
                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-navy-950 sm:text-5xl">
                    Ada pertanyaan? Kami siap membantu.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-navy-600">
                    Sampaikan pertanyaan, kendala teknis, atau kebutuhan informasi seputar layanan SIPADU. Tim kami akan merespons pada jam layanan kampus.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['icon' => 'map-pin', 'title' => 'Alamat Kampus', 'text' => 'Jl. Raya Serang - Pandeglang KM. 3, Kampus Universitas Pamulang Serang, Banten'],
                ['icon' => 'phone', 'title' => 'Telepon', 'text' => '(0254) 123-456'],
                ['icon' => 'envelope', 'title' => 'Email', 'text' => 'sipadu@unpam.ac.id'],
                ['icon' => 'clock', 'title' => 'Jam Layanan', 'text' => 'Senin - Jumat, 08.00 - 16.00 WIB'],
            ] as $item)
                <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm">
                    <span class="inline-flex size-11 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                        <flux:icon :name="$item['icon']" class="size-5" />
                    </span>
                    <h2 class="mt-4 text-sm font-semibold text-navy-950">{{ $item['title'] }}</h2>
                    <p class="mt-2 text-sm leading-6 text-navy-600">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-12 grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div class="space-y-6">
                <div class="rounded-2xl border border-navy-100 bg-navy-50/60 p-6">
                    <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                        <flux:icon.chat-bubble-left-right class="size-4 text-gold-600" />
                        Butuh jawaban cepat?
                    </h2>
                    <p class="mt-3 text-sm leading-7 text-navy-600">
                        Sebelum menghubungi kami, periksa halaman Cara Pengaduan. Sebagian besar pertanyaan tentang alur, status, dan bukti pendukung sudah dijelaskan di sana.
                    </p>
                    <flux:button :href="route('how-to')" variant="outline" size="sm" class="mt-4" icon:trailing="arrow-right">
                        Buka panduan
                    </flux:button>
                </div>

                <div class="relative overflow-hidden rounded-2xl border border-navy-100 bg-navy-900 p-6 text-white">
                    <div class="absolute inset-0 bg-grid-white opacity-40"></div>
                    <div class="relative">
                        <span class="inline-flex size-11 items-center justify-center rounded-xl bg-white/10 text-gold-400">
                            <flux:icon.building-library class="size-5" />
                        </span>
                        <h2 class="mt-4 text-base font-semibold">Universitas Pamulang Kampus Serang</h2>
                        <p class="mt-2 text-sm leading-6 text-navy-300">
                            Layanan pengaduan mahasiswa dikelola oleh unit pelayanan kampus bersama pengelola SIPADU.
                        </p>
                        <div class="mt-5 space-y-2 border-t border-white/10 pt-4 text-xs text-navy-300">
                            <p class="flex items-center gap-2"><flux:icon.clock class="size-3.5 text-gold-400" /> Senin - Jumat, 08.00 - 16.00 WIB</p>
                            <p class="flex items-center gap-2"><flux:icon.envelope class="size-3.5 text-gold-400" /> sipadu@unpam.ac.id</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gold-200 bg-gold-50/70 p-6">
                    <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                        <flux:icon.shield-exclamation class="size-4 text-gold-700" />
                        Kendala darurat?
                    </h2>
                    <p class="mt-3 text-sm leading-6 text-navy-600">
                        Untuk situasi darurat di lingkungan kampus, segera hubungi petugas keamanan atau layanan kampus secara langsung. SIPADU bukan kanal darurat.
                    </p>
                </div>
            </div>

            <livewire:contact-form />
        </div>
    </section>
</x-layouts::public>
