<x-layouts::public :title="__('Tentang SIPADU')">
    <section class="relative overflow-hidden bg-navy-950">
        <div class="absolute inset-0 bg-grid-white opacity-50"></div>
        <div class="absolute -top-24 right-0 size-96 rounded-full bg-gold-500/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <nav class="flex items-center gap-2 text-xs font-medium text-navy-300" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                <flux:icon.chevron-right class="size-3.5 text-navy-500" />
                <span class="text-gold-300">Tentang SIPADU</span>
            </nav>

            <div class="mt-8 grid gap-12 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-gold-300">
                        Tentang Kami
                    </span>
                    <h1 class="mt-6 max-w-3xl text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl">
                        Wadah aspirasi mahasiswa untuk kampus yang terus berkembang.
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-navy-300">
                        SIPADU adalah Sistem Pengaduan Mahasiswa Universitas Pamulang Kampus Serang yang dirancang untuk mempermudah penyampaian pengaduan, kritik, dan saran secara aman, terstruktur, dan transparan.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @foreach ([
                        ['value' => '6', 'label' => 'Kategori layanan'],
                        ['value' => '100%', 'label' => 'Laporan tercatat'],
                        ['value' => '2 Hari', 'label' => 'Rata-rata respon'],
                        ['value' => '24/7', 'label' => 'Akses layanan'],
                    ] as $stat)
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <p class="text-2xl font-bold text-gold-400">{{ $stat['value'] }}</p>
                            <p class="mt-1 text-xs text-navy-300">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Latar Belakang</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950">Mengapa SIPADU hadir?</h2>
                <p class="mt-5 text-sm leading-7 text-navy-600">
                    Setiap mahasiswa berhak menyampaikan pendapat dan keluhan terhadap layanan kampus. Namun, tidak semua aspirasi tersampaikan melalui jalur yang tepat. SIPADU hadir untuk menjembatani kebutuhan tersebut.
                </p>
                <p class="mt-4 text-sm leading-7 text-navy-600">
                    Dengan satu kanal resmi, mahasiswa dapat melapor kapan saja, sementara pihak kampus memperoleh data yang terorganisir untuk ditindaklanjuti oleh unit terkait.
                </p>

                <div class="mt-8 rounded-2xl border border-gold-200 bg-gold-50/70 p-6">
                    <div class="flex gap-3">
                        <flux:icon.sparkles class="mt-0.5 size-5 shrink-0 text-gold-600" />
                        <p class="text-sm font-medium leading-7 text-navy-800">
                            “Aspirasi yang tersampaikan dengan baik adalah langkah pertama menuju pelayanan kampus yang lebih baik.”
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                @foreach ([
                    ['icon' => 'paper-airplane', 'title' => 'Memudahkan Mahasiswa', 'text' => 'Pengaduan dapat dibuat secara mandiri tanpa prosedur yang rumit.'],
                    ['icon' => 'chat-bubble-left-right', 'title' => 'Wadah Kritik & Saran', 'text' => 'Ruang resmi untuk menyampaikan masukan yang membangun.'],
                    ['icon' => 'clipboard-document-check', 'title' => 'Membantu Kampus', 'text' => 'Membantu pihak kampus menerima dan mengelola pengaduan secara rapi.'],
                    ['icon' => 'arrow-trending-up', 'title' => 'Meningkatkan Layanan', 'text' => 'Menjadi dasar evaluasi dan peningkatan kualitas pelayanan kampus.'],
                ] as $item)
                    <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg hover:shadow-navy-900/5">
                        <span class="inline-flex size-11 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                            <flux:icon :name="$item['icon']" class="size-5" />
                        </span>
                        <h3 class="mt-4 text-sm font-semibold text-navy-950">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-navy-600">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-navy-100 bg-navy-50/50">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Arah &amp; Tujuan</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950">Yang kami perjuangkan</h2>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-navy-100 bg-white p-8">
                    <span class="inline-flex size-12 items-center justify-center rounded-xl bg-navy-900 text-gold-400">
                        <flux:icon.eye class="size-6" />
                    </span>
                    <h3 class="mt-5 text-xl font-bold text-navy-950">Visi</h3>
                    <p class="mt-3 text-sm leading-7 text-navy-600">
                        Menjadi kanal pengaduan mahasiswa yang terpercaya, mudah diakses, dan mampu mendorong terciptanya budaya pelayanan kampus yang responsif dan akuntabel.
                    </p>
                </div>

                <div class="rounded-2xl border border-navy-100 bg-white p-8">
                    <span class="inline-flex size-12 items-center justify-center rounded-xl bg-gold-400 text-navy-950">
                        <flux:icon.flag class="size-6" />
                    </span>
                    <h3 class="mt-5 text-xl font-bold text-navy-950">Misi</h3>
                    <ul class="mt-3 space-y-3 text-sm leading-6 text-navy-600">
                        @foreach ([
                            'Menyediakan kanal pengaduan yang mudah, aman, dan terintegrasi.',
                            'Memastikan setiap pengaduan tercatat dan ditindaklanjuti dengan jelas.',
                            'Mendorong partisipasi mahasiswa dalam perbaikan layanan kampus.',
                            'Menyajikan data aspirasi sebagai bahan evaluasi kampus.',
                        ] as $mission)
                            <li class="flex gap-3">
                                <flux:icon.check-circle class="mt-0.5 size-4 shrink-0 text-gold-600" />
                                <span>{{ $mission }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[1fr_1fr] lg:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Lingkup Layanan</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950">Apa saja yang bisa dilaporkan?</h2>
                <p class="mt-4 text-sm leading-7 text-navy-600">
                    SIPADU menerima pengaduan terkait berbagai aspek layanan kampus. Pilih kategori yang paling sesuai agar laporan dapat diteruskan ke unit yang tepat.
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach (\App\Enums\ComplaintCategory::cases() as $category)
                    <div class="flex items-center gap-3 rounded-xl border border-navy-100 bg-white px-4 py-3.5">
                        <span class="inline-flex size-9 items-center justify-center rounded-lg bg-navy-50 text-navy-700">
                            <flux:icon :name="$category->icon()" class="size-4" />
                        </span>
                        <span class="text-sm font-medium text-navy-800">{{ $category->label() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-navy-900 p-8 sm:p-12">
            <div class="grid gap-8 lg:grid-cols-[1.4fr_0.6fr] lg:items-center">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Siap menyampaikan aspirasi Anda?</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-navy-300">
                        Bergabunglah bersama mahasiswa lain yang telah berkontribusi melalui SIPADU. Satu laporan Anda berarti bagi kemajuan kampus.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row lg:justify-end">
                    <flux:button :href="auth()->check() ? route('complaints.create') : route('login')" variant="outline" icon="plus">Buat Pengaduan</flux:button>
                    <flux:button :href="route('how-to')" variant="ghost" class="!text-white hover:!bg-white/10">Cara Pengaduan</flux:button>
                </div>
            </div>
        </div>
    </section>
</x-layouts::public>
