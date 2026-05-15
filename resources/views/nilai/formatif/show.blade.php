<x-app-layout>
    <x-slot name="title">
        Nilai Formatif - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('nilai.formatif.list', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-amber-400 uppercase tracking-wider mb-0.5">Rincian Kompetensi</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    {{ $bab }} — {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">

        @php
            $koleksiNilai = collect($nilai);
            $rataKelas = round($koleksiNilai->avg('nilai'), 1) ?? 0;
            $nilaiTertinggi = $koleksiNilai->max('nilai') ?? 0;
            $tuntas = $koleksiNilai->filter(fn($n) => $n->nilai >= 75)->count();
            $totalSiswa = $koleksiNilai->count() ?: 1;
            $persenTuntas = round(($tuntas / $totalSiswa) * 100);
        @endphp
        
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex flex-col justify-center">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1">Rerata Kelas</span>
                <span class="text-xl font-black font-mono text-white">{{ $rataKelas }}</span>
            </div>
            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex flex-col justify-center">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1">Skor Tertinggi</span>
                <span class="text-xl font-black font-mono text-emerald-400">{{ $nilaiTertinggi }}</span>
            </div>
            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex flex-col justify-center">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1">Ketuntasan (≥75)</span>
                <span class="text-xl font-black font-mono text-indigo-400">{{ $persenTuntas }}%</span>
            </div>
        </div>

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                            <th class="py-4 px-5 text-center w-16">No</th>
                            <th class="py-4 px-5">Nama Siswa</th>
                            <th class="py-4 px-5 text-center w-32">Nilai Formatif</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($nilai as $i => $n)
                            <tr class="hover:bg-slate-800/10 transition duration-100">
                                <td class="py-3 px-5 text-center font-mono text-slate-500 font-medium">
                                    {{ sprintf('%02d', $i + 1) }}
                                </td>

                                <td class="py-3 px-5 font-bold text-slate-200">
                                    {{ $n->siswa->nama }}
                                </td>

                                <td class="py-3 px-5 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-lg text-xs font-black font-mono tracking-wide border min-w-[56px] justify-center
                                        @if($n->nilai >= 80) bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @elseif($n->nilai >= 60) bg-amber-500/10 text-amber-400 border-amber-500/20
                                        @else bg-rose-500/10 text-rose-400 border-rose-500/20
                                        @endif">
                                        {{ $n->nilai }}
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