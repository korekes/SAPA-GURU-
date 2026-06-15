<x-app-layout>
    <x-slot name="title">
        Direktori Siswa - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shadow-inner">
                <i class="fas fa-user-graduate text-sm"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Database Utama</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Manajemen Data Siswa
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            
            <form method="GET" action="/siswa" class="w-full md:w-auto">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama atau NIS siswa..."
                           class="w-full md:w-80 pl-10 pr-4 py-2.5 bg-[#111827] border border-slate-800 text-slate-200 rounded-xl text-sm font-medium placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all shadow-sm">
                    
                    @if(request('search'))
                        <a href="/siswa" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-rose-400">
                            <i class="fas fa-times-circle text-xs"></i>
                        </a>
                    @endif
                </div>
            </form>

            @if(auth()->user()->role == 'admin')
            <a href="{{ route('siswa.create') }}"
               class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition duration-150 shadow-md shadow-indigo-900/20">
                <i class="fas fa-plus"></i> Registrasi Siswa Baru
            </a>
            @endif
        </div>

        <div class="space-y-3">
            @forelse($siswa as $s)
                <a href="{{ route('siswa.show', $s->id) }}"
                   class="group block bg-[#111827] border border-slate-800/80 p-4 rounded-2xl hover:border-indigo-500/30 hover:bg-slate-800/20 transition duration-200 shadow-sm relative overflow-hidden">
                    
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 scale-y-0 group-hover:scale-y-100 transition-transform duration-200"></div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 font-bold text-xs group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 group-hover:text-indigo-400 transition">
                                {{ substr($s->nama, 0, 1) }}
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-200 group-hover:text-white transition">
                                    {{ $s->nama }}
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">
                                    <span class="text-indigo-400/80">NIS: {{ $s->nis }}</span> 
                                    <span class="mx-1.5 text-slate-700">•</span> 
                                    <span class="uppercase tracking-wider">{{ $s->kelas->nama_kelas }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="text-slate-700 group-hover:text-indigo-400 transition-transform duration-200 translate-x-0 group-hover:translate-x-1">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-[#111827] rounded-3xl p-12 border border-slate-800/80 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-900 border border-slate-800 text-slate-700 mb-4">
                        <i class="fas fa-user-slash text-2xl"></i>
                    </div>
                    <h3 class="text-slate-300 font-bold text-sm mb-1">Data Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                        Tidak ada record siswa yang sesuai dengan kata kunci pencarian Anda. Pastikan NIS atau ejaan nama sudah benar.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{-- $siswa->links() --}}
        </div>

    </div>
</x-app-layout>