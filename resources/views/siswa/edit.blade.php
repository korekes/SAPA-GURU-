<x-app-layout>
    <x-slot name="title">
        Edit Data Siswa - {{ $siswa->nama }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="javascript:history.back()" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Manajemen Data</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    {{ __('Edit Data Siswa') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-4">
        
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-xl mb-6 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-circle-exclamation text-sm"></i>
                    <span class="font-bold text-sm">Periksa kembali isian Anda:</span>
                </div>
                <ul class="space-y-1 text-xs pl-6 list-disc opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md p-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl"></div>
            
            <form method="POST" action="{{ route('siswa.update', $siswa->id) }}" class="space-y-5 relative z-10">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        <i class="fas fa-user text-[11px] mr-1 text-slate-500"></i> Nama Lengkap
                    </label>
                    <input type="text" name="nama" 
                           value="{{ old('nama', $siswa->nama) }}"
                           autocomplete="off"
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-slate-200 placeholder-slate-600 font-medium text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150"
                           placeholder="Masukkan nama lengkap siswa">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        <i class="fas fa-id-card text-[11px] mr-1 text-slate-500"></i> Nomor Induk Siswa (NIS)
                    </label>
                    <input type="text" name="nis" 
                           value="{{ old('nis', $siswa->nis) }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-slate-200 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150"
                           placeholder="Contoh: 212210123">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        <i class="fas fa-school text-[11px] mr-1 text-slate-500"></i> Penempatan Kelas
                    </label>
                    <div class="relative">
                        <select name="kelas_id"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-slate-200 font-medium text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150 appearance-none cursor-pointer">
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }} class="bg-[#111827]">
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-500 text-xs">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800/60 flex items-center justify-between gap-4">
                    <a href="/siswa" 
                       class="inline-flex items-center gap-2 py-2.5 px-4 bg-slate-900 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-xs font-bold text-slate-400 hover:text-slate-200 rounded-xl transition duration-150">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-2 py-2.5 px-5 bg-indigo-600 hover:bg-indigo-500 border border-indigo-500/20 text-xs font-bold text-white rounded-xl shadow-lg shadow-indigo-600/10 hover:shadow-indigo-600/20 transition duration-150">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>