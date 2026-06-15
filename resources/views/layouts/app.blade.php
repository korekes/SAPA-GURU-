<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/logo/logo.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/logo/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/logo/logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            .ts-wrapper .ts-control{
                background: #0f172a !important;
                border: 1px solid #334155 !important;
                color: #fff !important;
                min-height: 44px;
                border-radius: 12px !important;
            }

            .ts-wrapper.single .ts-control input{
                color: #fff !important;
            }

            .ts-dropdown{
                background: #111827 !important;
                border: 1px solid #334155 !important;
                color: #fff !important;
            }

            .ts-dropdown .option{
                color: #e2e8f0 !important;
                padding: 10px 12px;
            }

            .ts-dropdown .option:hover{
                background: #1e293b !important;
            }

            .ts-dropdown .active{
                background: #ea580c !important;
                color: white !important;
            }

            .ts-control.focus{
                border-color: #f97316 !important;
                box-shadow: 0 0 0 1px #f97316 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#0b0f19] text-slate-200">
        <div class="min-h-screen">
            
            @include('layouts.navigation')

            <div class="flex flex-col min-h-screen lg:ml-72 pt-16 lg:pt-0">
                
                @isset($header)
                    <header class="bg-[#111827]/50 backdrop-blur-md border-b border-slate-800/60 sticky top-0 z-40">
                        <div class="max-w-7xl mx-auto py-4 lg:py-5 px-4 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 p-4 lg:p-8">
                    {{ $slot }}
                </main>

            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const popup = document.getElementById('successPopup');
                    if (popup) {
                        popup.style.transition = 'all 0.3s ease';
                        popup.style.opacity = '0';
                        popup.style.transform = 'translateY(-20px)';
                        setTimeout(() => popup.remove(), 300);
                    }
                }, 3000);
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.guru-select').forEach(function(el) {

                new TomSelect(el,{
                    create:false,
                    sortField:{
                        field:"text",
                        direction:"asc"
                    },
                    placeholder:"Cari guru..."
                });

            });

        });
        </script>
    </body>
</html>