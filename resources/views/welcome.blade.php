<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sapa Guru</title>
    
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/logo/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/logo/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/logo/logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#0f172a] text-white antialiased">

    <x-navbar-default />

    <section class="min-h-screen flex items-center justify-center text-center px-6 pt-20">
        <div class="max-w-3xl">

            <h1 class="text-4xl md:text-6xl font-black leading-tight tracking-tight">
                Sistem Penilaian Modern untuk 
                <span class="text-indigo-400">Guru & Siswa</span>
            </h1>

            <p class="mt-6 text-slate-400 text-lg">
                Kelola nilai, presensi, dan aktivitas siswa dengan lebih cepat, efisien, dan realtime.
            </p>

            <div class="mt-10 flex flex-col md:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black">Fitur Unggulan</h2>
            <p class="text-slate-400 text-sm mt-2">Semua yang dibutuhkan guru dalam satu sistem</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 hover:border-indigo-500/30 transition">
                <i class="fas fa-chart-line text-indigo-400 text-xl mb-4"></i>
                <h3 class="font-bold mb-2">Manajemen Nilai</h3>
                <p class="text-slate-400 text-sm">Input nilai formatif, UTS, UAS dengan cepat dan otomatis.</p>
            </div>

            <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 hover:border-emerald-500/30 transition">
                <i class="fas fa-user-check text-emerald-400 text-xl mb-4"></i>
                <h3 class="font-bold mb-2">Presensi Siswa</h3>
                <p class="text-slate-400 text-sm">Pantau kehadiran siswa secara real-time.</p>
            </div>

            <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 hover:border-amber-500/30 transition">
                <i class="fas fa-clock text-amber-400 text-xl mb-4"></i>
                <h3 class="font-bold mb-2">Riwayat Aktivitas</h3>
                <p class="text-slate-400 text-sm">Semua aktivitas tercatat otomatis.</p>
            </div>

        </div>
    </section>

    <footer class="border-t border-slate-800 text-center py-6 text-slate-500 text-xs">
        &copy; {{ date('Y') }} Sapa Guru. All rights reserved.
    </footer>

</body>
</html>