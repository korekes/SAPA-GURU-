<x-app-layout>
    <x-slot name="title">
         Daftar Kelas - {{ $jurusan }}  
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-row sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="/kelas" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Daftar Kelas</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        Jurusan {{ $jurusan }}
                    </h2>
                </div>
            </div>
            
            <span class="self-start sm:self-center text-xs font-medium px-3 py-1.5 bg-slate-800 text-slate-400 border border-slate-700/60 rounded-lg shadow-sm">
                Total: <span class="text-indigo-400 font-semibold">{{ $kelas->count() }} Kelas</span>
            </span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-4">
        @if($kelas->isEmpty())
            <div class="bg-[#111827] border border-slate-800/80 rounded-2xl p-12 text-center shadow-md">
                <div class="w-16 h-16 bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 border border-slate-700/50">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="text-white font-semibold text-base mb-1">Belum Ada Data Kelas</h3>
                <p class="text-slate-400 text-sm max-w-sm mx-auto">Data kelas untuk kompetensi keahlian / jurusan ini belum ditambahkan atau masih kosong.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kelas as $k)
                <a href="{{ route('kelas.show', $k->id) }}"
                   class="group relative bg-[#111827] p-5 rounded-2xl border border-slate-800/80 shadow-md hover:border-indigo-500/50 hover:shadow-indigo-950/20 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    
                    <div class="absolute top-0 left-0 right-0 h-[2px] bg-indigo-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>

                    <div>
                        <div class="flex items-start justify-between gap-4">
                            <div class="text-white font-bold text-lg tracking-tight group-hover:text-indigo-400 transition duration-200">
                                {{ $k->nama_kelas }}
                            </div>
                            <span class="text-[11px] font-semibold px-2 py-0.5 bg-slate-800/80 text-slate-400 rounded-md border border-slate-700/40 uppercase tracking-wide group-hover:border-indigo-500/20 transition">
                                Aktif
                            </span>
                        </div>

                        <div class="mt-4 flex items-center gap-2.5 bg-slate-900/50 p-3 rounded-xl border border-slate-800/60 group-hover:bg-slate-800/20 transition">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/10 flex items-center justify-center text-xs">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-[10px] text-slate-500 font-semibold uppercase tracking-wider">Wali Kelas</span>
                                <span class="block text-sm text-slate-300 font-medium truncate" title="{{ $k->wali_kelas }}">
                                    {{ $k->wali_kelas ?? 'Belum Ditentukan' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-800/60 flex items-center justify-between text-xs font-medium text-slate-500 group-hover:text-slate-300 transition">
                        <span class="flex items-center gap-1.5 text-slate-400 group-hover:text-indigo-400 transition">
                            <i class="fas fa-users text-xs"></i> Lihat Detail Siswa
                        </span>
                        <i class="fas fa-arrow-right text-[11px] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-200 text-indigo-400"></i>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>