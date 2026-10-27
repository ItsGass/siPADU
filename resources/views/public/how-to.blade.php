<x-layouts::public :title="__('Cara Pengaduan')">
    <section class="relative overflow-hidden border-b border-navy-100 bg-gradient-to-b from-navy-50/80 to-white">
        <div class="absolute inset-0 bg-grid-navy opacity-60"></div>
        <div class="absolute -top-32 right-0 size-96 rounded-full bg-gold-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <nav class="flex items-center gap-2 text-xs font-medium text-navy-500" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-navy-900">Home</a>
                <flux:icon.chevron-right class="size-3.5 text-navy-300" />
                <span class="text-navy-800">Cara Pengaduan</span>
            </nav>

            <div class="mt-8 max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-navy-200 bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-navy-700 shadow-sm">
                    Panduan SIPADU
                </span>
                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-navy-950 sm:text-5xl">
                    Cara membuat pengaduan di SIPADU
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-navy-600">
                    Ikuti langkah berikut agar pengaduan Anda tercatat dengan baik dan dapat segera ditindaklanjuti oleh pihak kampus.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:items-start">
            <div class="space-y-5">
                @foreach ([
                    [
                        'step' => '01',
                        'title' => 'Daftar atau masuk ke akun Anda',
                        'text' => 'Buat akun menggunakan nama lengkap, NIM, program studi, dan email aktif. Jika sudah punya akun, langsung masuk melalui halaman login.',
                        'tips' => ['Gunakan NIM yang benar agar laporan mudah diverifikasi.', 'Email aktif diperlukan untuk kebutuhan komunikasi.'],
                    ],
                    [
                        'step' => '02',
                        'title' => 'Isi form pengaduan',
                        'text' => 'Pilih kategori yang sesuai, tulis judul singkat, lalu jelaskan kronologi kejadian secara jelas. Sertakan lokasi dan tanggal kejadian bila ada.',
                        'tips' => ['Tulis fakta secara objektif dan hindari ujaran kebencian.', 'Satu laporan untuk satu permasalahan agar mudah ditindaklanjuti.'],
                    ],
                    [
                        'step' => '03',
                        'title' => 'Lampirkan bukti pendukung',
                        'text' => 'Unggah foto atau dokumen pendukung seperti kondisi fasilitas, bukti pembayaran, atau tangkapan layar. Maksimal 5 file, masing-masing 5 MB.',
                        'tips' => ['Format yang didukung: JPG, PNG, WEBP, dan PDF.', 'Pastikan bukti tidak memuat data pribadi yang tidak diperlukan.'],
                    ],
                    [
                        'step' => '04',
                        'title' => 'Pantau status dan tanggapan',
                        'text' => 'Setelah dikirim, Anda akan menerima nomor tiket. Gunakan nomor tersebut untuk memantau status pengaduan melalui dashboard atau halaman cek status.',
                        'tips' => ['Simpan nomor tiket untuk pengecekan tanpa login.', 'Tanggapan resmi kampus tampil pada halaman detail pengaduan.'],
                    ],
                ] as $step)
                    <div class="relative rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-7">
                        <div class="flex flex-col gap-4 sm:flex-row">
                            <div class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-navy-900 text-lg font-bold text-gold-400">
                                {{ $step['step'] }}
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-navy-950">{{ $step['title'] }}</h2>
                                <p class="mt-2 text-sm leading-7 text-navy-600">{{ $step['text'] }}</p>
                                <ul class="mt-4 space-y-2">
                                    @foreach ($step['tips'] as $tip)
                                        <li class="flex gap-2 text-xs leading-5 text-navy-500">
                                            <flux:icon.check class="mt-0.5 size-3.5 shrink-0 text-gold-600" />
                                            {{ $tip }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="space-y-6 lg:sticky lg:top-28">
                <div class="rounded-2xl border border-navy-100 bg-navy-50/60 p-6">
                    <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                        <flux:icon.clipboard-document-check class="size-4 text-gold-600" />
                        Sebelum mengirim
                    </h2>
                    <ul class="mt-4 space-y-3 text-sm leading-6 text-navy-600">
                        @foreach ([
                            'Sudah memiliki akun SIPADU.',
                            'Data dan kronologi sudah diperiksa.',
                            'Bukti pendukung sudah disiapkan.',
                            'Laporan tidak mengandung SARA atau ujaran kebencian.',
                        ] as $item)
                            <li class="flex gap-3">
                                <flux:icon.check-circle class="mt-0.5 size-4 shrink-0 text-navy-700" />
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-2xl border border-gold-200 bg-gold-50/70 p-6">
                    <h2 class="flex items-center gap-2 text-sm font-semibold text-navy-950">
                        <flux:icon.information-circle class="size-4 text-gold-700" />
                        Perlu bantuan?
                    </h2>
                    <p class="mt-3 text-sm leading-6 text-navy-600">
                        Jika mengalami kendala saat membuat pengaduan, hubungi pengelola SIPADU melalui halaman kontak atau datang langsung ke layanan akademik kampus.
                    </p>
                    <flux:button :href="route('contact')" variant="outline" size="sm" class="mt-4" icon:trailing="arrow-right">
                        Hubungi kami
                    </flux:button>
                </div>

                <div class="rounded-2xl bg-navy-900 p-6 text-white">
                    <h2 class="text-sm font-semibold">Butuh melapor sekarang?</h2>
                    <p class="mt-2 text-xs leading-5 text-navy-300">Masuk ke akun Anda dan buat pengaduan dalam beberapa menit.</p>
                    <flux:button :href="auth()->check() ? route('complaints.create') : route('login')" variant="outline" size="sm" class="mt-4 w-full" icon="plus">
                        Buat Pengaduan
                    </flux:button>
                </div>
            </aside>
        </div>
    </section>

    <section class="border-y border-navy-100 bg-navy-50/50">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">Alur Status</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950">Arti status pengaduan Anda</h2>
                <p class="mt-4 text-sm leading-7 text-navy-600">Setiap perubahan status akan tercatat pada riwayat pengaduan.</p>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach (\App\Enums\ComplaintStatus::cases() as $status)
                    <div class="rounded-2xl border border-navy-100 bg-white p-5">
                        <span class="inline-flex size-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                            <flux:icon :name="$status->icon()" class="size-5" />
                        </span>
                        <p class="mt-4">
                            <flux:badge :color="$status->color()" size="sm">{{ $status->label() }}</flux:badge>
                        </p>
                        <p class="mt-3 text-xs leading-5 text-navy-600">{{ $status->description() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-600">FAQ</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-950">Pertanyaan yang sering diajukan</h2>
        </div>

        <div class="mt-10 space-y-3">
            @foreach ([
                ['q' => 'Apakah identitas saya bisa disembunyikan?', 'a' => 'Ya. Saat membuat pengaduan atau saran, Anda dapat memilih opsi anonim. Admin tetap dapat menindaklanjuti laporan, namun identitas Anda tidak ditampilkan kepada publik.'],
                ['q' => 'Berapa lama pengaduan ditindaklanjuti?', 'a' => 'Pengaduan umumnya ditinjau dalam 1-2 hari kerja. Waktu penanganan dapat berbeda tergantung kompleksitas dan unit yang menangani.'],
                ['q' => 'Bagaimana cara memantau status pengaduan?', 'a' => 'Masuk ke dashboard SIPADU untuk melihat seluruh pengaduan Anda, atau gunakan halaman Cek Status dengan memasukkan nomor tiket.'],
                ['q' => 'Apakah pengaduan bisa diubah setelah dikirim?', 'a' => 'Pengaduan yang sudah dikirim tidak dapat diubah agar riwayat tetap terjaga. Jika ada informasi tambahan, silakan sampaikan melalui tanggapan atau hubungi pengelola.'],
                ['q' => 'Apa perbedaan pengaduan dan saran/kritik?', 'a' => 'Pengaduan digunakan untuk melaporkan permasalahan yang perlu ditindaklanjuti. Saran/kritik digunakan untuk menyampaikan ide perbaikan atau masukan umum.'],
            ] as $index => $faq)
                <details class="group rounded-2xl border border-navy-100 bg-white p-5 transition open:border-navy-200 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-semibold text-navy-950">
                        {{ $faq['q'] }}
                        <flux:icon.plus class="size-4 shrink-0 text-navy-400 transition group-open:rotate-45" />
                    </summary>
                    <p class="mt-3 text-sm leading-7 text-navy-600">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </section>
</x-layouts::public>
