<x-app-layout>
    <x-slot name="title">
        Jurnal Kelas - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kelas.show', $kelas->id) }}" 
               class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-blue-400 uppercase tracking-wider mb-0.5">Administrasi Pembelajaran</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Jurnal Kelas: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-4 px-4">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex flex-col">
                <p class="text-sm text-slate-400 font-medium">
                    Dokumentasi materi, kehadiran, dan kejadian khusus selama sesi KBM.
                </p>
            </div>
            
            <a href="{{ route('jurnal.create', $kelas->id) }}"
               class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition duration-150 shadow-lg shadow-blue-900/20">
                <i class="fas fa-plus"></i> Buat Entri Jurnal
            </a>
        </div>

        <div class="relative">
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-800 hidden sm:block"></div>

            <div class="space-y-4">
                @forelse($jurnal as $j)
                <div class="relative pl-0 sm:pl-10 group">
                    <div class="absolute left-3 top-6 w-2.5 h-2.5 bg-slate-700 border-2 border-slate-900 rounded-full hidden sm:block group-hover:bg-blue-500 group-hover:border-blue-500/30 transition-colors z-10"></div>

                    <div class="bg-[#111827] border border-slate-800/80 rounded-2xl p-5 hover:border-slate-700 transition duration-200 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="hidden sm:flex flex-col items-center justify-center min-w-[60px] h-[60px] bg-slate-900 border border-slate-800 rounded-xl">
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">{{ \Carbon\Carbon::parse($j->tanggal)->format('M') }}</span>
                                    <span class="text-xl font-black text-white leading-none">{{ \Carbon\Carbon::parse($j->tanggal)->format('d') }}</span>
                                </div>

                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <h3 class="text-base font-bold text-slate-200 group-hover:text-blue-400 transition">
                                            {{ $j->mapel ?? 'Mata Pelajaran Umum' }}
                                        </h3>
                                        <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-800 text-slate-400 rounded-md uppercase tracking-wide border border-slate-700/50">
                                            Sesi Selesai
                                        </span>
                                    </div>
                                    
                                    <p class="text-xs text-slate-500 font-medium mb-2 sm:hidden">
                                        <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($j->tanggal)->format('d F Y') }}
                                    </p>

                                    <div class="relative">
                                        <p class="text-sm text-slate-400 leading-relaxed max-w-2xl">
                                            <span class="text-slate-600 font-bold mr-1">MATERI:</span>
                                            {{ Str::limit($j->materi, 120) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end sm:justify-start">
                                <a href="{{ route('jurnal.show', $j->id) }}"
                                   class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-800 px-4 py-2 rounded-lg border border-slate-700/50 transition shadow-sm">
                                    Lihat Detail <i class="fas fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-[#111827] rounded-3xl p-12 border border-slate-800/80 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-900 border border-slate-800 text-slate-700 mb-4 shadow-inner">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <h3 class="text-slate-300 font-bold text-sm mb-1">Jurnal Kosong</h3>
                    <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed font-medium">
                        Belum ada catatan kegiatan belajar mengajar yang dibuat untuk kelas ini.
                    </p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>