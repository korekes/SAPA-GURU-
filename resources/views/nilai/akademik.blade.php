<x-app-layout>
    <x-slot name="title">
        Nilai Akademik - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('nilai.kelas', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-amber-400 uppercase tracking-wider mb-0.5">Capaian Kognitif</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Nilai Akademik: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">
        
        <div class="mb-6 pl-1">
            <p class="text-sm text-slate-400">
                Kelola instrumen penilaian sumatif harian, tengah semester, hingga kalkulasi akhir konversi nilai rapor siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

            <div class="bg-[#111827] border border-slate-800/80 p-5 rounded-2xl relative overflow-hidden shadow-md flex flex-col justify-between min-h-[160px]">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-bold text-white tracking-tight">
                            📘 Nilai Formatif
                        </h3>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded-md border border-amber-500/20">
                            Proses Harian
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed mb-4">
                        Manajemen kompetensi pelaporan nilai tugas harian dan kuis berbasis sub-bab materi.
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-2.5">
                    <a href="{{ route('nilai.formatif.create', $kelas->id) }}"
                       class="inline-flex items-center justify-center gap-1.5 bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold py-2 px-3 rounded-xl transition duration-150 shadow-sm shadow-amber-900/20">
                        <i class="fas fa-plus text-[10px]"></i> Baru
                    </a>
                    <a href="{{ route('nilai.formatif.list', $kelas->id) }}"
                       class="inline-flex items-center justify-center gap-1.5 bg-slate-800 hover:bg-slate-750 text-slate-200 border border-slate-700/60 text-xs font-bold py-2 px-3 rounded-xl transition duration-150">
                        <i class="fas fa-folder-open text-[10px]"></i> Riwayat
                    </a>
                </div>
            </div>

            <a href="{{ route('nilai.uts.show', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-5 rounded-2xl hover:border-indigo-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[160px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition"></div>
                
                <div>
                    <div class="w-9 h-9 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-3 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-file-invoice text-xs"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-indigo-400 transition">
                        📝 Nilai UTS
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1 leading-relaxed">
                        Evaluasi capaian belajar siswa pada pertengahan masa studi semester berjalan.
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-indigo-400 transition gap-1">
                    Buka Input Kelola <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

            <a href="{{ route('nilai.uas.show', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-5 rounded-2xl hover:border-sky-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[160px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-sky-500/5 rounded-full blur-xl group-hover:bg-sky-500/10 transition"></div>
                
                <div>
                    <div class="w-9 h-9 rounded-xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center mb-3 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-graduation-cap text-xs"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-sky-400 transition">
                        📊 Nilai UAS
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1 leading-relaxed">
                        Penilaian sumatif akhir semester sebagai penentu bobot kelulusan standar rapor.
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-sky-400 transition gap-1">
                    Buka Input Kelola <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

        </div>

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                            <th class="py-4 px-5 text-center w-16">No</th>
                            <th class="py-4 px-5">Nama Siswa</th>
                            <th class="py-4 px-3 text-center w-28">Rata Formatif</th>
                            <th class="py-4 px-3 text-center w-24">UTS</th>
                            <th class="py-4 px-3 text-center w-24">UAS</th>
                            <th class="py-4 px-3 text-center w-28">Rata Sumatif</th>
                            <th class="py-4 px-5 text-center w-28 text-indigo-400">Nilai Akhir</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($data as $i => $d)
                            <tr class="hover:bg-slate-800/10 transition duration-100">
                                <td class="py-3 px-5 text-center font-mono text-slate-500 font-medium">
                                    {{ sprintf('%02d', $i + 1) }}
                                </td>

                                <td class="py-3 px-5 font-bold text-slate-200">
                                    {{ $d['nama'] }}
                                </td>

                                <td class="py-3 px-3 text-center font-mono font-medium text-slate-400">
                                    {{ $d['formatif_avg'] }}
                                </td>

                                <td class="py-3 px-3 text-center font-mono font-medium text-slate-400">
                                    {{ $d['uts'] }}
                                </td>

                                <td class="py-3 px-3 text-center font-mono font-medium text-slate-400">
                                    {{ $d['uas'] }}
                                </td>

                                <td class="py-3 px-3 text-center font-mono font-medium text-slate-400">
                                    {{ $d['sumatif_avg'] }}
                                </td>

                                <td class="py-3 px-5 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-lg text-xs font-black font-mono tracking-wide border min-w-[56px] justify-center
                                        @if($d['rapor'] >= 80) bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @elseif($d['rapor'] >= 60) bg-amber-500/10 text-amber-400 border-amber-500/20
                                        @else bg-rose-500/10 text-rose-400 border-rose-500/20
                                        @endif">
                                        {{ $d['rapor'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-slate-500 font-medium bg-slate-900/20">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-inbox text-xl text-slate-600"></i>
                                        <span class="text-xs">Belum ada kompilasi rekapitulasi nilai akademik</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>