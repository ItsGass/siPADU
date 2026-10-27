<x-layouts::public :title="__('Cek Status Pengaduan')">
    <section class="relative overflow-hidden border-b border-navy-100 bg-gradient-to-b from-navy-50/80 to-white">
        <div class="absolute inset-0 bg-grid-navy opacity-60"></div>
        <div class="absolute -top-28 right-0 size-96 rounded-full bg-gold-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <nav class="flex items-center gap-2 text-xs font-medium text-navy-500" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-navy-900">Home</a>
                <flux:icon.chevron-right class="size-3.5 text-navy-300" />
                <span class="text-navy-800">Cek Status</span>
            </nav>

            <div class="mt-8 max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-navy-200 bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-navy-700 shadow-sm">
                    Lacak Pengaduan
                </span>
                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-navy-950 sm:text-5xl">
                    Cek status pengaduan Anda
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-navy-600">
                    Masukkan nomor tiket yang Anda terima setelah mengirim pengaduan. Tidak perlu login untuk melihat status dan riwayat penanganan.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <livewire:status-check />

        <div class="mt-10 rounded-2xl border border-navy-100 bg-white p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                    <flux:icon.information-circle class="size-5" />
                </span>
                <div>
                    <h2 class="text-sm font-semibold text-navy-950">Di mana nomor tiket saya?</h2>
                    <p class="mt-2 text-sm leading-7 text-navy-600">
                        Nomor tiket ditampilkan setelah pengaduan berhasil dikirim dan dapat dilihat kembali pada dashboard akun Anda. Formatnya seperti <span class="rounded-md bg-navy-50 px-2 py-1 font-mono text-xs font-semibold text-navy-800">SPD-261027-A1B2C</span>.
                    </p>
                    <p class="mt-2 text-sm leading-7 text-navy-600">
                        Jika nomor tiket hilang, masuk ke akun SIPADU Anda untuk melihat daftar pengaduan.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts::public>
