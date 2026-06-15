<x-guest-layout>
    <x-slot name="title">
        LOGIN - {{ config('app.name') }}
    </x-slot>
    <div class="mb-8 text-center">
        <div class="inline-flex p-3 bg-indigo-600/10 rounded-2xl border border-indigo-500/20 mb-4">
            <x-application-logo class="w-10 h-10 fill-current text-indigo-500" />
        </div>
        <h2 class="text-2xl font-black text-white tracking-tight">Selamat Datang</h2>
        <p class="text-sm text-slate-400 mt-1">Silakan masuk menggunakan akun NIP Anda</p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="nip" class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2 px-1">
                Nomor Induk Pegawai (NIP)
            </label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 group-focus-within:text-indigo-500 transition-colors">
                    <i class="fas fa-id-card text-sm"></i>
                </span>
                <input id="nip" type="text" name="nip" :value="old('nip')" required autofocus 
                    class="block w-full pl-11 pr-4 py-3 bg-slate-900/50 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-600"
                    placeholder="Masukkan NIP Anda">
            </div>
            <x-input-error :messages="$errors->get('nip')" class="mt-2 text-xs" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-2 px-1">
                <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-wider transition" href="{{ route('password.request') }}">
                        Lupa Sandi?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 group-focus-within:text-indigo-500 transition-colors">
                    <i class="fas fa-lock text-sm"></i>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-900/50 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-600"
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="rounded-md bg-slate-900 border-slate-800 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-slate-900">
                <span class="ms-2 text-xs font-medium text-slate-400 group-hover:text-slate-300 transition select-none">
                    Ingat saya di perangkat ini
                </span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-900/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <span>Masuk ke Panel</span>
                <i class="fas fa-arrow-right text-xs opacity-50 group-hover:opacity-100 transition"></i>
            </button>
        </div>
    </form>
</x-guest-layout>