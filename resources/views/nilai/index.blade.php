<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kelas.show', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">E-Rapor & Kategori</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Manajemen Nilai: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">
        
        <div class="mb-6 pl-1">
            <p class="text-sm text-slate-400">
                Silakan pilih salah satu jenis instrumen penilaian di bawah ini untuk mengelola akumulasi nilai siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <a href="{{ route('nilai.absensi', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-6 rounded-2xl hover:border-indigo-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[160px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition"></div>
                
                <div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-4 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-chart-simple text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-indigo-400 transition">
                        Nilai Presensi
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5 leading-relaxed">
                        Rekapitulasi persentase kehadiran siswa otomatis sebagai komponen penunjang nilai rapor.
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-indigo-400 transition gap-1">
                    Buka Modul <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

            <a href="{{ route('nilai.sikap', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-6 rounded-2xl hover:border-emerald-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[160px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition"></div>
                
                <div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-brain text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-emerald-400 transition">
                        Aktif & Sikap (Afektif)
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5 leading-relaxed">
                        Penilaian deskriptif aspek perilaku, kedisiplinan, moralitas, serta keaktifan siswa di kelas.
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-emerald-400 transition gap-1">
                    Buka Modul <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

            <a href="{{ route('nilai.akademik', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-6 rounded-2xl hover:border-amber-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[160px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/10 transition"></div>
                
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center mb-4 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-pen-to-square text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-amber-400 transition">
                        Sumatif & Formatif (Kognitif)
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5 leading-relaxed">
                        Input nilai tugas, kuis, penilaian harian, UTS, hingga ujian akhir semester (UAS).
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-amber-400 transition gap-1">
                    Buka Modul <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

        </div>

    </div>
</x-app-layout>