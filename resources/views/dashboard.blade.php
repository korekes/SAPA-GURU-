<x-app-layout>
    <x-slot name="title">
        Dashboard {{ auth()->user()->role }} - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Dashboard Overview') }}
            </h2>
            <span class="text-xs font-medium px-3 py-1.5 bg-slate-800 text-slate-400 border border-slate-700/60 rounded-lg shadow-sm">
                Role: <span class="text-indigo-400 capitalize font-semibold">{{ auth()->user()->role }}</span>
            </span>
        </div>
    </x-slot>

    <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl p-8 text-white mb-8 shadow-xl shadow-indigo-950/20 overflow-hidden border border-indigo-500/20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent opacity-70"></div>
        <div class="relative z-10 max-w-xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold bg-white/10 backdrop-blur-md rounded-full text-indigo-100 mb-4 border border-white/10">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Sistem Terintegrasi
            </span>
            <h1 class="text-3xl font-bold mb-2 tracking-tight">Selamat Datang di SAPA GURU!</h1>
            <p class="text-indigo-100/80 text-sm leading-relaxed mb-6">Kelola data guru, absensi, dan penilaian dalam satu platform yang terintegrasi, responsif, dan efisien.</p>
            <div class="text-xs font-medium text-indigo-200/70 bg-black/10 backdrop-blur-sm inline-block px-3 py-1.5 rounded-lg">
                <i class="fa-regular fa-calendar-days mr-1.5"></i> {{ now()->isoFormat('D MMMM YYYY') }}
            </div>
        </div>
        <i class="fas fa-graduation-cap absolute -right-6 -bottom-10 text-[14rem] text-white/5 pointer-events-none rotate-12"></i>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 shadow-md hover:border-indigo-500/50 hover:shadow-indigo-950/20 transition-all duration-300 group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-indigo-500/10 text-indigo-400 rounded-xl border border-indigo-500/20 flex items-center justify-center text-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-3xl font-extrabold text-white mt-1 tracking-tight">{{ $total_siswa }}</p>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 shadow-md hover:border-emerald-500/50 hover:shadow-emerald-950/20 transition-all duration-300 group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20 flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kehadiran Hari Ini</p>
                    <p class="text-3xl font-extrabold text-white mt-1 tracking-tight">{{ $persen_hadir }}%</p>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 shadow-md hover:border-amber-500/50 hover:shadow-amber-950/20 transition-all duration-300 group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-500/10 text-amber-400 rounded-xl border border-amber-500/20 flex items-center justify-center text-2xl group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Penilaian Masuk</p>
                    <p class="text-3xl font-extrabold text-white mt-1 tracking-tight">{{ $total_nilai }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            <h3 class="text-white font-bold text-lg flex items-center gap-2">
                <i class="fas fa-shapes text-indigo-400 text-base"></i> Akses Cepat Fitur
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(auth()->user()->role == 'admin')
                <a href="/siswa" class="group bg-[#111827] p-5 rounded-2xl border border-slate-800/80 flex items-center justify-between hover:bg-slate-800/30 hover:border-slate-700 transition duration-200 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition duration-200">📚</div>
                        <div>
                            <span class="block text-white font-semibold group-hover:text-indigo-400 transition text-sm">Manajemen Data Siswa</span>
                            <span class="block text-xs text-slate-400 mt-0.5">Tambah, ubah, & hapus data siswa</span>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="/kelas" class="group bg-[#111827] p-5 rounded-2xl border border-slate-800/80 flex items-center justify-between hover:bg-slate-800/30 hover:border-slate-700 transition duration-200 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition duration-200">🏫</div>
                        <div>
                            <span class="block text-white font-semibold group-hover:text-indigo-400 transition text-sm">Kelola Jurusan & Kelas</span>
                            <span class="block text-xs text-slate-400 mt-0.5">Atur ruangan kelas & kompetensi</span>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                @endif
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-2xl border border-slate-800/80 shadow-md">
            <h3 class="text-white font-bold text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-indigo-400 text-base"></i> Aktivitas Terbaru
            </h3>

            <div id="aktivitas-list" class="space-y-5">
                <!-- isi dari JS -->
            </div>
        </div>
    </div>
    <script>
        function loadAktivitas() {

            fetch("/Activity/latest")
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    data.forEach((item, index) => {

                        let color = item.icon ?? 'indigo';
                        if (data.length === 0) {
                            html = `<p class="text-slate-400 text-xs">Belum ada aktivitas</p>`;
                        }else{
                            html += `
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-2 h-2 rounded-full bg-${color}-500 ring-4 ring-${color}-500/20"></div>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-200 font-semibold">${item.judul}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">${item.deskripsi ?? ''}</p>
                                    <span class="text-[10px] text-slate-400">${timeAgo(item.created_at)}</span>
                                </div>
                            </div>
                            `;
                        }
                        
                    });

                    document.getElementById('aktivitas-list').innerHTML = html;
                });
        }

        // 🔥 format waktu
        function timeAgo(time) {
            let now = new Date();
            let past = new Date(time);
            let diff = Math.floor((now - past) / 1000);

            if (diff < 60) return diff + ' detik lalu';
            if (diff < 3600) return Math.floor(diff/60) + ' menit lalu';
            if (diff < 86400) return Math.floor(diff/3600) + ' jam lalu';
            return Math.floor(diff/86400) + ' hari lalu';
        }

        // load pertama
        loadAktivitas();

        // 🔥 AUTO REFRESH tiap 5 detik
        setInterval(loadAktivitas, 5000);
    </script>
</x-app-layout>