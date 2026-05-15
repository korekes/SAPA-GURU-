<x-app-layout>
    <x-slot name="title">
        Absensi Kelas - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('kelas.show', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Sistem Presensi</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        Absensi Kelas {{ $kelas->nama_kelas }}
                    </h2>
                </div>
            </div>
            
            <a href="{{ route('absensi.create', $kelas->id) }}"
               class="inline-flex items-center gap-2 py-2 px-4 bg-indigo-600 hover:bg-indigo-500 text-xs font-bold text-white rounded-xl shadow-lg shadow-indigo-600/10 hover:shadow-indigo-600/20 transition duration-150 self-start sm:self-center">
                <i class="fas fa-plus"></i> Buat Absensi
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">
        <div class="bg-[#111827] rounded-2xl p-4 mb-6 border border-slate-800/80 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-slate-400 border border-slate-800">
                    <i class="fas fa-user-tie text-sm"></i>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-wider">Wali Kelas</span>
                    <span class="text-sm font-semibold text-slate-300">{{ $kelas->wali_kelas ?? 'Belum Ditentukan' }}</span>
                </div>
            </div>
            <span class="text-xs text-slate-400 font-medium bg-slate-900 px-3 py-1.5 rounded-lg border border-slate-800">
                Log Terdata: <span class="text-indigo-400 font-bold font-mono">{{ $absensi->count() }}</span>
            </span>
        </div>

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 uppercase text-[11px] font-bold tracking-wider border-b border-slate-800/80">
                            <th class="py-4 px-6 text-center w-40">Tanggal</th>
                            <th class="py-4 px-6">Mata Pelajaran / Sesi</th>
                            <th class="py-4 px-4 text-center w-24 text-emerald-400">Hadir</th>
                            <th class="py-4 px-4 text-center w-24 text-amber-400">Izin</th>
                            <th class="py-4 px-4 text-center w-24 text-sky-400">Sakit</th>
                            <th class="py-4 px-4 text-center w-24 text-rose-400">Alfa</th>
                            <th class="py-4 px-6 text-center w-20">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($absensi as $a)
                            @php
                                $hadir = $a->details->where('status', 'hadir')->count();
                                $izin = $a->details->where('status', 'izin')->count();
                                $sakit = $a->details->where('status', 'sakit')->count();
                                $alfa = $a->details->where('status', 'alfa')->count();
                            @endphp

                            <tr onclick="window.location='{{ route('absensi.rekap', $a->id) }}'"
                                class="hover:bg-slate-800/30 transition duration-150 cursor-pointer group">
                                
                                <td class="py-4 px-6 text-center font-mono text-xs text-slate-200 group-hover:text-indigo-400 font-semibold transition">
                                    {{ \Carbon\Carbon::parse($a->tanggal)->isoFormat('D MMM YYYY') }}
                                </td>

                                <td class="py-4 px-6 font-semibold text-slate-300">
                                    {{ $a->mapel ?? 'Umum / Tematik' }}
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold font-mono bg-emerald-500/10 text-emerald-400 border border-emerald-500/10 min-w-[36px] justify-center">
                                        {{ $hadir }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold font-mono bg-amber-500/10 text-amber-400 border border-amber-500/10 min-w-[36px] justify-center">
                                        {{ $izin }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold font-mono bg-sky-500/10 text-sky-400 border border-sky-500/10 min-w-[36px] justify-center">
                                        {{ $sakit }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold font-mono bg-rose-500/10 text-rose-400 border border-rose-500/10 min-w-[36px] justify-center">
                                        {{ $alfa }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-900 border border-slate-800 text-slate-500 group-hover:text-indigo-400 group-hover:border-indigo-500/30 transition shadow-inner">
                                        <i class="fas fa-eye text-xs"></i>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-calendar-minus text-2xl text-slate-600"></i>
                                        <span class="text-sm">Belum ada riwayat rekap absensi untuk kelas ini.</span>
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