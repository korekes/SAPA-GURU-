<x-app-layout>
    <x-slot name="title">
        Nilai Absensi - {{ $kelas->nama_kelas }}    
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('nilai.kelas', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Kalkulasi Kehadiran</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Nilai Absensi: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">
        
        <div class="mb-6 pl-1">
            <p class="text-sm text-slate-400">
                Berikut adalah akumulasi kuantitas presensi siswa serta konversi nilai otomatis berdasarkan rumus bobot kehadiran semester berjalan.
            </p>
        </div>

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">Nama Lengkap</th>
                            <th class="py-4 px-4 text-center w-24 text-emerald-400">Hadir</th>
                            <th class="py-4 px-4 text-center w-24 text-amber-400">Izin</th>
                            <th class="py-4 px-4 text-center w-24 text-sky-400">Sakit</th>
                            <th class="py-4 px-4 text-center w-24 text-rose-400">Alfa</th>
                            <th class="py-4 px-6 text-center w-28">Skor Akhir</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($data as $i => $d)
                            <tr class="hover:bg-slate-800/10 transition duration-100">
                                <td class="py-3 px-6 text-center font-mono text-slate-500 font-medium">
                                    {{ sprintf('%02d', $i + 1) }}
                                </td>

                                <td class="py-3 px-6 font-bold text-slate-200">
                                    {{ $d['nama'] }}
                                </td>

                                <td class="py-3 px-4 text-center font-mono text-xs font-semibold text-emerald-400/80">
                                    {{ $d['hadir'] }}
                                </td>

                                <td class="py-3 px-4 text-center font-mono text-xs font-semibold text-amber-400/80">
                                    {{ $d['izin'] }}
                                </td>

                                <td class="py-3 px-4 text-center font-mono text-xs font-semibold text-sky-400/80">
                                    {{ $d['sakit'] }}
                                </td>

                                <td class="py-3 px-4 text-center font-mono text-xs font-semibold text-rose-400/80">
                                    {{ $d['alfa'] }}
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-lg text-xs font-black font-mono tracking-wide border min-w-[52px] justify-center
                                        @if($d['nilai'] >= 80) bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @elseif($d['nilai'] >= 60) bg-amber-500/10 text-amber-400 border-amber-500/20
                                        @else bg-rose-500/10 text-rose-400 border-rose-500/20
                                        @endif">
                                        {{ $d['nilai'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>