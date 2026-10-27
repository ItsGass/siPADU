<x-layouts::auth :title="__('Masuk')">
    <div class="flex flex-col gap-6">
        <div class="space-y-2 text-center">
            <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-navy-50 text-navy-900 lg:hidden">
                <x-app-logo-icon class="size-14" />
            </div>
            <flux:heading size="xl" level="1">Masuk ke SIPADU</flux:heading>
            <flux:subheading>Gunakan akun mahasiswa Anda untuk melanjutkan.</flux:subheading>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <flux:input
                name="email"
                label="Alamat email"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="nama@mahasiswa.unpam.ac.id"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    label="Password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 end-0 text-sm" :href="route('password.request')" wire:navigate>
                        Lupa password?
                    </flux:link>
                @endif
            </div>

            <flux:checkbox name="remember" label="Ingat saya" :checked="old('remember')" />

            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                Masuk
            </flux:button>
        </form>

        <div class="space-x-1 text-center text-sm text-navy-500 rtl:space-x-reverse">
            <span>Belum punya akun?</span>
            <flux:link :href="route('register')" wire:navigate class="font-semibold">Daftar sekarang</flux:link>
        </div>
    </div>
</x-layouts::auth>
