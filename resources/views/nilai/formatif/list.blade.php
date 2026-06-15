<x-app-layout>
    <x-slot name="title">
        Nilai Formatif - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('nilai.akademik', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-amber-400 uppercase tracking-wider mb-0.5">Arsip Formatif</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Daftar Nilai Formatif: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">
        
        <div class="mb-6 pl-1">
            <p class="text-sm text-slate-400">
                Pilih bab atau kompetensi dasar di bawah ini untuk melihat lembar rincian nilai siswa serta infografis sebaran pencapaian kelas.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($nilai as $bab => $items)
                @php
                    $rata = round(collect($items)->avg('nilai'), 1);
                @endphp

                <a href="{{ route('nilai.formatif.show', [$kelas->id, $bab]) }}"
                   class="group bg-[#111827] border border-slate-800/80 p-5 rounded-2xl hover:border-amber-500/30 hover:bg-slate-800/10 transition duration-200 shadow-md flex flex-col justify-between relative overflow-hidden min-h-[135px]">
                    
                    <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full blur-xl transition duration-200
                        @if($rata >= 80) bg-emerald-500/5 group-hover:bg-emerald-500/10
                        @elseif($rata >= 60) bg-amber-500/5 group-hover:bg-amber-500/10
                        @else bg-rose-500/5 group-hover:bg-rose-500/10
                        @endif">
                    </div>

                    <div>
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="text-base font-bold text-white tracking-tight group-hover:text-amber-400 transition duration-150 truncate max-w-[85%]">
                                <i class="font-normal text-slate-500 text-sm mr-1.5 far fa-bookmark"></i>{{ $bab }}
                            </h3>
                            <span class="text-slate-600 group-hover:text-amber-400 text-xs translate-x-0 group-hover:translate-x-0.5 transition duration-150 mt-1">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>

                        <p class="text-xs text-slate-400 font-medium mt-1.5">
                            Rerata Kelas: 
                            <span class="font-black font-mono tracking-wide ml-0.5 text-xs
                                @if($rata >= 80) text-emerald-400
                                @elseif($rata >= 60) text-amber-400
                                @else text-rose-400
                                @endif">
                                {{ $rata }}
                            </span>
                        </p>
                    </div>

                    <div class="mt-5">
                        <div class="w-full bg-slate-900 border border-slate-800/50 rounded-full h-2 overflow-hidden p-[1px]">
                            <div class="h-full rounded-full transition-all duration-500
                                @if($rata >= 80) bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.3)]
                                @elseif($rata >= 60) bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.3)]
                                @else bg-rose-400 shadow-[0_0_8px_rgba(248,113,113,0.3)]
                                @endif"
                                style="width: {{ $rata }}%">
                            </div>
                        </div>
                    </div>

                </a>
            @empty
                <div class="col-span-1 md:col-span-2 bg-[#111827] rounded-2xl p-8 border border-slate-800/80 text-center text-slate-500 font-medium">
                    <div class="flex flex-col items-center justify-center gap-2.5 py-4">
                        <div class="w-11 h-11 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-600 text-lg shadow-inner">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <p class="text-xs">Belum ada rekapan modul nilai formatif di kelas ini</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>