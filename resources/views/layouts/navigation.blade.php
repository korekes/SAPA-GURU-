<div x-data="{ open: false }">
    <div class="lg:hidden fixed top-0 left-0 w-full bg-[#111827] border-b border-slate-800/80 px-4 py-3 z-[60] flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="p-1.5 bg-indigo-600/10 rounded-lg border border-indigo-500/20">
                <x-application-logo class="block h-6 w-auto fill-current text-indigo-400" />
            </div>
            <span class="font-bold text-white uppercase tracking-wider text-sm bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                Sapa Guru
            </span>
        </div>
        
        <button @click="open = !open" class="p-2 rounded-xl bg-slate-800 text-slate-400 hover:text-white transition-colors">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars-staggered'"></i>
        </button>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false" 
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[51] lg:hidden">
    </div>

    <nav :class="open ? 'translate-x-0' : '-translate-x-full'" 
         class="fixed left-0 top-0 h-screen w-72 bg-[#111827] border-r border-slate-800/80 z-[55] flex flex-col justify-between transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        <div class="overflow-y-auto custom-scrollbar">
            <div class="hidden lg:block p-6 border-b border-slate-800/80">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-600/10 rounded-xl border border-indigo-500/20">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-7 w-auto fill-current text-indigo-400" />
                        </a>
                    </div>
                    <span class="font-bold text-lg text-white uppercase tracking-wider bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                        Sapa Guru
                    </span>
                </div>
            </div>

            <div class="lg:hidden h-20"></div>

            <div class="py-6 px-4 space-y-1.5">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                   {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                    <i class="fa-solid fa-house-chimney mr-3 text-base {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    {{ __('Dashboard') }}
                </a>

                @if(auth()->user()->role == 'admin')
                    <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu Admin</div>
                    
                    <a href="/siswa" 
                       class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                       {{ request()->routeIs('siswa.*') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                        <i class="fa-solid fa-users mr-3 text-base {{ request()->routeIs('siswa.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                        Siswa
                    </a>

                    <a href="/kelas" 
                       class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                       {{ request()->routeIs('kelas.*') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                        <i class="fa-solid fa-chalkboard-user mr-3 text-base {{ request()->routeIs('kelas.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                        Kelas
                    </a>

                    <a href="/guru" 
                       class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                       {{ request()->routeIs('guru.*') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                        <i class="fa-solid fa-person-chalkboard mr-3 text-base {{ request()->routeIs('guru.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                        Guru
                    </a>
                @endif

                @if(auth()->user()->role == 'guru')
                    <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu Guru</div>
                    
                    <a href="/kelas" 
                       class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                       {{ request()->routeIs('kelas.*') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                        <i class="fa-solid fa-chalkboard-user mr-3 text-base {{ request()->routeIs('kelas.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                        Kelas
                    </a>

                    <a href="/perwalian" 
                       class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                       {{ request()->routeIs('perwalian.*') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                        <i class="fa-solid fa-address-card mr-3 text-base {{ request()->routeIs('perwalian.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                        Perwalian
                    </a>

                    <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tentang</div>

                    <a href="/about/developer" 
                       class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
                       {{ request()->routeIs('about') ? 'bg-gradient-to-r from-indigo-600/20 to-indigo-600/5 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}">
                        <i class="fa-solid fa-people-group mr-3 text-base {{ request()->routeIs('about') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                        Tentang
                    </a>
                @endif
            </div>
        </div>

        <div class="p-4 border-t border-slate-800/80 bg-[#0d131f]">
            <div class="flex items-center gap-3 px-3 py-2 mb-4 bg-slate-800/40 rounded-xl border border-slate-800">
                <div class="w-9 h-9 flex-shrink-0 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white uppercase text-sm shadow-sm shadow-indigo-500/20">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="text-sm font-semibold text-slate-200 truncate">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-slate-400 truncate flex items-center gap-1 uppercase tracking-tight">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span> NIP: {{ Auth::user()->nip }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center gap-2 py-2 px-3 text-xs font-medium text-slate-300 bg-slate-800 hover:bg-slate-750 border border-slate-700/60 rounded-xl transition">
                    <i class="fa-solid fa-user-gear text-slate-400"></i> Profil
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 text-xs font-medium text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl transition">
                        <i class="fa-solid fa-power-off"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>