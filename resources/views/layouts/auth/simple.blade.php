@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#F6F8FC] text-navy-950 antialiased">
        <div class="grid min-h-screen lg:grid-cols-[1.05fr_1fr]">
            <aside class="relative hidden overflow-hidden bg-navy-950 p-12 lg:flex lg:flex-col">
                <div class="absolute inset-0 bg-grid-white opacity-60"></div>
                <div class="absolute -top-32 -right-24 size-96 rounded-full bg-navy-700/40 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-16 size-80 rounded-full bg-gold-500/10 blur-3xl"></div>

                <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-3">
                    <x-app-logo-icon class="size-12 ring-1 ring-white/15" />
                    <span class="leading-tight">
                        <span class="block text-2xl font-bold tracking-tight text-white">SIPADU</span>
                        <span class="block text-[10px] font-semibold uppercase tracking-[0.14em] text-gold-400">Universitas Pamulang Kampus Serang</span>
                    </span>
                </a>

                <div class="relative z-10 my-auto max-w-md py-16">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-gold-300">
                        <span class="size-1.5 rounded-full bg-gold-400"></span>
                        Sistem Pengaduan Mahasiswa
                    </span>

                    <h1 class="mt-7 text-4xl font-bold leading-[1.15] tracking-tight text-white">
                        Suara Anda,<br>
                        <span class="text-gold-400">Perbaikan Kampus.</span>
                    </h1>

                    <p class="mt-5 text-base leading-7 text-navy-300">
                        Sampaikan pengaduan, kritik, dan saran secara aman. Pantau setiap prosesnya hingga tuntas.
                    </p>

                    <ul class="mt-9 space-y-4">
                        <li class="flex items-start gap-3 text-sm text-navy-200">
                            <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-gold-400">
                                <flux:icon.shield-check class="size-4" />
                            </span>
                            <span><span class="font-semibold text-white">Aman &amp; rahasia.</span> Identitas dapat disembunyikan saat mengirim pengaduan.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-navy-200">
                            <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-gold-400">
                                <flux:icon.clock class="size-4" />
                            </span>
                            <span><span class="font-semibold text-white">Transparan.</span> Status dan tanggapan kampus dapat dipantau kapan saja.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-navy-200">
                            <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-gold-400">
                                <flux:icon.arrow-trending-up class="size-4" />
                            </span>
                            <span><span class="font-semibold text-white">Berdampak.</span> Setiap laporan menjadi dasar peningkatan layanan kampus.</span>
                        </li>
                    </ul>
                </div>

                <div class="relative z-10 flex items-center gap-3 text-xs text-navy-400">
                    <flux:icon.map-pin class="size-4 text-gold-400" />
                    Jl. Raya Serang - Pandeglang KM. 3, Kampus Universitas Pamulang Serang
                </div>
            </aside>

            <div class="flex flex-col">
                <div class="flex items-center justify-between border-b border-navy-100 bg-white px-6 py-4 lg:hidden">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <x-app-logo-icon class="size-10" />
                        <span class="leading-tight">
                            <span class="block text-lg font-bold tracking-tight text-navy-950">SIPADU</span>
                            <span class="block text-[9px] font-semibold uppercase tracking-[0.12em] text-navy-500">Universitas Pamulang Kampus Serang</span>
                        </span>
                    </a>
                    <a href="{{ route('home') }}" class="text-sm font-medium text-navy-600 hover:text-navy-900">Beranda</a>
                </div>

                <div class="flex flex-1 items-center justify-center px-6 py-10 sm:px-10">
                    <div class="w-full max-w-md rounded-2xl border border-navy-100 bg-white p-7 shadow-[0_24px_70px_-38px_rgba(11,44,90,0.35)] sm:p-9">
                        {{ $slot }}
                    </div>
                </div>

                <p class="px-6 pb-8 text-center text-xs text-navy-400">
                    &copy; {{ now()->year }} SIPADU &middot; Universitas Pamulang Kampus Serang
                </p>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
