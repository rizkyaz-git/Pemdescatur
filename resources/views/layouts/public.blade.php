<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Profile Desa Catur - Sambi, Boyolali, Jawa Tengah')</title>
    <link rel="icon" type="image/png" href="{{ $siteFavicon }}">
    <link rel="shortcut icon" href="{{ $siteFavicon }}">
    <link rel="apple-touch-icon" href="{{ $siteFavicon }}">
    <meta name="description"
        content="@yield('meta_description', 'Portal Resmi Pemerintah Desa Catur, Sambi, Boyolali, Jawa Tengah. Pusat informasi publik, Desa Wisata, Desa Cerdas Kemendes, pertanian padi organik, dan pelayanan desa.')">

    <!-- DNS Prefetch & Preconnect for critical external resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <!-- Non-blocking font load: 'media=print' loads async, onload switches to 'all' -->
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet"
        media="print"
        onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Sparkling Shimmer Loading Animation (Active only while image is loading) */
        @keyframes shimmerGlow {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer-glow {
            background: linear-gradient(90deg,
                    rgba(241, 245, 249, 0.4) 0%,
                    rgba(255, 255, 255, 0.95) 45%,
                    rgba(217, 184, 92, 0.35) 50%,
                    rgba(255, 255, 255, 0.95) 55%,
                    rgba(241, 245, 249, 0.4) 100%);
            background-size: 200% 100%;
            animation: shimmerGlow 1.6s infinite linear;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Staggered Cascade Down Animation for Mobile Menu */
        @keyframes cascadeDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-cascade-1 {
            animation: cascadeDown 0.2s cubic-bezier(0.16, 1, 0.3, 1) 0.02s both;
        }

        .nav-cascade-2 {
            animation: cascadeDown 0.2s cubic-bezier(0.16, 1, 0.3, 1) 0.05s both;
        }

        .nav-cascade-3 {
            animation: cascadeDown 0.2s cubic-bezier(0.16, 1, 0.3, 1) 0.08s both;
        }

        .nav-cascade-4 {
            animation: cascadeDown 0.2s cubic-bezier(0.16, 1, 0.3, 1) 0.11s both;
        }

        .nav-cascade-5 {
            animation: cascadeDown 0.2s cubic-bezier(0.16, 1, 0.3, 1) 0.14s both;
        }

        .nav-cascade-6 {
            animation: cascadeDown 0.2s cubic-bezier(0.16, 1, 0.3, 1) 0.17s both;
        }
    </style>
    @stack('styles')
</head>

<body
    class="bg-white text-[#191c1e] font-['Public_Sans',sans-serif] antialiased min-h-screen flex flex-col justify-between {{ request()->routeIs('warga.letter.show') && session()->has('success') ? 'has-success-toast' : '' }}"
    x-data="navSearchApp('{{ request('q', '') }}')">

    @php
        $isHomePage = request()->routeIs('home');
    @endphp

    @include('layouts.partials.public-header')

    <!-- Main Content Body -->
    <main class="grow">
        @yield('content')
    </main>

    @include('layouts.partials.public-footer')

    @include('layouts.partials.scroll-to-top')

    <!-- Solid Floating Toast Notification -->
    <x-toast />

    @stack('scripts')
</body>

</html>