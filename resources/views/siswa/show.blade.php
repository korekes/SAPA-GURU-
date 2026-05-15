<x-app-layout>
    <x-slot name="title">
        Profil Siswa - {{ $siswa->nama }} 
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Detail Anggota</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        {{ __('Profil Siswa') }}
                    </h2>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('siswa.edit', $siswa->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-750 border border-slate-700/60 text-xs font-bold text-slate-200 hover:text-white rounded-xl transition shadow-sm">
                    <i class="fas fa-user-pen text-amber-400"></i> Edit Profil
                </a>

                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-xs font-bold text-rose-400 rounded-xl transition shadow-sm">
                        <i class="fas fa-trash-can"></i> Hapus Siswa
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-2">
        <div class="bg-[#111827] rounded-2xl p-6 mb-8 border border-slate-800/80 shadow-md relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl"></div>
            
            <div class="flex flex-col sm:flex-row items-center gap-6 relative z-10 text-center sm:text-left">
                <div class="w-24 h-24 bg-gradient-to-tr from-indigo-600 via-indigo-500 to-cyan-500 rounded-2xl flex items-center justify-center text-3xl font-black text-white uppercase shadow-lg shadow-indigo-500/20 tracking-wider">
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                </div>

                <div class="flex-1 space-y-1.5">
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">
                        {{ $siswa->nama }}
                    </h2>
                    
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-4 text-sm text-slate-400">
                        <span class="flex items-center gap-1.5 bg-slate-900 px-3 py-1 rounded-lg border border-slate-800 font-mono text-xs text-slate-300">
                            <i class="fas fa-id-card text-indigo-400"></i> NIS: {{ $siswa->nis }}
                        </span>
                        <span class="flex items-center gap-1.5 bg-slate-900 px-3 py-1 rounded-lg border border-slate-800 text-xs text-slate-300">
                            <i class="fas fa-school text-indigo-400"></i> Kelas: <span class="font-semibold text-white">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-800/80 bg-slate-900/40 flex items-center gap-2">
                    <div class="w-8 h-8 bg-amber-500/10 text-amber-400 rounded-lg flex items-center justify-center text-sm border border-amber-500/10">
                        <i class="fas fa-chart-simple"></i>
                    </div>
                    <h3 class="text-white font-bold text-sm tracking-tight">Riwayat Nilai Akademik</h3>
                </div>

                <div class="p-5 flex-1 overflow-y-auto max-h-[350px] space-y-3">
                    @forelse($siswa->nilai as $n)
                        <div class="flex items-center justify-between p-3 bg-slate-900/40 border border-slate-800/60 rounded-xl hover:border-slate-700/60 transition duration-150">
                            <span class="text-sm font-semibold text-slate-300">{{ $n->mapel ?? 'Mata Pelajaran' }}</span>
                            <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-mono font-bold rounded-lg
                                {{ $n->nilai >= 75 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                {{ $n->nilai }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500 flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-folder-open text-xl text-slate-600"></i>
                            <p class="text-xs">Belum ada rekaman nilai untuk siswa ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-800/80 bg-slate-900/40 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-500/10 text-indigo-400 rounded-lg flex items-center justify-center text-sm border border-indigo-500/10">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-white font-bold text-sm tracking-tight">Log Kehadiran / Absensi</h3>
                </div>

                <div class="p-5 flex-1 overflow-y-auto max-h-[350px] space-y-3">
                    @forelse($siswa->absensiDetails as $d)
                        <div class="flex items-center justify-between p-3 bg-slate-900/40 border border-slate-800/60 rounded-xl hover:border-slate-700/60 transition duration-150">
                            <span class="text-xs font-medium text-slate-400 font-mono flex items-center gap-2">
                                <i class="far fa-clock text-slate-600"></i> {{ \Carbon\Carbon::parse($d->absensi->tanggal)->isoFormat('D MMM YYYY') }}
                            </span>
                            
                            <span class="inline-flex px-2.5 py-0.5 rounded-md text-[11px] font-bold tracking-wide border uppercase
                                @if($d->status == 'hadir') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                @elseif($d->status == 'alfa') bg-rose-500/10 text-rose-400 border-rose-500/20
                                @elseif($d->status == 'izin') bg-amber-500/10 text-amber-400 border-amber-500/20
                                @elseif($d->status == 'sakit') bg-sky-500/10 text-sky-400 border-sky-500/20
                                @else bg-slate-800 text-slate-400 border-slate-700
                                @endif">
                                {{ $d->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500 flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-calendar-minus text-xl text-slate-600"></i>
                            <p class="text-xs">Belum ada riwayat absensi terdaftar.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>