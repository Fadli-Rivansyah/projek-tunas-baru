<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Aplikasi pengelolaan data ayam yang memudahkan peternak dalam mencatat, memantau, dan menganalisis data kesehatan, pertumbuhan, dan produksi ayam.">
        <meta name="keywords" content="pengelolaan data ayam, aplikasi peternakan, manajemen ayam, kesehatan ayam, pertumbuhan ayam, produksi telur, peternakan modern">
        <meta name="author" content="[Nama Anda atau Nama Perusahaan]">
        <link rel="canonical" href="https://www.contoh.com/pengelolaan-data-ayam">
        <meta property="og:title" content="Aplikasi Pengelolaan Data Ayam - [Nama Aplikasi]">
        <meta property="og:description" content="Aplikasi pengelolaan data ayam yang memudahkan peternak dalam mencatat, memantau, dan menganalisis data kesehatan, pertumbuhan, dan produksi ayam.">
        <meta property="og:image" content="https://www.contoh.com/images/thumbnail.jpg">
        <meta property="og:url" content="https://www.contoh.com/pengelolaan-data-ayam">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Aplikasi Pengelolaan Data Ayam - [Nama Aplikasi]">
        <meta name="twitter:description" content="Aplikasi pengelolaan data ayam yang memudahkan peternak dalam mencatat, memantau, dan menganalisis data kesehatan, pertumbuhan, dan produksi ayam.">
        <meta name="twitter:image" content="https://www.contoh.com/images/thumbnail.jpg">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        
        <title>{{ $title ?? 'Page Title' }}</title>
        <!-- Scripts -->
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Helvetica';
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @stack('scripts')
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            // AOS.init({
            //     duration: 400,
            //     mirror: false,
            //     once: true,
        
            // });

            AOS.init();
            // document.addEventListener('livewire:load', function () {
            // });

            document.addEventListener('livewire:updated', function () {
                AOS.refresh();
            });

        </script>
    </body>
</html>
