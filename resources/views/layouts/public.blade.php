<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Profile Desa Catur - Sambi, Boyolali, Jawa Tengah')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Pemerintah Desa Catur, Sambi, Boyolali, Jawa Tengah. Pusat informasi publik, Desa Wisata, Desa Cerdas Kemendes, pertanian padi organik, dan pelayanan desa.')">
    
    <!-- Google Fonts: Public Sans & Inter (DESIGN.md Civic Clarity System) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Leaflet CSS & JS for Interactive Map (FR-08) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    
    <style>
        /* Quill Alignment CSS Rules for Public Pages */
        .ql-align-justify { text-align: justify !important; text-justify: inter-word; }
        .ql-align-center { text-align: center !important; }
        .ql-align-right { text-align: right !important; }
        .ql-align-left { text-align: left !important; }
        .ql-indent-1 { padding-left: 1.5em !important; }
        .ql-indent-2 { padding-left: 3em !important; }
        .ql-indent-3 { padding-left: 4.5em !important; }
        .ql-indent-4 { padding-left: 6em !important; }

        /* Sparkling Shimmer Loading Animation (Active only while image is loading) */
        @keyframes shimmerGlow {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .animate-shimmer-glow {
            background: linear-gradient(
                90deg,
                rgba(241, 245, 249, 0.4) 0%,
                rgba(255, 255, 255, 0.95) 45%,
                rgba(217, 184, 92, 0.35) 50%,
                rgba(255, 255, 255, 0.95) 55%,
                rgba(241, 245, 249, 0.4) 100%
            );
            background-size: 200% 100%;
            animation: shimmerGlow 1.6s infinite linear;
        }

        [x-cloak] { display: none !important; }

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
<body class="bg-white text-[#191c1e] font-['Public_Sans',sans-serif] antialiased min-h-screen flex flex-col justify-between" 
      x-data="navSearchApp()">

@php
    $isHomePage = request()->routeIs('home');
@endphp

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-[99999]"
            :class="(isScrolled || mobileMenuOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
                ? 'text-[#20332A] transition-colors duration-700 ease-in-out' 
                : 'text-white transition-colors duration-700 ease-in-out'">
        
        <!-- Header Background Layer (Constrained to 80px Top Bar) -->
        <div class="absolute inset-x-0 top-0 h-20 pointer-events-none overflow-hidden">
            @if($isHomePage)
                <!-- 1. Top Gradient Layer (Fades out softly and slowly when scrolling down) -->
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/30 to-transparent transition-opacity duration-700 ease-in-out pointer-events-none"
                     :class="(isScrolled || mobileMenuOpen) ? 'opacity-0' : 'opacity-100'">
                </div>

                <!-- 2. Scrolled Glassmorphism Layer (Fades in softly and smoothly when scrolled down) -->
                <div class="absolute inset-0 bg-white/85 backdrop-blur-xl backdrop-saturate-150 border-b border-slate-200/80 shadow-md shadow-slate-900/5 transition-opacity ease-in-out pointer-events-none"
                     :class="mobileMenuOpen 
                         ? 'opacity-100 duration-200' 
                         : (isScrolled 
                             ? 'opacity-100 duration-700' 
                             : 'opacity-0 duration-700 delay-100')">
                </div>
            @else
                <!-- Non-homepage static navbar background -->
                <div class="absolute inset-0 bg-white/95 backdrop-blur-md border-b border-slate-200/60 shadow-xs pointer-events-none"></div>
            @endif
        </div>

        <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-2 lg:gap-4">
                
                <!-- 1. FAR LEFT: BRAND LOGO TEXT (Pemerintah Desa Catur + Subtitle) -->
                <a href="{{ route('home') }}" class="hidden lg:flex items-center gap-3 shrink-0 group text-left">
                    @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                        <img src="{{ asset('storage/' . $globalLogo) }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}" class="h-10 sm:h-11 w-auto object-contain shrink-0">
                    @elseif(file_exists(public_path('images/logo_catur.png')))
                        <img src="{{ asset('images/logo_catur.png') }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}" class="h-10 sm:h-11 w-auto object-contain shrink-0">
                    @endif
                    <div>
                        <span class="block font-serif text-base lg:text-lg xl:text-xl font-bold tracking-tight transition-colors duration-700 ease-in-out leading-tight"
                              :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29] group-hover:text-[#145C3B]' : 'text-white group-hover:text-white/90'">
                            {{ $globalVillageName ?? 'Pemerintah Desa Catur' }}
                        </span>
                        <span class="block text-[10px] font-medium tracking-wider uppercase transition-colors duration-700 ease-in-out"
                              :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-white/80'">
                            Sambi, Boyolali, Jawa Tengah
                        </span>
                    </div>
                </a>

                <!-- 2. CENTER: DESKTOP NAVIGATION LINKS (Beranda, Profil, Informasi, Layanan, Pojok Literasi, Perpustakaan, Kontak) -->
                <nav class="hidden lg:flex items-center justify-center space-x-1 xl:space-x-1.5 font-medium text-xs font-semibold mx-auto">
                    
                    <!-- Beranda -->
                    <a href="{{ route('home') }}" 
                       class="h-9 sm:h-10 px-3.5 inline-flex items-center rounded-lg transition-all duration-700 ease-in-out"
                       :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                           ? '{{ request()->routeIs('home') ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                           : '{{ request()->routeIs('home') ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                        <span>Beranda</span>
                    </a>

                    <!-- Profil Dropdown Button -->
                    <div class="relative inline-block" @click.away="profileDropdown = false">
                        <button @click="profileDropdown = !profileDropdown; infoDropdown = false; layananDropdown = false; literasiDropdown = false" 
                                type="button"
                                class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1 rounded-lg transition-all duration-700 ease-in-out focus:outline-none"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                    ? '{{ (request()->routeIs('public.profile') || request()->routeIs('public.officials')) ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                                    : '{{ (request()->routeIs('public.profile') || request()->routeIs('public.officials')) ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                            <span>Profil</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" 
                                 :class="[profileDropdown ? 'rotate-180' : '', ({{ $isHomePage ? 'isScrolled' : 'true' }}) ? ((request()->routeIs('public.profile') || request()->routeIs('public.officials')) ? 'text-[#0A3D29]' : 'text-[#6C7B72]') : 'text-white']" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu Box Profil -->
                        <div x-show="profileDropdown" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute left-0 mt-2 w-60 rounded-md p-0 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                             :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">
                            
                            <a href="{{ route('public.profile') }}" 
                               class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                               :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span>Profil Desa</span>
                            </a>

                            <a href="{{ route('public.officials') }}" 
                               class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                               :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9"/></svg>
                                <span>Struktur Pemerintahan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Dropdown Button -->
                    <div class="relative inline-block" @click.away="infoDropdown = false">
                        <button @click="infoDropdown = !infoDropdown; profileDropdown = false; layananDropdown = false; literasiDropdown = false" 
                                type="button"
                                class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1 rounded-lg transition-all duration-700 ease-in-out focus:outline-none"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                    ? '{{ (request()->routeIs('public.news*') || request()->routeIs('public.statistics') || request()->routeIs('public.gallery')) ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                                    : '{{ (request()->routeIs('public.news*') || request()->routeIs('public.statistics') || request()->routeIs('public.gallery')) ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                            <span>Informasi</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" 
                                 :class="[infoDropdown ? 'rotate-180' : '', ({{ $isHomePage ? 'isScrolled' : 'true' }}) ? ((request()->routeIs('public.news*') || request()->routeIs('public.statistics') || request()->routeIs('public.gallery')) ? 'text-[#0A3D29]' : 'text-[#6C7B72]') : 'text-white']" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu Box Informasi -->
                        <div x-show="infoDropdown" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute left-0 mt-2 w-60 rounded-md p-0 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                             :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">
                            
                            <a href="{{ route('public.news.index') }}" 
                                class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6"/></svg>
                                <span>Berita & Pengumuman</span>
                            </a>

                            <a href="{{ route('public.statistics') }}" 
                                class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                <span>Statistik Desa</span>
                            </a>

                            <a href="{{ route('public.gallery') }}" 
                                class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Galeri Foto</span>
                            </a>
                        </div>
                    </div>

                    <!-- Layanan Publik Dropdown Button -->
                    <div class="relative inline-block" @click.away="layananDropdown = false">
                        <button @click="layananDropdown = !layananDropdown; profileDropdown = false; infoDropdown = false; literasiDropdown = false" 
                                type="button"
                                class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1 rounded-lg transition-all duration-700 ease-in-out focus:outline-none"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                    ? '{{ (request()->routeIs('public.services.*') || request()->routeIs('warga.letter.*') || request()->routeIs('warga.complaint.*')) ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                                    : '{{ (request()->routeIs('public.services.*') || request()->routeIs('warga.letter.*') || request()->routeIs('warga.complaint.*')) ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                            <span>Layanan</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" 
                                 :class="[layananDropdown ? 'rotate-180' : '', ({{ $isHomePage ? 'isScrolled' : 'true' }}) ? ((request()->routeIs('public.services.*') || request()->routeIs('warga.letter.*') || request()->routeIs('warga.complaint.*')) ? 'text-[#0A3D29]' : 'text-[#6C7B72]') : 'text-white']" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu Box Layanan Publik -->
                        <div x-show="layananDropdown" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute left-0 mt-2 w-72 rounded-md p-0 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                             :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">
                            
                            <!-- 1. Pusat Layanan Desa -->
                            <a href="{{ route('public.services.index') }}" 
                                class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9"/></svg>
                                <div>
                                    <span class="block font-bold">Pusat Layanan Desa</span>
                                    <span class="block text-[10px] font-normal opacity-75">Katalog & panduan lengkap pelayanan</span>
                                </div>
                            </a>

                            <!-- 2. Surat Online Mandiri -->
                            <a href="{{ route('warga.letter.index') }}" 
                                class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div>
                                    <span class="block font-bold">Surat Online Mandiri</span>
                                    <span class="block text-[10px] font-normal opacity-75">Permohonan SKU, SKD, SKTM, SKK</span>
                                </div>
                            </a>

                            <!-- 3. Pengaduan & Aspirasi Warga -->
                            <a href="{{ route('warga.complaint.index') }}" 
                                class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                                <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.684A1.76 1.76 0 013 12c0-.97.784-1.76 1.75-1.76l6.25 1.05M18 13l2.25 3.5"/></svg>
                                <div>
                                    <span class="block font-bold">Pengaduan & Aspirasi</span>
                                    <span class="block text-[10px] font-normal opacity-75">Saluran keluhan & masukan warga</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- PPKO Catur Cerdas UMS Direct Link -->
                    <a href="{{ route('public.ppko') }}" 
                       class="h-9 sm:h-10 px-3.5 inline-flex items-center rounded-lg transition-all duration-700 ease-in-out"
                       :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                           ? '{{ request()->routeIs('public.ppko') ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                           : '{{ request()->routeIs('public.ppko') ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                        <span>PPKO UMS</span>
                    </a>

                    <!-- Perpustakaan Button -->
                    <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1.5 rounded-lg transition-all duration-700 ease-in-out font-semibold"
                       :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-[#EAF1E8] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-white/20 hover:text-white'">
                        <span>Perpustakaan</span>
                        <svg class="w-3 h-3 transition-colors duration-700 ease-in-out" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#D9B85C]' : 'text-[#F5E8C7]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                </nav>

                <!-- 3. FAR RIGHT GROUP: SEARCH & ADMIN LOGIN BUTTON -->
                <div class="hidden lg:flex items-center space-x-1.5 xl:space-x-2 shrink-0 font-medium text-xs font-semibold">
                    
                    <!-- SEARCH FIELD (Pill Shape) -->
                    <div class="relative shrink-0" @click.away="searchOpen = false">
                        <form action="{{ route('public.search') }}" method="GET" @submit="searchOpen = false">
                            <div class="relative flex items-center">
                                <input type="text" 
                                       name="q" 
                                       x-model="searchQuery" 
                                       @input.debounce.300ms="fetchSuggestions()" 
                                       @focus="if(searchQuery.length >= 2) searchOpen = true"
                                       @keydown.escape="searchOpen = false"
                                       placeholder="Cari informasi..." 
                                       aria-label="Cari informasi di Desa Catur"
                                       class="h-9 w-36 lg:w-44 xl:w-48 pl-8 pr-7 rounded-xl text-xs font-medium border transition-all duration-700 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#0A3D29] focus:bg-white focus:text-[#20332A]"
                                       :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                           ? 'bg-[#EAF1E8]/70 backdrop-blur-md text-[#20332A] placeholder-[#6C7B72] border border-[#DCE6DA]/80' 
                                           : 'bg-white/20 backdrop-blur-md text-white placeholder-white/70 border border-white/25 focus:placeholder-[#6C7B72]'">
                                
                                <!-- Search Icon (Left) -->
                                <svg class="w-3.5 h-3.5 absolute left-3 pointer-events-none transition-colors duration-700 ease-in-out" 
                                     :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-white/80'" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                
                                <!-- Clear Button (Right) -->
                                <button type="button" 
                                        x-show="searchQuery.length > 0" 
                                        @click="searchQuery = ''; searchResults = []; searchOpen = false" 
                                        class="absolute right-2 transition-colors duration-700 ease-in-out p-0.5 rounded-full"
                                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72] hover:text-[#20332A]' : 'text-white/80 hover:text-white'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </form>

                        <!-- Live Suggestion Dropdown Panel -->
                        <div x-show="searchOpen && searchQuery.length >= 2" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 mt-2 w-80 lg:w-96 rounded-md py-1.5 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                             :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">
                            
                            <!-- Loading State -->
                            <div x-show="searchLoading" class="p-4 text-center text-xs flex items-center justify-center gap-2" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-slate-300'">
                                <svg class="animate-spin w-4 h-4" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span>Mencari informasi...</span>
                            </div>

                            <!-- No Results State -->
                            <div x-show="!searchLoading && searchResults.length === 0" class="p-4 text-center text-xs" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-slate-300'">
                                <p>Tidak ada hasil untuk "<span class="font-semibold" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A]' : 'text-white'" x-text="searchQuery"></span>"</p>
                            </div>

                            <!-- Results List -->
                            <div x-show="!searchLoading && searchResults.length > 0" class="max-h-80 overflow-y-auto divide-y" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'divide-slate-100' : 'divide-white/10'">
                                <template x-for="item in searchResults" :key="item.title">
                                    <a :href="item.url" 
                                       class="block px-4 py-2.5 w-full transition-colors text-left group"
                                       :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'hover:bg-black/[0.05]' : 'hover:bg-black/35'">
                                        <div class="flex items-center justify-between gap-1 mb-1">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md transition" 
                                                  :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29] bg-[#EAF1E8] group-hover:bg-[#0A3D29] group-hover:text-white' : 'text-[#D9B85C] bg-white/10 group-hover:bg-[#D9B85C] group-hover:text-[#061C12]'" 
                                                  x-text="item.badge"></span>
                                            <span class="text-[9px] uppercase font-semibold" 
                                                  :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-slate-300/80'" 
                                                  x-text="item.type"></span>
                                        </div>
                                        <span class="block text-xs font-bold transition line-clamp-1" 
                                              :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] group-hover:text-[#0A3D29]' : 'text-white group-hover:text-[#D9B85C]'" 
                                              x-text="item.title"></span>
                                        <span class="block text-[10px] font-normal line-clamp-1 mt-0.5" 
                                              :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-slate-300'" 
                                              x-text="item.snippet"></span>
                                    </a>
                                </template>
                            </div>

                            <!-- View All Results Footer Link -->
                            <div x-show="!searchLoading" class="pt-1 border-t text-center" :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'border-slate-100' : 'border-white/10'">
                                <a :href="'{{ route('public.search') }}?q=' + encodeURIComponent(searchQuery)" 
                                   class="block py-2 px-4 w-full text-xs font-bold transition"
                                   :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29] hover:text-[#145C3B] hover:bg-black/[0.05]' : 'text-[#D9B85C] hover:text-white hover:bg-black/35'">
                                    Lihat semua hasil pencarian →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Access Button (Icon Only) -->
                    <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" 
                       class="h-9 w-9 inline-flex items-center justify-center rounded-full transition-all duration-500 focus:outline-none"
                       :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                           ? 'text-[#20332A] hover:bg-[#EAF1E8] hover:text-[#0A3D29]' 
                           : 'text-white/90 hover:bg-white/20 hover:text-white'"
                       title="{{ auth()->check() ? 'Dashboard Admin (' . Auth::user()->name . ')' : 'Akses Admin (Login)' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>

                </div>

                <!-- MOBILE HEADER BRAND & HAMBURGER BUTTON -->
                <div class="flex items-center justify-between w-full lg:hidden">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
                        @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                            <img src="{{ asset('storage/' . $globalLogo) }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}" class="h-9 w-auto object-contain shrink-0">
                        @elseif(file_exists(public_path('images/logo_catur.png')))
                            <img src="{{ asset('images/logo_catur.png') }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}" class="h-9 w-auto object-contain shrink-0">
                        @else
                            <div class="w-9 h-9 bg-gradient-to-br from-[#0A3D29] to-[#145C3B] text-white rounded-lg flex items-center justify-center font-serif text-base font-bold shadow-xs">
                                DC
                            </div>
                        @endif
                        <span class="font-serif text-base font-bold transition-colors duration-700 ease-in-out"
                              :class="(isScrolled || mobileMenuOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
                                  ? 'text-[#0A3D29]' 
                                  : 'text-white'">
                            {{ $globalVillageName ?? 'Pemerintah Desa Catur' }}
                        </span>
                    </a>

                    <button @click.stop="mobileMenuOpen = !mobileMenuOpen" type="button" 
                            class="p-2 rounded-xl focus:outline-none flex items-center justify-center cursor-pointer transition-all duration-700 ease-in-out"
                            :class="(isScrolled || mobileMenuOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
                                ? (mobileMenuOpen ? 'text-[#0A3D29] bg-slate-100 active:bg-slate-200' : 'text-[#20332A] active:bg-[#EAF1E8]') 
                                : (mobileMenuOpen ? 'text-[#0A3D29] bg-white active:bg-white/80' : 'text-white active:bg-white/20')" 
                            aria-label="Buka Menu Mobile">
                        <!-- Hamburger Icon (When Closed) -->
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <!-- Close 'X' Icon (When Opened) -->
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6 transition-transform duration-200 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Backdrop Scrim for Mobile Drawer -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 top-20 bg-black/30 backdrop-blur-xs z-40 lg:hidden"
             aria-hidden="true">
        </div>

        <!-- Mobile Drawer Navigation Overlay (Glassmorphism Frosted Glass Style) -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-data="{ activeSection: null }"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             @click.away="mobileMenuOpen = false" 
             @click.stop
             class="absolute top-full inset-x-0 z-50 lg:hidden bg-white/85 backdrop-blur-2xl backdrop-saturate-150 border-b border-x border-slate-200/80 rounded-b-3xl text-[#20332A] shadow-2xl shadow-slate-900/10 max-h-[calc(100dvh-5rem)] overflow-y-auto overflow-x-hidden divide-y divide-slate-200/50">
            
            <!-- 1. Beranda (Direct Clean Link) -->
            <div class="nav-cascade-1">
                <a href="{{ route('home') }}" 
                   @click="mobileMenuOpen = false"
                   class="w-full flex items-center justify-between px-5 py-3.5 font-semibold text-sm transition-colors {{ request()->routeIs('home') ? 'bg-black/[0.06] text-[#0A3D29] font-bold' : 'text-slate-800 active:bg-black/[0.08]' }}">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 001 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Beranda</span>
                    </div>
                </a>
            </div>
            
            <!-- 2. Profil Desa (Collapsible Category) -->
            <div class="nav-cascade-2">
                <button type="button" 
                        @click="activeSection = (activeSection === 'profil' ? null : 'profil')"
                        class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold transition-colors text-slate-800 active:bg-black/[0.08]"
                        :class="activeSection === 'profil' ? 'bg-black/[0.04] text-[#0A3D29]' : ''">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9"/>
                        </svg>
                        <span>Profil Desa</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                         :class="activeSection === 'profil' ? 'rotate-180 text-[#0A3D29]' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeSection === 'profil'" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-900/[0.03] divide-y divide-slate-200/40 border-t border-slate-200/50">
                    <a href="{{ route('public.profile') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.profile') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Tentang & Sejarah Desa Catur</span>
                    </a>
                    <a href="{{ route('public.officials') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.officials') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Struktur Perangkat Desa</span>
                    </a>
                </div>
            </div>

            <!-- 3. Informasi Publik (Collapsible Category) -->
            <div class="nav-cascade-3">
                <button type="button" 
                        @click="activeSection = (activeSection === 'informasi' ? null : 'informasi')"
                        class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold transition-colors text-slate-800 active:bg-black/[0.08]"
                        :class="activeSection === 'informasi' ? 'bg-black/[0.04] text-[#0A3D29]' : ''">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6"/>
                        </svg>
                        <span>Informasi Publik</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                         :class="activeSection === 'informasi' ? 'rotate-180 text-[#0A3D29]' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeSection === 'informasi'" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-900/[0.03] divide-y divide-slate-200/40 border-t border-slate-200/50">
                    <a href="{{ route('public.news.index') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.news*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Warta & Pengumuman</span>
                    </a>
                    <a href="{{ route('public.statistics') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.statistics') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Statistik Desa</span>
                    </a>
                    <a href="{{ route('public.gallery') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.gallery') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Galeri Desa</span>
                    </a>
                </div>
            </div>

            <!-- 4. Layanan Warga (Collapsible Category) -->
            <div class="nav-cascade-4">
                <button type="button" 
                        @click="activeSection = (activeSection === 'layanan' ? null : 'layanan')"
                        class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold transition-colors text-slate-800 active:bg-black/[0.08]"
                        :class="activeSection === 'layanan' ? 'bg-black/[0.04] text-[#0A3D29]' : ''">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Layanan Warga</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                         :class="activeSection === 'layanan' ? 'rotate-180 text-[#0A3D29]' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeSection === 'layanan'" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-900/[0.03] divide-y divide-slate-200/40 border-t border-slate-200/50">
                    <a href="{{ route('public.services.index') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.services*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Pusat Layanan Terpadu Desa</span>
                    </a>
                    <a href="{{ route('warga.letter.index') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('warga.letter*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Permohonan Surat Online Mandiri</span>
                    </a>
                    <a href="{{ route('warga.complaint.index') }}" @click="mobileMenuOpen = false" 
                       class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('warga.complaint*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                        <span>Pengaduan & Aspirasi Warga</span>
                    </a>
                </div>
            </div>

            <!-- 5. PPKO Catur Cerdas UMS (Direct Standalone Link) -->
            <div class="nav-cascade-5">
                <a href="{{ route('public.ppko') }}" 
                   @click="mobileMenuOpen = false"
                   class="w-full flex items-center justify-between px-5 py-3.5 font-semibold text-sm transition-colors {{ request()->routeIs('public.ppko') ? 'bg-black/[0.06] text-[#0A3D29] font-bold' : 'text-slate-800 active:bg-black/[0.08]' }}">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        <span>PPKO Catur Cerdas UMS 2026</span>
                    </div>
                </a>
            </div>

            <!-- 6. Perpustakaan Digital (Direct Standalone Link) -->
            <div class="nav-cascade-6">
                <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   @click="mobileMenuOpen = false" 
                   class="w-full flex items-center justify-between px-5 py-3.5 font-semibold text-sm transition-colors text-slate-800 active:bg-black/[0.08]">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Perpustakaan Digital Remen Maos</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </div>
                </a>
            </div>

            <!-- 7. Mobile Admin Access -->
            <div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" 
                       class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-semibold transition-colors text-slate-800 active:bg-black/[0.08]">
                        <div class="flex items-center gap-3.5">
                            <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Dashboard Admin</span>
                        </div>
                        <span class="text-[10px] px-2 py-0.5 rounded-md bg-black/[0.05] font-medium text-slate-700">{{ Auth::user()->name }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-semibold transition-colors text-slate-700 active:bg-black/[0.08]">
                        <div class="flex items-center gap-3.5">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span>Akses Login Admin</span>
                        </div>
                        <span class="text-xs text-slate-400">→</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="grow">
        @yield('content')
    </main>



    <!-- ========================================================= -->
    <!-- FOOTER SECTION (CLEAN & ELEGANT DESA CATUR STYLE) -->
    <!-- ========================================================= -->
    <footer class="bg-[#0A3B28] text-white pt-14 pb-8">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 mb-10">
                
                <!-- Col 1: About & Info (4 cols) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-3">
                        @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                            <img src="{{ asset('storage/' . $globalLogo) }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}" class="h-10 w-auto object-contain shrink-0">
                        @elseif(file_exists(public_path('images/logo_catur.png')))
                            <img src="{{ asset('images/logo_catur.png') }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}" class="h-10 w-auto object-contain shrink-0">
                        @else
                            <div class="w-9 h-9 bg-white text-[#0A3B28] rounded-full flex items-center justify-center font-bold text-xs shadow-xs shrink-0">
                                DC
                            </div>
                        @endif
                        <div>
                            <h3 class="font-serif text-xl font-bold text-white tracking-wide leading-tight">Pemerintah Desa Catur</h3>
                            <p class="text-xs font-semibold text-[#D9B85C]">Kec. Sambi, Kab. Boyolali</p>
                        </div>
                    </div>

                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-light">
                        Portal transparansi dan layanan publik terpadu Pemerintah Desa Catur, mewujudkan tata kelola desa yang akuntabel, inklusif, dan melayani.
                    </p>

                    <div class="space-y-2 text-xs sm:text-sm text-slate-300 font-light pt-1">
                        <p class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#D9B85C] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $globalAddress ?? 'Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali 57376' }}</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#D9B85C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $globalEmail ?? 'pemdes@catur-boyolali.desa.id' }}</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#D9B85C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $globalPhone ?? '(0276) 321-0988' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Col 2: Tautan Cepat (3 cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-xs font-bold text-[#D9B85C] uppercase tracking-wider">TAUTAN CEPAT</h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-300 font-light">
                        <li><a href="{{ route('public.officials') }}" class="hover:text-white transition">Profil Perangkat Desa</a></li>
                        <li><a href="{{ route('public.services.index') }}" class="hover:text-white transition">Layanan Mandiri Warga</a></li>
                        <li><a href="{{ route('public.profile') }}" class="hover:text-white transition">Regulasi & Produk Hukum Desa</a></li>
                        <li><a href="{{ route('public.news.index') }}" class="hover:text-white transition">PPID & Informasi Publik</a></li>
                        <li><a href="{{ route('public.profile') }}" class="hover:text-white transition">Peta & Batas Wilayah Desa</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Surat Online (3 cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-xs font-bold text-[#D9B85C] uppercase tracking-wider">LAYANAN SURAT ONLINE</h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-300 font-light">
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan Usaha (SKU)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan Domisili</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Pengantar SKCK Kepolisian</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan Tidak Mampu (SKTM)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan Kelahiran / Kematian</a></li>
                    </ul>
                </div>

                <!-- Col 4: Jam Pelayanan & Call Center (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-xs font-bold text-[#D9B85C] uppercase tracking-wider">JAM PELAYANAN</h4>
                    <div class="space-y-2 text-xs sm:text-sm text-slate-300 font-light">
                        <p class="font-medium text-white">Kantor Desa Catur</p>
                        <p class="text-xs text-slate-300">Senin - Jumat: 08.00 - 15.30 WIB</p>
                        <p class="text-xs text-slate-400">Sabtu, Minggu & Libur: Tutup</p>
                        <div class="pt-2 border-t border-white/10 mt-3">
                            <span class="block text-[11px] font-bold text-[#D9B85C] uppercase tracking-wider">CALL CENTER 24 JAM</span>
                            <a href="tel:081234567890" class="block text-sm font-extrabold text-white hover:text-[#D9B85C] transition mt-0.5">0812-3456-7890</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Sub-Footer Bar -->
            <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400 font-semibold tracking-wider uppercase">
                <p>&copy; {{ date('Y') }} PEMERINTAH DESA CATUR | UU KIP NO. 14/2008</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition">KEBIJAKAN PRIVASI</a>
                    <a href="#" class="hover:text-white transition">SYARAT & KETENTUAN</a>
                    <a href="#" class="hover:text-white transition">PETA SITUS</a>
                </div>
            </div>
        </div>
    </footer>


    <!-- FLOATING MOBILE SEARCH BUTTON (LEFT SIDE) -->
    <div class="fixed bottom-6 left-6 z-[99999] lg:hidden font-sans pointer-events-auto flex flex-col items-start"
         @click.away="searchOpen = false">
        
        <!-- Floating Glassmorphism Search Icon-Only Button -->
        <button type="button" 
                @click="searchOpen = !searchOpen" 
                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/75 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl text-[#0A3D29] flex items-center justify-center cursor-pointer hover:scale-105 active:scale-95 transition-all duration-300 group shrink-0"
                aria-label="Cari Informasi"
                title="Cari Informasi">
            <svg x-show="!searchOpen" class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <svg x-show="searchOpen" class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Floating Glassmorphism Search Input & Suggestions Popup (Left Aligned Above Button) -->
        <div x-show="searchOpen" 
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 scale-90 translate-y-3"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-3"
             class="absolute bottom-16 left-0 w-[calc(100vw-3rem)] sm:w-96 bg-white/90 backdrop-blur-2xl backdrop-saturate-150 border border-white/90 rounded-3xl p-4 shadow-2xl text-[#20332A] space-y-3">
            
            <form action="{{ route('public.search') }}" method="GET" class="relative" @submit="searchOpen = false">
                <div class="relative flex items-center">
                    <input type="text" 
                           name="q" 
                           x-model="searchQuery" 
                           @input.debounce.300ms="fetchSuggestions()" 
                           placeholder="Cari informasi di Desa Catur..." 
                           aria-label="Cari informasi di Desa Catur"
                           class="w-full h-11 pl-10 pr-9 rounded-2xl text-xs font-semibold bg-[#F0F5EE] text-[#20332A] placeholder-[#6C7B72] border border-[#DCE6DA] focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
                    
                    <svg class="w-4 h-4 text-[#0A3D29] absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    
                    <button type="button" 
                            x-show="searchQuery.length > 0" 
                            @click="searchQuery = ''; searchResults = []" 
                            class="absolute right-3.5 text-[#6C7B72] hover:text-[#20332A]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </form>

            <!-- Live Suggestions List -->
            <div x-show="searchQuery.length >= 2" class="space-y-2">
                <div x-show="searchLoading" class="p-3 text-center text-xs text-[#6C7B72] flex items-center justify-center gap-2">
                    <svg class="animate-spin w-4 h-4 text-[#0A3D29]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Mencari informasi...</span>
                </div>

                <div x-show="!searchLoading && searchResults.length === 0" class="p-3 text-center text-xs text-[#6C7B72]">
                    <p>Tidak ada hasil untuk "<span class="font-semibold text-[#20332A]" x-text="searchQuery"></span>"</p>
                </div>

                <div x-show="!searchLoading && searchResults.length > 0" class="divide-y divide-slate-100 max-h-60 overflow-y-auto">
                    <template x-for="item in searchResults" :key="item.title">
                        <a :href="item.url" class="block p-2.5 rounded-xl hover:bg-[#EAF1E8] transition text-left group">
                            <div class="flex items-center justify-between gap-1 mb-1">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md text-[#0A3D29] bg-[#EAF1E8]" x-text="item.badge"></span>
                                <span class="text-[9px] uppercase font-semibold text-slate-400" x-text="item.type"></span>
                            </div>
                            <span class="block text-xs font-bold text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1" x-text="item.title"></span>
                            <span class="block text-[10px] font-normal text-[#6C7B72] line-clamp-1 mt-0.5" x-text="item.snippet"></span>
                        </a>
                    </template>
                </div>

                <div x-show="!searchLoading && searchResults.length > 0" class="pt-2 border-t border-slate-100 text-center">
                    <a :href="'{{ route('public.search') }}?q=' + encodeURIComponent(searchQuery)" class="block py-1.5 text-xs font-bold text-[#0A3D29] hover:bg-[#EAF1E8] rounded-xl transition">
                        Lihat semua hasil pencarian →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FLOATING SCROLL TO TOP BUTTON (RIGHT SIDE) -->
    <div class="fixed bottom-6 right-6 z-[99999] lg:hidden font-sans pointer-events-auto">
        <button type="button" 
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/75 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl text-[#0A3D29] flex items-center justify-center cursor-pointer hover:scale-105 active:scale-95 transition-all duration-300 group shrink-0"
                aria-label="Kembali ke Atas"
                title="Kembali ke Atas">
            <svg class="w-5 h-5 text-[#0A3D29] group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>

    <script>
        function navSearchApp() {
            return {
                mobileMenuOpen: false,
                profileDropdown: false,
                infoDropdown: false,
                layananDropdown: false,
                literasiDropdown: false,
                searchQuery: '{{ request('q', '') }}',
                searchResults: [],
                searchLoading: false,
                searchOpen: false,
                isScrolled: false,
                init() {
                    this.isScrolled = window.scrollY > 15;
                    window.addEventListener('scroll', () => {
                        this.isScrolled = window.scrollY > 15;
                    }, { passive: true });
                },
                fetchSuggestions() {
                    if (this.searchQuery.trim().length < 2) {
                        this.searchResults = [];
                        this.searchOpen = false;
                        return;
                    }
                    this.searchLoading = true;
                    this.searchOpen = true;
                    fetch('{{ route("api.search") }}?q=' + encodeURIComponent(this.searchQuery))
                        .then(res => res.json())
                        .then(data => {
                            this.searchResults = data.results || [];
                            this.searchLoading = false;
                        })
                        .catch(err => {
                            this.searchLoading = false;
                            this.searchResults = [];
                        });
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
