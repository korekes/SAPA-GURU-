<x-app-layout>
    <x-slot name="title">
        Jurusan - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Pilih Kompetensi Keahlian / Jurusan') }}
            </h2>
            <span class="text-xs font-medium px-3 py-1.5 bg-slate-800 text-slate-400 border border-slate-700/60 rounded-lg shadow-sm">
                Total: <span class="text-indigo-400 font-semibold">{{ count($jurusan) }} Jurusan</span>
            </span>
        </div>
    </x-slot>

    @if(auth()->user()->role == 'admin')
    <a href="{{ route('kelas.walikelas') }}"
    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl">
        <i class="fas fa-school"></i>
        Atur Wali Kelas
    </a>
    @endif

    <div class="max-w-7xl mx-auto py-4">
        <div class="mb-6">
            <p class="text-sm text-slate-400">Silahkan pilih salah satu jurusan di bawah ini untuk melihat daftar kelas dan manajemen data yang terkait.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($jurusan as $j)
            <a href="{{ route('kelas.jurusan', $j) }}"
               class="group relative bg-[#111827] p-6 rounded-2xl border border-slate-800/80 shadow-md transition-all duration-300 hover:border-indigo-500/50 hover:shadow-indigo-950/30 flex flex-col items-center text-center justify-between min-h-[180px] overflow-hidden">
                
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition-all duration-300"></div>

                <div class="w-14 h-14 bg-slate-800 text-indigo-400 rounded-xl border border-slate-700/50 flex items-center justify-center text-lg font-bold tracking-wider uppercase group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-500 transition-all duration-300 shadow-inner">
                    {{ substr($j, 0, 4 ) }}
                </div>

                <div class="mt-4 flex-1 flex items-center justify-center">
                    <h3 class="text-lg font-bold text-slate-200 group-hover:text-white transition duration-200 tracking-tight line-clamp-2">
                        {{ $j }}
                    </h3>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-800/60 w-full flex items-center justify-center gap-1.5 text-xs font-medium text-slate-500 group-hover:text-indigo-400 transition duration-200">
                    <span>Buka Kelas</span>
                    <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</x-app-layout>