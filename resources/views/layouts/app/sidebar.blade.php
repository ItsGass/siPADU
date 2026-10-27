<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#F7F9FC] text-navy-950 dark:bg-zinc-900">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-navy-100 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header class="pb-1">
                <x-app-logo :sidebar="true" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <div class="px-4 pb-5 pt-1">
                <p class="text-[9px] font-semibold uppercase leading-4 tracking-[0.14em] text-navy-400">
                    Universitas Pamulang<br>Kampus Serang
                </p>
            </div>

            <flux:sidebar.nav>
                @if (auth()->user()->isAdmin())
                    <flux:sidebar.group heading="Panel Admin" class="grid">
                        <flux:sidebar.item icon="squares-2x2" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                            Dashboard Admin
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clipboard-document-list" :href="route('admin.complaints.index')" :current="request()->routeIs('admin.complaints.*')" wire:navigate>
                            Kelola Pengaduan
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="chat-bubble-left-right" :href="route('admin.suggestions.index')" :current="request()->routeIs('admin.suggestions.*')" wire:navigate>
                            Saran &amp; Kritik
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @else
                    <flux:sidebar.group heading="Menu Mahasiswa" class="grid">
                        <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            Dashboard
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clipboard-document-list" :href="route('complaints.index')" :current="request()->routeIs('complaints.index') || request()->routeIs('complaints.show')" wire:navigate>
                            Pengaduan Saya
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="plus-circle" :href="route('complaints.create')" :current="request()->routeIs('complaints.create')" wire:navigate>
                            Buat Pengaduan
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="chat-bubble-left-right" :href="route('suggestions.index')" :current="request()->routeIs('suggestions.*')" wire:navigate>
                            Saran &amp; Kritik
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif

                <flux:sidebar.group heading="Informasi" class="grid">
                    <flux:sidebar.item icon="globe-alt" :href="route('home')">
                        Home
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="information-circle" :href="route('about')">
                        Tentang SIPADU
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="book-open" :href="route('how-to')">
                        Cara Pengaduan
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="envelope" :href="route('contact')">
                        Kontak
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="magnifying-glass" :href="route('status.check')">
                        Cek Status
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <div class="mx-3 mb-3 rounded-xl border border-navy-100 bg-navy-50/70 p-4 dark:border-zinc-700 dark:bg-zinc-800">
                <p class="flex items-center gap-2 text-xs font-semibold text-navy-800 dark:text-zinc-200">
                    <flux:icon.shield-check class="size-4 text-gold-600" />
                    SIPADU
                </p>
                <p class="mt-1.5 text-[11px] leading-5 text-navy-500 dark:text-zinc-400">
                    Sampaikan aspirasi, bantu tingkatkan kualitas layanan kampus.
                </p>
            </div>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <div class="flex items-center gap-2">
                <x-app-logo-icon class="size-8" />
                <div class="leading-tight">
                    <p class="text-sm font-bold text-navy-950 dark:text-white">SIPADU</p>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.1em] text-navy-500">Unpam Kampus Serang</p>
                </div>
            </div>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->roleLabel() }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            Pengaturan Akun
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            Keluar
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
