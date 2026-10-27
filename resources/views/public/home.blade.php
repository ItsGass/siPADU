<x-layouts::public :title="__('Sistem Pengaduan Mahasiswa')">
    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-navy-100 bg-gradient-to-b from-navy-50/70 via-white to-white">
        <div class="absolute inset-0 bg-grid-navy opacity-70"></div>
        <div class="absolute -top-40 right-0 size-[32rem] rounded-full bg-gold-200/30 blur-3xl"></div>
        <div class="absolute -bottom-48 left-0 size-[28rem] rounded-full bg-navy-200/40 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 py-20 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:py-28 lg:px-8">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-navy-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-navy-700 shadow-sm">
                    <span class="size-1.5 rounded-full bg-gold-500"></span>
                    Sistem Pengaduan Mahasiswa
                </span>

                <h1 class="mt-7 max-w-2xl text-4xl font-bold leading-[1.1] tracking-tight text-navy-950 sm:text-5xl lg:text-[3.5rem]">
                    Sampaikan aspirasi,<br>
                    wujudkan <span class="relative whitespace-nowrap text-navy-700">kampus lebih baik<span class="absolute inset-x-0 -bottom-2 h-1.5 rounded-full bg-gold-400"></span></span>.
                </h1>

                <p class="mt-7 max-w-xl text-base leading-8 text-navy-600 sm:text-lg">
                    SIPADU memudahkan mahasiswa Universitas Pamulang Kampus Serang menyampaikan pengaduan, kritik, dan saran secara aman, cepat, dan transparan.
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <flux:button :href="auth()->check() ? route('complaints.create') : route('login')" variant="primary" icon="plus" class="justify-center">
                        Buat Pengaduan
                    </flux:button>
                    <flux:button :href="route('how-to')" variant="outline" icon:trailing="arrow-right" class="justify-center">
                        Cara Pengaduan
                    </flux:button>
                </div>

                <div class="mt-9 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-navy-600">
                    <span class="inline-flex items-center gap-2">
                        <flux:icon.shield-check class="size-4 text-gold-600" />
                        Aman &amp; rahasia
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <flux:icon.clock class="size-4 text-gold-600" />
                        Diproses cepat
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <flux:icon.eye class="size-4 text-gold-600" />
                        Status transparan
                    </span>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                <div class="absolute -inset-5 rounded-[2.5rem] bg-gradient-to-br from-gold-200/50 via-white to-navy-100 blur-2xl"></div>

                <div class="relative rounded-3xl border border-navy-100 bg-white p-6 shadow-[0_30px_80px_-40px_rgba(11,44,90,0.45)] sm:p-7">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex size-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                <flux:icon.clipboard-document-list class="size-5" />
                            </span>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-navy-400">Nomor tiket</p>
                                <p class="font-mono text-sm font-semibold text-navy-900">SPD-261027-A1B2C</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-200">
                            <span class="size-1.5 animate-pulse rounded-full bg-amber-500"></span>
                            Diproses
                        </span>
                    </div>

                    <div class="mt-6 rounded-2xl bg-navy-50/60 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-navy-400">Fasilitas Kampus</p>
                        <p class="mt-1 text-base font-semibold leading-6 text-navy-900">AC ruang laboratorium komputer tidak berfungsi</p>
                        <p class="mt-2 text-xs text-navy-500">Gedung C, Lantai 2 &middot; 24 Oktober 2026</p>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="flex gap-3">
                            <span class="mt-0.5 inline-flex size-7 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700">
                                <flux:icon.check class="size-3.5" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-navy-900">Pengaduan diterima</p>
                                <p class="text-xs text-navy-500">24 Okt 2026, 09.14 WIB</p>
                            </div>
                        </div>
                        <div class="ml-3 h-6 w-px bg-navy-100"></div>
                        <div class="flex gap-3">
                            <span class="mt-0.5 inline-flex size-7 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-700">
                                <flux:icon.check-badge class="size-3.5" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-navy-900">Diverifikasi admin</p>
                                <p class="text-xs text-navy-500">24 Okt 2026, 13.40 WIB</p>
                            </div>
                        </div>
                        <div class="ml-3 h-6 w-px bg-navy-100"></div>
                        <div class="flex gap-3">
                            <span class="mt-0.5 inline-flex size-7 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                                <flux:icon.arrow-path class="size-3.5" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-navy-900">Ditindaklanjuti unit terkait</p>
                                <p class="text-xs text-navy-500">Estimasi selesai 2 hari kerja</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t border-navy-100 pt-4">
                        <span class="text-xs text-navy-500">Tanggapan kampus</span>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-navy-700">
                            Lihat detail
                            <flux:icon.chevron-right class="size-3.5" />
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
            <dl class="grid gap-4 rounded-2xl border border-navy-100 bg-white/80 p-6 shadow-sm backdrop-blur sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['value' => '6', 'label' => 'Kategori pengaduan'],
                    ['value' => '100%', 'label' => 'Laporan tercatat'],
                    ['value' => '24/7', 'label' => 'Akses kapan saja'],
                    ['value' => '2 Hari', 'label' => 'Rata-rata respon'],
                ] as $stat)
                    <div class="border-navy-100 px-2 sm:border-e sm:last:border-e-0">
                        <dt class="text-2xl font-bold tracking-tight text-navy-900">{{ $stat['value'] }}</dt>
                        <dd class="mt-1 text-sm text-navy-500">{{ $stat['label'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- Manfaat --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Mengapa SIPADU?</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950 sm:text-4xl">Satu kanal untuk semua aspirasi mahasiswa</h2>
            <p class="mt-4 text-base leading-7 text-navy-600">
                Memudahkan mahasiswa menyampaikan pengaduan dan membantu pihak kampus menerima serta mengelola laporan secara terstruktur.
            </p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['icon' => 'paper-airplane', 'title' => 'Memudahkan Mahasiswa', 'text' => 'Sampaikan pengaduan tanpa prosedur berbelit, langsung dari mana saja.'],
                ['icon' => 'chat-bubble-left-right', 'title' => 'Wadah Kritik & Saran', 'text' => 'Ruang resmi untuk kritik dan saran yang membangun bagi kampus.'],
                ['icon' => 'clipboard-document-check', 'title' => 'Dikelola Kampus', 'text' => 'Pengaduan diterima, diverifikasi, dan ditindaklanjuti oleh unit terkait.'],
                ['icon' => 'arrow-trending-up', 'title' => 'Layanan Lebih Baik', 'text' => 'Setiap masukan menjadi dasar peningkatan kualitas pelayanan kampus.'],
            ] as $item)
                <div class="group rounded-2xl border border-navy-100 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-navy-200 hover:shadow-xl hover:shadow-navy-900/5">
                    <span class="inline-flex size-12 items-center justify-center rounded-xl bg-navy-50 text-navy-700 transition group-hover:bg-navy-900 group-hover:text-white">
                        <flux:icon :name="$item['icon']" class="size-6" />
                    </span>
                    <h3 class="mt-5 text-base font-semibold text-navy-950">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-navy-600">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Fitur --}}
    <section id="fitur" class="border-y border-navy-100 bg-navy-50/50">
        <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Fitur Utama</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950 sm:text-4xl">Semua yang Anda butuhkan untuk melapor</h2>
                <p class="mt-4 max-w-xl text-base leading-7 text-navy-600">
                    Dirancang agar proses pengaduan terasa sederhana bagi mahasiswa, sekaligus mudah dikelola oleh pihak kampus.
                </p>

                <div class="mt-8 space-y-4">
                    @foreach ([
                        ['icon' => 'document-plus', 'title' => 'Form pengaduan terstruktur', 'text' => 'Isi kategori, kronologi, lokasi, dan tanggal kejadian dengan jelas.'],
                        ['icon' => 'photo', 'title' => 'Upload bukti atau foto', 'text' => 'Lampirkan hingga 5 foto atau dokumen pendukung agar laporan lebih kuat.'],
                        ['icon' => 'clock', 'title' => 'Status pengaduan real-time', 'text' => 'Pantau perjalanan laporan dari diterima hingga selesai ditindaklanjuti.'],
                        ['icon' => 'light-bulb', 'title' => 'Saran & kritik terpisah', 'text' => 'Kirim ide perbaikan atau kritik tanpa harus membuat pengaduan formal.'],
                    ] as $feature)
                        <div class="flex gap-4 rounded-xl border border-transparent p-3 transition hover:border-navy-100 hover:bg-white">
                            <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-xl bg-white text-navy-700 shadow-sm ring-1 ring-navy-100">
                                <flux:icon :name="$feature['icon']" class="size-5" />
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-navy-950">{{ $feature['title'] }}</h3>
                                <p class="mt-1 text-sm leading-6 text-navy-600">{{ $feature['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 rounded-[2rem] bg-gradient-to-tr from-gold-200/50 to-navy-100 blur-2xl"></div>
                <div class="relative grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="flex h-full flex-col rounded-2xl border border-navy-100 bg-white p-5 shadow-lg shadow-navy-900/5">
                        <span class="inline-flex size-10 items-center justify-center rounded-xl bg-gold-50 text-gold-700">
                            <flux:icon.photo class="size-5" />
                        </span>
                        <p class="mt-4 text-sm font-semibold text-navy-950">Bukti pendukung</p>
                        <p class="mt-1 text-xs leading-5 text-navy-500">Foto kondisi fasilitas atau dokumen terkait.</p>
                        <div class="mt-4 grid grid-cols-3 gap-2">
                            <div class="aspect-square rounded-lg bg-gradient-to-br from-navy-100 to-navy-200"></div>
                            <div class="aspect-square rounded-lg bg-gradient-to-br from-gold-100 to-gold-200"></div>
                            <div class="flex aspect-square items-center justify-center rounded-lg border border-dashed border-navy-200 text-navy-400">
                                <flux:icon.plus class="size-4" />
                            </div>
                        </div>
                    </div>

                    <div class="flex h-full flex-col rounded-2xl border border-navy-100 bg-white p-5 shadow-lg shadow-navy-900/5">
                        <span class="inline-flex size-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                            <flux:icon.chart-bar class="size-5" />
                        </span>
                        <p class="mt-4 text-sm font-semibold text-navy-950">Pantau tindak lanjut</p>
                        <p class="mt-1 text-xs leading-5 text-navy-500">Lihat riwayat tanggapan kampus secara transparan.</p>
                        <div class="mt-auto space-y-2 pt-4">
                            <div class="h-2 w-full rounded-full bg-navy-100">
                                <div class="h-2 w-4/5 rounded-full bg-navy-700"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-navy-500">
                                <span>Progres penanganan</span>
                                <span class="font-semibold text-navy-800">80%</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-navy-100 bg-navy-900 p-5 text-white shadow-lg shadow-navy-900/20 sm:col-span-2">
                        <div class="flex items-start gap-4">
                            <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-xl bg-white/10 text-gold-400">
                                <flux:icon.shield-check class="size-5" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold">Privasi terlindungi</p>
                                <p class="mt-1 text-xs leading-5 text-navy-300">Identitas pelapor dapat disembunyikan. Data hanya diakses mahasiswa terkait dan admin kampus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara pengaduan --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Cara Pengaduan</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950 sm:text-4xl">Empat langkah, laporan Anda tercatat</h2>
                <p class="mt-4 text-base leading-7 text-navy-600">Prosesnya singkat dan dapat dilakukan kapan saja melalui perangkat Anda.</p>
            </div>
            <flux:button :href="route('how-to')" variant="ghost" icon:trailing="arrow-right">Panduan lengkap</flux:button>
        </div>

        <div class="relative mt-12 grid gap-6 lg:grid-cols-4">
            <div class="absolute left-0 right-0 top-7 hidden h-px bg-navy-200 lg:block"></div>
            @foreach ([
                ['step' => '01', 'title' => 'Buat akun / masuk', 'text' => 'Daftar dengan NIM dan program studi, lalu masuk ke akun Anda.'],
                ['step' => '02', 'title' => 'Isi form pengaduan', 'text' => 'Pilih kategori, tulis kronologi, dan lampirkan bukti pendukung.'],
                ['step' => '03', 'title' => 'Pantau status', 'text' => 'Gunakan nomor tiket untuk memantau proses penanganan laporan.'],
                ['step' => '04', 'title' => 'Terima tanggapan', 'text' => 'Baca tanggapan resmi kampus hingga pengaduan dinyatakan selesai.'],
            ] as $step)
                <div class="relative">
                    <div class="relative z-10 flex size-14 items-center justify-center rounded-2xl border border-navy-100 bg-white text-lg font-bold text-navy-900 shadow-sm">
                        {{ $step['step'] }}
                    </div>
                    <h3 class="mt-5 text-base font-semibold text-navy-950">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-navy-600">{{ $step['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Tentang band --}}
    <section class="relative overflow-hidden bg-navy-950">
        <div class="absolute inset-0 bg-grid-white opacity-50"></div>
        <div class="absolute -right-24 top-1/2 size-96 -translate-y-1/2 rounded-full bg-gold-500/10 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-gold-300">
                    Tentang SIPADU
                </span>
                <h2 class="mt-6 text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl">
                    Menjembatani mahasiswa dan kampus dalam satu ruang yang terbuka.
                </h2>
                <p class="mt-5 max-w-xl text-base leading-8 text-navy-300">
                    SIPADU hadir sebagai wadah resmi penyampaian pengaduan, kritik, dan saran mahasiswa Universitas Pamulang Kampus Serang. Kami percaya, aspirasi yang tersampaikan dengan baik adalah awal dari pelayanan kampus yang lebih baik.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <flux:button :href="route('about')" variant="filled" icon:trailing="arrow-right">Selengkapnya</flux:button>
                    <flux:button :href="route('contact')" variant="ghost" class="!text-white hover:!bg-white/10">Hubungi kami</flux:button>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['icon' => 'academic-cap', 'title' => 'Institusi', 'text' => 'Universitas Pamulang Kampus Serang'],
                    ['icon' => 'user-group', 'title' => 'Pengguna', 'text' => 'Seluruh mahasiswa aktif'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Layanan', 'text' => 'Pengaduan, saran & kritik'],
                    ['icon' => 'clock', 'title' => 'Komitmen', 'text' => 'Respon cepat & transparan'],
                ] as $item)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <flux:icon :name="$item['icon']" class="size-5 text-gold-400" />
                        <p class="mt-4 text-sm font-semibold text-white">{{ $item['title'] }}</p>
                        <p class="mt-1 text-xs leading-5 text-navy-300">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border border-gold-200 bg-gradient-to-br from-gold-50 via-white to-navy-50 p-8 sm:p-12">
            <div class="absolute -right-16 -top-16 size-64 rounded-full bg-gold-200/50 blur-3xl"></div>
            <div class="relative grid gap-8 lg:grid-cols-[1.3fr_0.7fr] lg:items-center">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl">Punya keluhan atau ide untuk kampus?</h2>
                    <p class="mt-3 max-w-xl text-sm leading-7 text-navy-600">
                        Jangan biarkan aspirasi Anda berhenti di pikiran. Sampaikan melalui SIPADU dan ikut berkontribusi dalam perbaikan layanan kampus.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row lg:justify-end">
                    <flux:button :href="auth()->check() ? route('complaints.create') : route('login')" variant="primary" icon="plus">Buat Pengaduan</flux:button>
                    <flux:button :href="route('suggestions.index')" variant="outline" icon="light-bulb">Kirim Saran</flux:button>
                </div>
            </div>
        </div>
    </section>
</x-layouts::public>
