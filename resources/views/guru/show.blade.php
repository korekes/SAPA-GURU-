<x-app-layout>
    <x-slot name="title">
        Profil Guru - {{ $guru->user->name }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('guru.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Detail Personalia</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Profil Guru
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">

        <div class="relative bg-[#111827] rounded-[2rem] p-8 border border-slate-800/80 shadow-2xl overflow-hidden mb-8">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row items-center md:items-end gap-8">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    
                    @if($guru->user->foto)
                        <img src="{{ asset('storage/' . $guru->user->foto) }}"
                             class="relative w-32 h-32 rounded-full object-cover border-4 border-slate-900 shadow-xl">
                    @else
                        <div class="relative w-32 h-32 rounded-full bg-slate-800 border-4 border-slate-900 flex items-center justify-center text-4xl text-indigo-400 font-black shadow-xl">
                            {{ strtoupper(substr($guru->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-4 border-[#111827] rounded-full"></div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <div class="justify-center md:justify-start items-center gap-3 mb-2">
                        <h1 class="text-3xl font-black text-white tracking-tight">
                            {{ $guru->user->name }}
                        </h1>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                            TENAGA PENDIDIK
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-x-6 gap-y-2 text-slate-400 font-medium">
                        <div class="flex items-center gap-2">
                            <i class="far fa-id-badge text-indigo-500"></i>
                            <span class="font-mono text-sm uppercase tracking-wider">{{ $guru->user->nip ?? 'NIP TIDAK TERSEDIA' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <i class="far fa-envelope text-indigo-500"></i>
                            <span>{{ $guru->user->email }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('guru.edit', $guru->id) }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-indigo-900/20">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">

            <div class="bg-[#111827] border border-slate-800/80 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800/50 bg-slate-900/30 flex items-center gap-2">
                    <i class="fas fa-briefcase text-slate-500 text-sm"></i>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Detail Pekerjaan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-800/40 pb-3">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Mata Pelajaran</span>
                        <span class="text-sm font-bold text-slate-200">{{ $guru->mapel ?? 'Belum Diatur' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-800/40 pb-3">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Jenis Kelamin</span>
                        <span class="text-sm font-bold text-slate-200">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Status Pegawai</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-400 bg-emerald-500/5 px-2 py-1 rounded-md">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            AKTIF
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-[#111827] border border-slate-800/80 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800/50 bg-slate-900/30 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-slate-500 text-sm"></i>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Ringkasan Statistik</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-900 rounded-xl border border-slate-800/50">
                        <span class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kelas Diampu</span>
                        <span class="text-2xl font-black text-white font-mono">-</span>
                    </div>
                    <div class="p-4 bg-slate-900 rounded-xl border border-slate-800/50">
                        <span class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Total Siswa</span>
                        <span class="text-2xl font-black text-white font-mono">-</span>
                    </div>
                    <div class="col-span-2 p-4 bg-indigo-500/5 rounded-xl border border-indigo-500/10 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-indigo-400 uppercase">Performa Mengajar</span>
                        <div class="flex gap-0.5 text-indigo-400 text-[10px]">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <p class="text-center text-[10px] text-slate-600 mt-12 uppercase tracking-[0.3em]">
            Data diverifikasi oleh Sistem Informasi Akademik
        </p>

    </div>
</x-app-layout>