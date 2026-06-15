<x-app-layout>
    <div class="max-w-6xl mx-auto py-12 px-6">
        
        <div class="text-center mb-20 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-64 h-20 bg-indigo-500/20 blur-[100px] rounded-full"></div>
            
            <span class="inline-block text-xs font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Behind The System</span>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter">
                Tim <span class="bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">Pengembang</span>
            </h1>
            <p class="text-slate-500 text-sm mt-4 max-w-xl mx-auto leading-relaxed font-medium">
                Sapa Guru lahir dari kolaborasi kreatif untuk mendigitalisasi administrasi pendidikan menjadi lebih efisien, transparan, dan modern.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-10">
            @foreach($developers as $dev)
            @php
                // Mapping warna untuk menghindari isu PurgeCSS Tailwind
                $colorMap = [
                    'indigo' => ['border' => 'border-indigo-500', 'text' => 'text-indigo-400', 'bg' => 'bg-indigo-500/10', 'shadow' => 'shadow-indigo-500/10'],
                    'emerald' => ['border' => 'border-emerald-500', 'text' => 'text-emerald-400', 'bg' => 'bg-emerald-500/10', 'shadow' => 'shadow-emerald-500/10'],
                    'blue' => ['border' => 'border-blue-500', 'text' => 'text-blue-400', 'bg' => 'bg-blue-500/10', 'shadow' => 'shadow-blue-500/10'],
                    'purple' => ['border' => 'border-purple-500', 'text' => 'text-purple-400', 'bg' => 'bg-purple-500/10', 'shadow' => 'shadow-purple-500/10'],
                ];
                $theme = $colorMap[$dev['color']] ?? $colorMap['indigo'];
            @endphp

            <div class="group relative bg-[#111827] rounded-[2.5rem] p-10 border border-slate-800/80 shadow-2xl transition-all duration-500 hover:-translate-y-2">
                
                <div class="absolute inset-0 rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-opacity duration-500 {{ $theme['shadow'] }} shadow-[0_0_40px_rgba(0,0,0,0.1)]"></div>

                <div class="relative z-10 flex flex-col items-center">
                    
                    <div class="relative mb-8">
                        <div class="absolute inset-0 rounded-full {{ $theme['bg'] }} animate-pulse scale-110"></div>
                        <div class="relative w-40 h-40 rounded-full p-1.5 border-2 {{ $theme['border'] }} overflow-hidden bg-slate-900">
                            <img src="{{ asset($dev['foto']) }}" 
                                 class="w-full h-full rounded-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-110 group-hover:scale-100"
                                 alt="{{ $dev['nama'] }}">
                        </div>
                        
                        <div class="absolute -bottom-2 right-2 w-10 h-10 rounded-xl bg-[#0b0f19] border border-slate-700 flex items-center justify-center text-slate-400 group-hover:text-white transition-colors shadow-xl">
                            <i class="fab fa-github"></i>
                        </div>
                    </div>

                    <div class="text-center">
                        <span class="inline-block px-4 py-1 text-[10px] font-black uppercase tracking-widest rounded-full {{ $theme['bg'] }} {{ $theme['text'] }} border {{ $theme['border'] }}/20 mb-3">
                            {{ $dev['role'] }}
                        </span>
                        
                        <h2 class="text-2xl font-black text-white tracking-tight mb-3 group-hover:text-indigo-400 transition-colors">
                            {{ $dev['nama'] }}
                        </h2>

                        <div class="w-12 h-1 bg-slate-800 mx-auto rounded-full mb-5 group-hover:w-24 transition-all duration-500"></div>

                        <p class="text-slate-400 text-sm leading-[1.8] font-medium italic px-4">
                            "{{ $dev['deskripsi'] }}"
                        </p>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="far fa-envelope"></i></a>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-24 py-10 border-t border-slate-800/50 text-center">
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.5em]">
                Built with Passion for Digital Education
            </p>
        </div>
    </div>
</x-app-layout>