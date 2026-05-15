<x-app-layout>
    <x-slot name="title">
        Rekap Absensi - {{ $absensi->mapel ?? 'Umum / Tematik' }} ({{ $absensi->kelas->nama_kelas }})
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('absensi.kelas', $absensi->kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Ringkasan Sesi</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        Detail Jurnal Presensi
                    </h2>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('absensi.edit', $absensi->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-750 border border-slate-700/60 text-xs font-bold text-slate-200 hover:text-white rounded-xl transition shadow-sm">
                    <i class="fas fa-pen-to-square text-amber-400"></i> Edit Log
                </a>

                <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh rekaman presensi pada sesi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-xs font-bold text-rose-400 rounded-xl transition shadow-sm">
                        <i class="fas fa-trash-can"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">
        <div class="bg-[#111827] rounded-2xl p-5 mb-6 border border-slate-800/80 shadow-md relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-28 h-28 bg-indigo-500/5 rounded-full blur-xl"></div>
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Grup Kelas</span>
                    <h3 class="text-lg font-black text-white tracking-tight">Kelas {{ $absensi->kelas->nama_kelas }}</h3>
                </div>
                <div class="flex flex-wrap gap-3">
                    <div class="bg-slate-900 px-4 py-2 rounded-xl border border-slate-800 text-xs font-medium text-slate-300 flex items-center gap-2">
                        <i class="far fa-calendar text-indigo-400"></i>
                        {{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('D MMMM YYYY') }}
                    </div>
                    <div class="bg-slate-900 px-4 py-2 rounded-xl border border-slate-800 text-xs font-semibold text-slate-200 flex items-center gap-2">
                        <i class="fas fa-book-bookmark text-indigo-400"></i>
                        {{ $absensi->mapel ?? 'Umum / Tematik' }}
                    </div>
                </div>
            </div>
        </div>

        @php
            $hadir = $absensi->details->where('status','hadir')->count();
            $izin = $absensi->details->where('status','izin')->count();
            $sakit = $absensi->details->where('status','sakit')->count();
            $alfa = $absensi->details->where('status','alfa')->count();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex items-center justify-between relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500"></div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Hadir</span>
                    <span class="text-2xl font-black text-emerald-400 font-mono mt-0.5 block">{{ $hadir }}</span>
                </div>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/5 text-emerald-500/40 flex items-center justify-center text-sm border border-emerald-500/5">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>

            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex items-center justify-between relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500"></div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Izin</span>
                    <span class="text-2xl font-black text-amber-400 font-mono mt-0.5 block">{{ $izin }}</span>
                </div>
                <div class="w-8 h-8 rounded-lg bg-amber-500/5 text-amber-500/40 flex items-center justify-center text-sm border border-amber-500/5">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>

            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex items-center justify-between relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-sky-500"></div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sakit</span>
                    <span class="text-2xl font-black text-sky-400 font-mono mt-0.5 block">{{ $sakit }}</span>
                </div>
                <div class="w-8 h-8 rounded-lg bg-sky-500/5 text-sky-500/40 flex items-center justify-center text-sm border border-sky-500/5">
                    <i class="fas fa-user-doctor"></i>
                </div>
            </div>

            <div class="bg-[#111827] border border-slate-800/80 p-4 rounded-xl shadow-sm flex items-center justify-between relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-rose-500"></div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Alfa</span>
                    <span class="text-2xl font-black text-rose-400 font-mono mt-0.5 block">{{ $alfa }}</span>
                </div>
                <div class="w-8 h-8 rounded-lg bg-rose-500/5 text-rose-500/40 flex items-center justify-center text-sm border border-rose-500/5">
                    <i class="fas fa-user-xmark"></i>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                            <th class="py-3.5 px-6 text-center w-16">No</th>
                            <th class="py-3.5 px-6">Nama Siswa</th>
                            <th class="py-3.5 px-6 text-center w-36">Status Kehadiran</th>
                            <th class="py-3.5 px-6">Catatan Dokumen / Alasan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($absensi->details as $d)
                        <tr class="hover:bg-slate-800/10 transition duration-100">
                            <td class="py-3 px-6 text-center font-mono text-slate-500 font-medium">
                                {{ sprintf('%02d', $loop->iteration) }}
                            </td>

                            <td class="py-3 px-6 font-bold text-slate-200">
                                {{ $d->siswa->nama }}
                            </td>

                            <td class="py-3 px-6 text-center">
                                <span class="inline-flex px-2.5 py-0.5 rounded-md text-[11px] font-extrabold tracking-wide uppercase border
                                    @if($d->status == 'hadir') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                    @elseif($d->status == 'izin') bg-amber-500/10 text-amber-400 border-amber-500/20
                                    @elseif($d->status == 'sakit') bg-sky-500/10 text-sky-400 border-sky-500/20
                                    @else bg-rose-500/10 text-rose-400 border-rose-500/20
                                    @endif">
                                    {{ $d->status }}
                                </span>
                            </td>

                            <td class="py-3 px-6 text-sm text-slate-400 font-medium italic">
                                @if($d->keterangan)
                                    <span class="not-italic text-slate-300 font-normal"><i class="far fa-comment-dots text-slate-600 mr-1.5 text-xs"></i>{{ $d->keterangan }}</span>
                                @else
                                    <span class="opacity-40 font-mono text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>