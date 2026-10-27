<x-layouts::auth :title="__('Daftar')">
    <div class="flex flex-col gap-6">
        <div class="space-y-2 text-center">
            <flux:heading size="xl" level="1">Buat akun mahasiswa</flux:heading>
            <flux:subheading>Lengkapi data diri Anda untuk mulai menggunakan SIPADU.</flux:subheading>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf

            <flux:input
                name="name"
                label="Nama lengkap"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Sesuai KTM"
            />

            <div class="grid gap-5 sm:grid-cols-2">
                <flux:input
                    name="nim"
                    label="NIM"
                    :value="old('nim')"
                    type="text"
                    required
                    autocomplete="username"
                    placeholder="Contoh: 2210112345"
                    inputmode="numeric"
                />

                <flux:input
                    name="no_hp"
                    label="No. HP (opsional)"
                    :value="old('no_hp')"
                    type="tel"
                    autocomplete="tel"
                    placeholder="08xxxxxxxxxx"
                />
            </div>

            <flux:select name="program_studi" label="Program studi" required placeholder="Pilih program studi">
                @foreach (\App\Support\StudyPrograms::options() as $value => $label)
                    <flux:select.option :value="$value" :selected="old('program_studi') === $value">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input
                name="email"
                label="Alamat email"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="nama@email.com"
            />

            <flux:input
                name="password"
                label="Password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <flux:input
                name="password_confirmation"
                label="Konfirmasi password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Ulangi password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <p class="text-xs leading-5 text-navy-500">
                Dengan mendaftar, Anda menyetujui data yang dikirim digunakan untuk keperluan pelayanan pengaduan kampus.
            </p>

            <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                Daftar
            </flux:button>
        </form>

        <div class="space-x-1 text-center text-sm text-navy-500 rtl:space-x-reverse">
            <span>Sudah punya akun?</span>
            <flux:link :href="route('login')" wire:navigate class="font-semibold">Masuk</flux:link>
        </div>
    </div>
</x-layouts::auth>
