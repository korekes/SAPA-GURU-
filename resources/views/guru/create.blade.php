<x-app-layout>
    <x-slot name="title">
        Registrasi Guru Baru - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shadow-inner">
                <i class="fas fa-user-plus text-sm"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Personalia</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Registrasi Guru Baru
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4">
        
        @if ($errors->any())
            <div class="mb-6 flex items-start gap-3 bg-rose-500/10 border border-rose-500/20 p-4 rounded-2xl">
                <i class="fas fa-exclamation-circle text-rose-500 mt-1"></i>
                <div>
                    <h4 class="text-sm font-bold text-rose-500">Mohon perbaiki kesalahan berikut:</h4>
                    <ul class="text-xs text-rose-400/80 list-disc list-inside mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-[#111827] border border-slate-800/80 rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800/50 bg-slate-900/30">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i class="fas fa-id-card text-slate-500"></i> Informasi Akun & Profesi
                </h3>
            </div>

            <form method="POST" action="{{ route('guru.store') }}" class="p-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap & Gelar</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <i class="fas fa-user text-xs"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all placeholder-slate-600"
                                   placeholder="Contoh: Dr. Budi Santoso, M.Pd">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all"
                                   placeholder="nama@sekolah.sch.id">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Password Default</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input type="password" name="password" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">NIP / No. Pegawai</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <i class="fas fa-id-badge text-xs"></i>
                            </span>
                            <input type="text" name="nip" value="{{ old('nip') }}"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm font-mono focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all"
                                   placeholder="1985XXXXXXXXXXXXXX">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Spesialisasi Mapel</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <i class="fas fa-book text-xs"></i>
                            </span>
                            <input type="text" name="mapel" value="{{ old('mapel') }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all"
                                   placeholder="Contoh: Matematika">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-800/50 mt-4">
                    <a href="{{ route('guru.index') }}" class="text-xs font-bold text-slate-500 hover:text-white transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-8 py-3 rounded-xl transition duration-150 shadow-lg shadow-indigo-900/20 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Data Guru
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-slate-600 mt-6 uppercase tracking-[0.2em]">
            Sistem Informasi Akademik v3.0
        </p>
    </div>
</x-app-layout>