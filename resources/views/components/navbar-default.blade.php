<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full z-50 bg-[#0f172a]/80 backdrop-blur-xl border-b border-slate-800/60">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <div class="flex items-center gap-3">
            <div class="p-1.5 bg-indigo-600/10 rounded-lg border border-indigo-500/20">
                <x-application-logo class="block h-6 w-auto fill-current text-indigo-400" />
            </div>
            <span class="text-white font-bold tracking-tight text-lg">Sapa Guru</span>
        </div>

        <div class="hidden md:flex items-center gap-8 text-sm font-semibold">
            <a href="/" class="text-slate-300 hover:text-white transition">Beranda</a>
            <a href="#fitur" class="text-slate-300 hover:text-white transition">Fitur</a>
            <a href="/about" class="text-slate-300 hover:text-white transition">Tentang</a>
        </div>

        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition">
                Login
            </a>
        </div>

        <button @click="open = !open" class="md:hidden text-slate-300 hover:text-white focus:outline-none transition p-2">
            <i class="fas" :class="open ? 'fa-times' : 'fa-bars'"></i>
        </button>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         @click.outside="open = false"
         class="md:hidden px-6 pb-6 space-y-3 bg-[#0f172a] border-b border-slate-800">
        <a href="#" class="block text-slate-300 hover:text-white transition py-1">Beranda</a>
        <a href="#fitur" @click="open = false" class="block text-slate-300 hover:text-white transition py-1">Fitur</a>
        <a href="#" class="block text-slate-300 hover:text-white transition py-1">Tentang</a>
        <hr class="border-slate-800 my-2">
        <div class="flex flex-col gap-2 pt-1">
            <a href="{{ route('login') }}" class="block text-center py-2 text-sm font-bold text-slate-300 hover:text-white transition bg-slate-800 rounded-xl border border-slate-700">Login</a>
            <a href="{{ route('register') }}" class="block text-center py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 transition rounded-xl">Daftar</a>
        </div>
    </div>
</nav>