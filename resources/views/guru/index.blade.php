<x-app-layout>
    <x-slot name="title">
        Direktori Guru - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center shadow-inner">
                <i class="fas fa-user-tie text-sm"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-orange-400 uppercase tracking-wider mb-0.5">Personalia Pendidikan</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Direktori Data Guru
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            
            <form method="GET" action="/guru" class="w-full md:w-auto">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-orange-400 transition-colors">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama atau NIP guru..."
                           class="w-full md:w-80 pl-10 pr-4 py-2.5 bg-[#111827] border border-slate-800 text-slate-200 rounded-xl text-sm font-medium placeholder-slate-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20 transition-all shadow-sm">
                    
                    @if(request('search'))
                        <a href="/guru" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-rose-400">
                            <i class="fas fa-times-circle text-xs"></i>
                        </a>
                    @endif
                </div>
            </form>

            @if(auth()->user()->role == 'admin')
            <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">

                <a href="{{ route('guru.create') }}"
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition duration-150 shadow-md shadow-orange-900/20">
                    <i class="fas fa-plus"></i>
                    Tambah Data Guru
                </a>

            </div>
            @endif
        </div>

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="divide-y divide-slate-800/60">
                @forelse($guru as $g)
                    <a href="{{ route('guru.show', $g->id) }}"
                       class="group block p-4 hover:bg-slate-800/20 transition duration-150 relative overflow-hidden">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-orange-500 scale-y-0 group-hover:scale-y-100 transition-transform duration-200"></div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-500 group-hover:bg-orange-500/10 group-hover:border-orange-500/20 group-hover:text-orange-400 transition">
                                    <i class="fas fa-user text-xs"></i>
                                </div>

                                <div>
                                    <h3 class="font-bold text-slate-200 group-hover:text-white transition leading-tight">
                                        {{ $g->user->name }}
                                    </h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">NIP</span>
                                        <span class="text-xs font-mono text-slate-400 group-hover:text-slate-300">
                                            {{ $g->user->nip ?? '— Belum Diatur —' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-slate-700 group-hover:text-orange-400 transition-transform duration-200 translate-x-0 group-hover:translate-x-1">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-slate-900 border border-slate-800 text-slate-700 mb-4">
                            <i class="fas fa-user-slash text-xl"></i>
                        </div>
                        <h3 class="text-slate-300 font-bold text-sm mb-1">Data Belum Tersedia</h3>
                        <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                            Belum ada data guru yang terdaftar atau kriteria pencarian Anda tidak membuahkan hasil.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>