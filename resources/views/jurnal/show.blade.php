<x-app-layout>
    <x-slot name="title">
        Detail Jurnal - {{ $jurnal->mapel }} ({{ $jurnal->kelas->nama_kelas }})
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('jurnal.index', $jurnal->kelas->id) }}" 
                   class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-0.5">Arsip Jurnal Pembelajaran</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        {{ $jurnal->mapel }}
                    </h2>
                </div>
            </div>
            
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-slate-900 border border-slate-800 rounded-2xl">
                <i class="far fa-calendar-alt text-emerald-500"></i>
                <span class="text-sm font-bold text-slate-200">
                    {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        
        <div class="bg-[#111827] border border-slate-800/80 rounded-[2rem] shadow-2xl overflow-hidden">
            
            <div class="p-8 border-b border-slate-800/50 bg-slate-900/30">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-book-reader text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white leading-tight">{{ $jurnal->mapel }}</h3>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">
                                Kelas: {{ $jurnal->kelas->nama_kelas }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="md:hidden flex items-center gap-2 text-sm font-medium text-slate-400">
                        <i class="far fa-calendar-alt text-emerald-500"></i>
                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                    </div>
                </div>
            </div>

            <div class="p-8 space-y-10">
                
                <div class="relative pl-6">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500/30 rounded-full"></div>
                    <label class="block text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-3">Topik Utama & Materi</label>
                    <p class="text-base text-slate-200 leading-relaxed font-medium">
                        {{ $jurnal->materi }}
                    </p>
                </div>

                <div class="bg-slate-900/50 border border-slate-800/50 rounded-2xl p-6">
                    <div class="flex items-center gap-2 mb-4 text-slate-400">
                        <i class="fas fa-bullseye text-xs"></i>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em]">Capaian / Tujuan Pembelajaran</label>
                    </div>
                    <p class="text-sm text-slate-300 leading-relaxed italic">
                        "{{ $jurnal->tujuan_pembelajaran ?? 'Tidak ada deskripsi tujuan pembelajaran.' }}"
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-2 text-slate-400">
                        <i class="fas fa-stream text-xs"></i>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em]">Langkah-langkah Kegiatan</label>
                    </div>
                    <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-[1.8]">
                        {{-- Menggunakan nl2br jika input menggunakan baris baru --}}
                        {!! nl2br(e($jurnal->kegiatan)) !!}
                    </div>
                </div>

            </div>

            <div class="px-8 py-6 bg-slate-900/50 border-t border-slate-800/50 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-500 text-[10px] font-bold">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="text-[10px] uppercase tracking-wider">
                        <span class="text-slate-500 font-bold">Dicatat oleh:</span>
                        <span class="text-slate-200 font-black ml-1">{{ auth()->user()->name }}</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <button onclick="window.print()" class="p-2 text-slate-500 hover:text-white transition">
                        <i class="fas fa-print text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-[10px] text-slate-600 mt-8 uppercase tracking-[0.3em]">
            ID Jurnal: #JRNL-{{ str_pad($jurnal->id, 6, '0', STR_PAD_LEFT) }}
        </p>
    </div>
</x-app-layout>