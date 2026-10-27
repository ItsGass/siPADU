@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#FBFCFE] text-navy-950 antialiased">
        <header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 border-b border-navy-100/80 bg-white/90 backdrop-blur-xl">
            <div class="mx-auto flex h-20 max-w-7xl items-center gap-4 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3" aria-label="SIPADU - Beranda">
                    <x-app-logo-icon class="size-11 transition-transform duration-300 group-hover:-rotate-3" />
                    <span class="leading-tight">
                        <span class="block text-xl font-bold tracking-tight text-navy-950">SIPADU</span>
                        <span class="block whitespace-nowrap text-[10px] font-semibold uppercase tracking-[0.12em] text-navy-500 sm:text-[11px]">Universitas Pamulang Kampus Serang</span>
                    </span>
                </a>

                <nav class="ml-auto hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                    @php
                        $navItems = [
                            ['route' => 'home', 'label' => 'Home'],
                            ['route' => 'about', 'label' => 'Tentang SIPADU'],
                            ['route' => 'how-to', 'label' => 'Cara Pengaduan'],
                            ['route' => 'contact', 'label' => 'Kontak'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            @class([
                                'rounded-full px-4 py-2 text-sm font-medium transition',
                                'bg-navy-50 text-navy-900' => request()->routeIs($item['route']),
                                'text-navy-600 hover:bg-navy-50 hover:text-navy-900' => ! request()->routeIs($item['route']),
                            ])
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    <a
                        href="{{ route('status.check') }}"
                        @class([
                            'rounded-full px-4 py-2 text-sm font-medium transition',
                            'bg-navy-50 text-navy-900' => request()->routeIs('status.check'),
                            'text-navy-600 hover:bg-navy-50 hover:text-navy-900' => ! request()->routeIs('status.check'),
                        ])
                    >
                        Cek Status
                    </a>
                </nav>

                <div class="ml-auto hidden items-center gap-2 lg:ml-0 lg:flex">
                    @auth
                        <flux:button :href="route('dashboard')" variant="ghost" icon="squares-2x2">
                            Dashboard
                        </flux:button>
                    @else
                        <flux:button :href="route('login')" variant="ghost" icon="arrow-right-end-on-rectangle">
                            Login
                        </flux:button>
                    @endauth

                    <flux:button :href="auth()->check() ? route('complaints.create') : route('login')" variant="primary" icon="plus">
                        Buat Pengaduan
                    </flux:button>
                </div>

                <button
                    type="button"
                    class="ml-auto inline-flex size-11 items-center justify-center rounded-xl border border-navy-200 text-navy-900 lg:hidden"
                    x-on:click="mobileOpen = ! mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    aria-label="Buka menu"
                >
                    <flux:icon.bars-3 class="size-6" x-show="! mobileOpen" />
                    <flux:icon.x-mark class="size-6" x-show="mobileOpen" x-cloak />
                </button>
            </div>

            <div x-show="mobileOpen" x-cloak x-transition.origin.top class="border-t border-navy-100 bg-white px-4 py-4 lg:hidden">
                <nav class="flex flex-col gap-1" aria-label="Navigasi mobile">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}" class="rounded-xl px-4 py-3 text-sm font-medium text-navy-700 hover:bg-navy-50">{{ $item['label'] }}</a>
                    @endforeach
                    <a href="{{ route('status.check') }}" class="rounded-xl px-4 py-3 text-sm font-medium text-navy-700 hover:bg-navy-50">Cek Status Pengaduan</a>
                </nav>

                <div class="mt-4 grid gap-2 border-t border-navy-100 pt-4">
                    @auth
                        <flux:button :href="route('dashboard')" variant="filled" icon="squares-2x2" class="w-full">Dashboard</flux:button>
                    @else
                        <flux:button :href="route('login')" variant="filled" icon="arrow-right-end-on-rectangle" class="w-full">Login</flux:button>
                    @endauth

                    <flux:button :href="auth()->check() ? route('complaints.create') : route('login')" variant="primary" icon="plus" class="w-full">
                        Buat Pengaduan
                    </flux:button>
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="bg-navy-950 text-navy-100">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr] lg:px-8">
                <div>
                    <div class="flex items-center gap-3">
                        <x-app-logo-icon class="size-12 ring-1 ring-white/15" />
                        <div>
                            <p class="text-xl font-bold tracking-tight text-white">SIPADU</p>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gold-400">Universitas Pamulang Kampus Serang</p>
                        </div>
                    </div>
                    <p class="mt-5 max-w-sm text-sm leading-6 text-navy-300">
                        Sistem Pengaduan Mahasiswa untuk menyampaikan kritik, saran, dan laporan secara mudah, aman, dan transparan.
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <span class="inline-flex size-9 items-center justify-center rounded-full bg-white/5 text-gold-400">
                            <flux:icon.envelope class="size-4" />
                        </span>
                        <span class="text-sm text-navy-200">sipadu@unpam.ac.id</span>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Menu</p>
                    <ul class="mt-4 space-y-3 text-sm text-navy-300">
                        <li><a href="{{ route('home') }}" class="transition hover:text-gold-400">Home</a></li>
                        <li><a href="{{ route('about') }}" class="transition hover:text-gold-400">Tentang SIPADU</a></li>
                        <li><a href="{{ route('how-to') }}" class="transition hover:text-gold-400">Cara Pengaduan</a></li>
                        <li><a href="{{ route('contact') }}" class="transition hover:text-gold-400">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Layanan</p>
                    <ul class="mt-4 space-y-3 text-sm text-navy-300">
                        <li><a href="{{ route('complaints.create') }}" class="transition hover:text-gold-400">Buat Pengaduan</a></li>
                        <li><a href="{{ route('status.check') }}" class="transition hover:text-gold-400">Cek Status</a></li>
                        <li><a href="{{ route('suggestions.index') }}" class="transition hover:text-gold-400">Saran &amp; Kritik</a></li>
                        <li><a href="{{ route('login') }}" class="transition hover:text-gold-400">Login Mahasiswa</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Kontak Kampus</p>
                    <ul class="mt-4 space-y-4 text-sm text-navy-300">
                        <li class="flex gap-3">
                            <flux:icon.map-pin class="mt-0.5 size-4 shrink-0 text-gold-400" />
                            <span>Jl. Raya Serang - Pandeglang KM. 3, Kampus Universitas Pamulang Serang, Banten</span>
                        </li>
                        <li class="flex gap-3">
                            <flux:icon.phone class="mt-0.5 size-4 shrink-0 text-gold-400" />
                            <span>(0254) 123-456</span>
                        </li>
                        <li class="flex gap-3">
                            <flux:icon.clock class="mt-0.5 size-4 shrink-0 text-gold-400" />
                            <span>Senin - Jumat, 08.00 - 16.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10">
                <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6 text-xs text-navy-400 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <p>&copy; {{ now()->year }} SIPADU &middot; Universitas Pamulang Kampus Serang. Seluruh hak cipta dilindungi.</p>
                    <p>Dibangun untuk pelayanan kampus yang lebih baik.</p>
                </div>
            </div>
        </footer>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
