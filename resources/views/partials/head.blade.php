<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'SIPADU') : config('app.name', 'SIPADU').' - Sistem Pengaduan Mahasiswa' }}
</title>

<meta name="description" content="SIPADU - Sistem Pengaduan Mahasiswa Universitas Pamulang Kampus Serang. Sampaikan pengaduan, kritik, dan saran untuk pelayanan kampus yang lebih baik." />
<meta name="theme-color" content="#0B2C5A" />

<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
    // SIPADU menggunakan tema terang institusional secara konsisten.
    window.localStorage.setItem('flux.appearance', 'light');
</script>
@fluxAppearance
<script>
    document.documentElement.classList.remove('dark');
</script>
