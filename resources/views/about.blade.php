<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Sapa Guru</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#0f172a] text-white antialiased">

    <x-navbar-default />

    <div class="pt-32 max-w-6xl mx-auto px-6 pb-20" x-data="{ showLightbox: false, activePhoto: '' }">
        
        <div class="text-center mb-20 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-64 h-20 bg-indigo-500/20 blur-[100px] rounded-full"></div>
            
            <span class="text-xs font-black text-indigo-400 uppercase tracking-[0.3em]">Behind The System</span>
            <h1 class="text-4xl md:text-5xl font-black mt-3">
                Tim <span class="text-indigo-400">Pengembang</span>
            </h1>
            <p class="text-slate-500 text-sm mt-4 max-w-xl mx-auto">
                Sapa Guru dibangun untuk mempermudah digitalisasi pendidikan secara modern.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-10">
            @foreach($developers as $dev)

            @php
                $colorMap = [
                    'indigo' => ['border' => 'border-indigo-500', 'text' => 'text-indigo-400', 'bg' => 'bg-indigo-500/10', 'glow' => 'group-hover:border-indigo-500/50'],
                    'emerald' => ['border' => 'border-emerald-500', 'text' => 'text-emerald-400', 'bg' => 'bg-emerald-500/10', 'glow' => 'group-hover:border-emerald-500/50'],
                ];
                $theme = $colorMap[$dev['color']] ?? $colorMap['indigo'];
            @endphp

            <div class="bg-[#111827] p-10 rounded-[2.5rem] border border-slate-800/80 shadow-xl hover:-translate-y-2 duration-300 transition group">

                <div class="flex flex-col items-center text-center">

                    <div class="relative w-40 h-40 rounded-full cursor-pointer group/photo" 
                         @click="activePhoto = '{{ asset($dev['foto']) }}'; showLightbox = true">
                        
                        <div class="absolute inset-0 bg-indigo-500/10 blur-xl opacity-0 group-hover/photo:opacity-100 transition-opacity duration-300 rounded-full"></div>
                        
                        <div class="relative w-full h-full rounded-full overflow-hidden border-4 {{ $theme['border'] }} {{ $theme['glow'] }} transition-colors duration-300">
                            <img src="{{ asset($dev['foto']) }}" class="w-full h-full object-cover group-hover/photo:scale-105 transition duration-500">
                            
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/photo:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-search-plus text-xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <span class="mt-6 px-4 py-1 text-[10px] font-bold uppercase {{ $theme['bg'] }} {{ $theme['text'] }} rounded-full tracking-wider">
                        {{ $dev['role'] }}
                    </span>

                    <h2 class="text-2xl font-bold mt-4 tracking-tight text-slate-100 group-hover:text-white transition-colors">{{ $dev['nama'] }}</h2>

                    <p class="text-slate-400 text-sm mt-3 italic max-w-sm">
                        "{{ $dev['deskripsi'] }}"
                    </p>

                </div>

            </div>

            @endforeach
        </div>

        <template x-if="showLightbox">
            <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm"
                 @click.self="showLightbox = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div class="relative max-w-xl w-full flex flex-col items-center"
                     x-transition:enter="transition ease-out duration-300 transform scale-95"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    
                    <button @click="showLightbox = false" class="absolute -top-12 right-0 md:-right-12 text-slate-400 hover:text-white text-2xl transition focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                    
                    <img :src="activePhoto" class="w-full h-auto rounded-[2rem] shadow-2xl border border-slate-800 bg-[#111827] object-contain max-h-[80vh]">
                </div>
            </div>
        </template>

        <div class="mt-20 text-center text-slate-600 text-xs">
            © {{ date('Y') }} Sapa Guru. All rights reserved.
        </div>
    </div>

</body>
</html>