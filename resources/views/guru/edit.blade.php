<x-app-layout>
    <x-slot name="title">
        Perbarui Data Guru - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center shadow-inner">
                <i class="fas fa-user-edit text-sm"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-orange-400 uppercase tracking-wider mb-0.5">Personalia</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Perbarui Data Guru
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4">
        
        <div class="bg-[#111827] border border-slate-800/80 rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800/50 bg-slate-900/30">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i class="fas fa-id-card text-slate-500"></i> {{ $guru->nama }}
                </h3>
            </div>

            <form method="POST" action="{{ route('guru.update', $guru->id) }}" class="p-6 space-y-5">
                @csrf 
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">Nama Lengkap & Gelar</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-600 group-focus-within:text-orange-400 transition-colors">
                                <i class="fas fa-user text-xs"></i>
                            </span>
                            <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">NIP / No. Pegawai</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-600 group-focus-within:text-orange-400 transition-colors">
                                <i class="fas fa-id-badge text-xs"></i>
                            </span>
                            <input type="text" name="nip" value="{{ old('nip', $guru->user->nip ?? '') }}"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm font-mono focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">Jenis Kelamin</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-600 group-focus-within:text-orange-400 transition-colors">
                                <i class="fas fa-venus-mars text-xs"></i>
                            </span>
                            <select name="jenis_kelamin" 
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm appearance-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20 transition-all">
                                <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">Mata Pelajaran Diampu</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-600 group-focus-within:text-orange-400 transition-colors">
                                <i class="fas fa-book text-xs"></i>
                            </span>
                            <input type="text" name="mapel" value="{{ old('mapel', $guru->mapel) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-800/50 mt-4">
                    <a href="{{ url()->previous() }}" class="text-xs font-bold text-slate-500 hover:text-white transition flex items-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-8 py-3 rounded-xl transition duration-150 shadow-lg shadow-emerald-900/20 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-slate-600 mt-6 uppercase tracking-[0.2em]">
            ID Pegawai: #{{ str_pad($guru->id, 5, '0', STR_PAD_LEFT) }}
        </p>
    </div>
</x-app-layout>