<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <style>
            /* Efek Radial Gradient untuk Background agar tidak flat */
            .bg-radial-dark {
                background: radial-gradient(circle at top center, #1e293b 0%, #0b0f19 100%);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#0b0f19] text-slate-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-radial-dark px-4">
            
            <div class="mb-2">
                <a href="/">
                    </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-[#111827] border border-slate-800/80 shadow-2xl overflow-hidden rounded-[2rem] relative">
                
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-purple-500/5 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-slate-600 uppercase tracking-[0.4em] font-bold">
                    &copy; {{ date('Y') }} {{ config('app.name') }} Ecosystem
                </p>
            </div>
        </div>
    </body>
</html>