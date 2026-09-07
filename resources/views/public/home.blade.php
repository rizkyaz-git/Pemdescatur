@extends('layouts.public')

@section('title', 'Beranda - Web Profile Desa Catur Sambi Boyolali')

@section('content')

<!-- ========================================================= -->
<!-- SECTION 1: HERO SECTION (FULL LANDSCAPE BACKGROUND WITH SOFT GRADIENT OVERLAY) -->
<!-- ========================================================= -->
<section class="relative w-full bg-[#0A3D29] overflow-hidden -mt-20 pt-28 pb-36 min-h-screen min-h-[100dvh] flex flex-col justify-center items-center sm:min-h-0 sm:block sm:pt-44 sm:pb-32 lg:pt-48 lg:pb-36">
    
    <!-- Hero Background Image - Clear Scenic View with Soft Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ !empty($globalHeroImage) ? asset('storage/' . $globalHeroImage) : asset('images/hero_landscape.png') }}" 
             alt="Pemerintah Desa Catur Sambi Boyolali" 
             class="w-full h-full object-cover object-center brightness-[0.58] [mask-image:linear-gradient(to_bottom,black_85%,transparent_100%)] -webkit-[mask-image:linear-gradient(to_bottom,black_85%,transparent_100%)]">
        <!-- Soft Green Gradient Overlay for Text Contrast & High Image Visibility -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#041A12]/60 via-[#072F20]/45 to-[#0A3D29]/95 pointer-events-none"></div>
    </div>

    <!-- Content Container (Centered Vertically on Mobile, Exact Original Layout on Desktop) -->
    <div class="relative z-10 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 text-center flex-1 flex flex-col justify-center items-center py-5 sm:py-0 sm:block">
        <div class="max-w-xl sm:max-w-3xl lg:max-w-4xl mx-auto space-y-3 sm:space-y-6 flex flex-col items-center pt-0 sm:pt-8 lg:pt-10">
            
            <!-- 1. Headline (Fade Up Entrance Animation) -->
            <h1 class="font-serif text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-[1.2] sm:leading-[1.16] tracking-tight text-center max-w-4xl mx-auto drop-shadow-md fade-up-enter">
                Selamat Datang di Website Resmi Pemerintah Desa Catur
            </h1>

            <!-- 2. Location Address Text (Clean, Unwrapped Text Under Headline) -->
            <p class="text-xs sm:text-sm lg:text-base font-medium text-white/90 tracking-wide flex items-center justify-center gap-1.5 drop-shadow-sm mx-auto fade-up-enter [animation-delay:150ms]">
                <span class="whitespace-normal sm:whitespace-nowrap">Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali, Jawa Tengah 57376</span>
            </p>

        </div>
    </div>

</section>

<!-- FLOATING SHORTCUT CARDS CONTAINER (Overlapping Hero Section Exactly at 50% Center on Desktop, Raised Inside Hero on Mobile) -->
<div class="relative z-30 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-56 mb-32 sm:-mt-14 sm:mb-0 lg:-mt-16 fade-up-enter [animation-delay:250ms]">
    
    <!-- A. MOBILE MODE ONLY (< sm): Single Unified Floating Card with 5 Side-by-Side Items & Elevation Shadow -->
    <div class="block sm:hidden bg-white rounded-2xl shadow-[0_12px_30px_-5px_rgba(0,0,0,0.22)] border border-slate-100 ring-1 ring-slate-900/5 py-3 px-1.5">
        <div class="grid grid-cols-5 divide-x divide-slate-100 text-center">
            
            <!-- 1. Berita & Kabar -->
            <a href="{{ route('public.news.index') }}" class="flex flex-col items-center justify-center px-1 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6"/>
                </svg>
                <span class="block text-[11px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Warta</span>
            </a>

            <!-- 2. Pusat Layanan -->
            <a href="{{ route('public.services.index') }}" class="flex flex-col items-center justify-center px-1 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4"/>
                </svg>
                <span class="block text-[11px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Layanan</span>
            </a>

            <!-- 3. Statistik Desa -->
            <a href="{{ route('public.statistics') }}" class="flex flex-col items-center justify-center px-1 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
                <span class="block text-[11px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Statistik</span>
            </a>

            <!-- 4. Perpustakaan Digital -->
            <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center px-1 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="block text-[11px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Perpus</span>
            </a>

            <!-- 5. PPK Ormawa -->
            <a href="{{ route('public.ppko') }}" class="flex flex-col items-center justify-center px-1 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
                <span class="block text-[11px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">PPKO UMS</span>
            </a>

        </div>
    </div>

    <!-- B. TABLET/DESKTOP MODE (>= sm): Single Unified Bar Card Container with Thin Vertical Dividers & Clean Alignment -->
    <div class="hidden sm:block bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden">
        <div class="grid grid-cols-2 lg:grid-cols-5 divide-y lg:divide-y-0 lg:divide-x divide-slate-100/90">
            
            <!-- Card 1: Berita & Kabar -->
            <a href="{{ route('public.news.index') }}" 
               class="p-5 lg:p-6 flex flex-col space-y-2 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6"/>
                    </svg>
                    <h3 class="font-serif text-base lg:text-lg font-bold text-slate-900 leading-snug">
                        Warta Desa
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Informasi agenda, pengumuman, dan warta desa.
                </p>
            </a>

            <!-- Card 2: Pusat Layanan -->
            <a href="{{ route('public.services.index') }}" 
               class="p-5 lg:p-6 flex flex-col space-y-2 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4"/>
                    </svg>
                    <h3 class="font-serif text-base lg:text-lg font-bold text-slate-900 leading-snug">
                        Pusat Layanan
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    layanan surat online mandiri, pengaduan, dan aspirasi.
                </p>
            </a>

            <!-- Card 3: Statistik Desa -->
            <a href="{{ route('public.statistics') }}" 
               class="p-5 lg:p-6 flex flex-col space-y-2 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                    <h3 class="font-serif text-base lg:text-lg font-bold text-slate-900 leading-snug">
                        Statistik Desa
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Lihat informasi seputar statistik desa selengkapnya.
                </p>
            </a>

            <!-- Card 4: Perpustakaan Digital -->
            <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" 
               target="_blank" rel="noopener noreferrer"
               class="p-5 lg:p-6 flex flex-col space-y-2 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="font-serif text-base lg:text-lg font-bold text-slate-900 leading-snug">
                        Remen Maos
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Jelajahi koleksi buku digital dari perpustakaan online desa.
                </p>
            </a>

            <!-- Card 5: PPK Ormawa -->
            <a href="{{ route('public.ppko') }}" 
               class="p-5 lg:p-6 flex flex-col space-y-2 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <h3 class="font-serif text-base lg:text-lg font-bold text-slate-900 leading-snug">
                        PPKO UMS
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Halaman PPK Ormawa Catur Cerdas UMS 2026
                </p>
            </a>

        </div>
    </div>

</div>

<!-- ========================================================= -->
<!-- SECTION 2: BERITA TERKINI (FEATURED & EDITORIAL MAGAZINE LAYOUT) -->
<!-- ========================================================= -->
<section id="berita-terkini" class="w-full bg-white pt-20 pb-8 sm:pt-28 sm:pb-10 lg:pt-32 lg:pb-12 border-b border-[#c5c6ce]/50 fade-up-scroll">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-200 text-center sm:text-left">
            <h2 class="font-['Public_Sans',sans-serif] text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight">
                Berita Terkini
            </h2>
            
            <!-- Desktop Action Button (Right Aligned) -->
            <a href="{{ route('public.news.index') }}" 
               class="hidden sm:inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 shrink-0">
                <span>Lihat Semua Berita</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        {{-- 1. MOBILE ONLY AUTO-SLIDING CAROUSEL (lg:hidden) --}}
        <div class="block lg:hidden relative" x-data="{ 
            activeSlide: 0, 
            totalSlides: {{ (isset($latestNews) && $latestNews->count() > 0) ? min($latestNews->count(), 4) : 3 }},
            timer: null,
            init() {
                this.startAutoSlide();
            },
            startAutoSlide() {
                this.stopAutoSlide();
                this.timer = setInterval(() => {
                    this.nextSlide();
                }, 3500);
            },
            stopAutoSlide() {
                if (this.timer) clearInterval(this.timer);
            },
            nextSlide() {
                this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            },
            prevSlide() {
                this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
            }
        }" @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()" @touchstart="stopAutoSlide()" @touchend="startAutoSlide()">
            
            <div class="relative overflow-hidden">
                <div class="flex transition-transform duration-500 ease-out" 
                     :style="`transform: translateX(-${activeSlide * 100}%);`">
                    
                    @if(isset($latestNews) && $latestNews->count() > 0)
                        @foreach($latestNews->take(4) as $news)
                            <div class="w-full shrink-0 px-0.5">
                                <a href="{{ route('public.news.show', $news->slug) }}" class="group block space-y-2.5">
                                    <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden bg-slate-100 shadow-2xs"
                                         x-data="{ loaded: false }"
                                         x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                        <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                        <img x-ref="img"
                                             src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : asset('images/sawah_irigasi.png') }}" 
                                             alt="{{ $news->title }}" 
                                             loading="lazy"
                                             @load="loaded = true;"
                                             class="w-full h-full object-cover transition-all duration-700"
                                             :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                    </div>
                                    <div class="space-y-1.5">
                                        <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">
                                            {{ $news->category->name ?? 'Kegiatan' }}
                                        </span>
                                        <h3 class="font-['Public_Sans',sans-serif] text-lg sm:text-xl font-extrabold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug">
                                            {{ $news->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                            <span>{{ optional($news->published_at)->format('d M Y') ?? '02 Sep 2026' }}</span>
                                            <span>•</span>
                                            <span>{{ $news->author->name ?? 'Admin Desa' }}</span>
                                        </div>
                                        <p class="text-xs text-[#44474e] leading-relaxed font-normal">
                                            {{ Str::limit(strip_tags($news->content), 130) }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <!-- Mobile Fallback Slide 1 -->
                        <div class="w-full shrink-0 px-0.5">
                            <a href="{{ route('public.news.index') }}" class="group block space-y-2.5">
                                <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 shadow-2xs"
                                     x-data="{ loaded: false }"
                                     x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                    <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                    <img x-ref="img"
                                         src="{{ asset('images/sawah_irigasi.png') }}" 
                                         alt="Kerja Bakti" 
                                         loading="lazy"
                                         @load="loaded = true;"
                                         class="w-full h-full object-cover transition-all duration-700"
                                         :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                </div>
                                <div class="space-y-1.5">
                                    <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Kegiatan</span>
                                    <h3 class="font-['Public_Sans',sans-serif] text-lg font-extrabold text-[#191c1e] leading-snug">
                                        Panen Padi Organik Melimpah 3 Kali Sehatun Didukung Irigasi Desa Catur
                                    </h3>
                                    <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                        <span>02 Sep 2026</span> • <span>Admin Desa</span>
                                    </div>
                                    <p class="text-xs text-[#44474e] leading-relaxed font-normal">
                                        Sektor pertanian Desa Catur, Kecamatan Sambi Boyolali tergolong sangat produktif...
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endif

                </div>

                <!-- Floating Arrow Buttons -->
                <button @click="prevSlide(); startAutoSlide()" 
                        class="absolute left-2 top-[28%] -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md shadow-md text-[#191c1e] hover:bg-[#0A3D29] hover:text-white flex items-center justify-center transition-all border border-[#c5c6ce]/60"
                        aria-label="Berita Sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button @click="nextSlide(); startAutoSlide()" 
                        class="absolute right-2 top-[28%] -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md shadow-md text-[#191c1e] hover:bg-[#0A3D29] hover:text-white flex items-center justify-center transition-all border border-[#c5c6ce]/60"
                        aria-label="Berita Selanjutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <!-- Dots Indicator -->
            <div class="flex items-center justify-center gap-1.5 pt-3">
                <template x-for="i in totalSlides" :key="i">
                    <button @click="activeSlide = i - 1; startAutoSlide()" 
                            class="h-1.5 rounded-full transition-all duration-300"
                            :class="activeSlide === (i - 1) ? 'w-6 bg-[#0A3D29]' : 'w-1.5 bg-[#c5c6ce]'"></button>
                </template>
            </div>
        </div>

        {{-- 2. DESKTOP ONLY EDITORIAL GRID (hidden lg:grid) --}}
        @if(isset($latestNews) && $latestNews->count() > 0)
            @php
                $firstNews = $latestNews->first();
                $sideNews = $latestNews->slice(1, 3);
            @endphp

            <div class="hidden lg:grid grid-cols-12 gap-8 items-start">
                @if($firstNews)
                    <div class="col-span-7">
                        <a href="{{ route('public.news.show', $firstNews->slug) }}" class="group block space-y-2.5">
                            <div class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-100 shadow-2xs group-hover:shadow-md transition-all duration-500"
                                 x-data="{ loaded: false }"
                                 x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                <img x-ref="img"
                                     src="{{ $firstNews->thumbnail ? asset('storage/' . $firstNews->thumbnail) : asset('images/sawah_irigasi.png') }}" 
                                     alt="{{ $firstNews->title }}" 
                                     loading="lazy"
                                     @load="loaded = true;"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700"
                                     :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                            </div>

                            <div class="space-y-1.5">
                                <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">
                                    {{ $firstNews->category->name ?? 'Kegiatan' }}
                                </span>

                                <h3 class="font-['Public_Sans',sans-serif] text-xl lg:text-2xl font-extrabold text-slate-800 group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    {{ $firstNews->title }}
                                </h3>

                                <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                    <span>{{ optional($firstNews->published_at)->format('d M Y') ?? '12 Okt 2023' }}</span>
                                    <span>•</span>
                                    <span>{{ $firstNews->author->name ?? 'Admin Desa' }}</span>
                                </div>

                                <p class="text-xs sm:text-sm text-[#44474e] leading-relaxed font-normal line-clamp-2">
                                    {{ Str::limit(strip_tags($firstNews->content), 140) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endif

                <div class="col-span-5 space-y-4">
                    @foreach($sideNews as $news)
                        <a href="{{ route('public.news.show', $news->slug) }}" class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                            <div class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs group-hover:shadow-xs transition-all duration-300"
                                 x-data="{ loaded: false }"
                                 x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                <img x-ref="img"
                                     src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : asset('images/hero_landscape.png') }}" 
                                     alt="{{ $news->title }}" 
                                     loading="lazy"
                                     @load="loaded = true;"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700"
                                     :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                            </div>

                            <div class="space-y-1 flex-1 min-w-0">
                                <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">
                                    {{ $news->category->name ?? 'Informasi' }}
                                </span>

                                <h4 class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    {{ $news->title }}
                                </h4>

                                <p class="text-[11px] text-[#75777e] font-medium">
                                    {{ optional($news->published_at)->format('d M Y') ?? '12 Okt 2023' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Desktop Fallback Mockup Layout -->
            <div class="hidden lg:grid grid-cols-12 gap-8 items-start">
                <div class="col-span-7">
                    <a href="{{ route('public.news.index') }}" class="group block space-y-2.5">
                        <div class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-100 shadow-2xs group-hover:shadow-md transition-all duration-500">
                            <img src="{{ asset('images/sawah_irigasi.png') }}" alt="Kerja Bakti" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        </div>
                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Kegiatan Desa</span>
                            <h3 class="font-['Public_Sans',sans-serif] text-xl lg:text-2xl font-extrabold text-slate-800 group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                Kerja Bakti Rutin Bersihkan Saluran Irigasi Jelang Musim Tanam Padi
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                <span>12 Okt 2023</span> • <span>Admin Desa</span>
                            </div>
                            <p class="text-xs sm:text-sm text-[#44474e] leading-relaxed font-normal line-clamp-2">
                                Warga Desa Catur bergotong royong membersihkan saluran irigasi utama untuk menyambut musim tanam padi...
                            </p>
                        </div>
                    </a>
                </div>

                <div class="col-span-5 space-y-4">
                    <a href="{{ route('public.news.index') }}" class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                        <div class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs">
                            <img src="{{ asset('images/hero_landscape.png') }}" alt="Pembangunan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="space-y-1 flex-1 min-w-0">
                            <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Pembangunan</span>
                            <h4 class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                Peningkatan Kualitas Jalan Poros Dusun I Selesai Dikerjakan
                            </h4>
                            <p class="text-[11px] text-[#75777e] font-medium">10 Okt 2023 • Admin Desa</p>
                        </div>
                    </a>

                    <a href="{{ route('public.news.index') }}" class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                        <div class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs">
                            <img src="{{ asset('images/umbul_siraman.png') }}" alt="Pemberdayaan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="space-y-1 flex-1 min-w-0">
                            <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Pemberdayaan</span>
                            <h4 class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                Pelatihan Pengolahan Hasil Pertanian bagi Kelompok Tani & UMKM
                            </h4>
                            <p class="text-[11px] text-[#75777e] font-medium">08 Okt 2023 • Admin Desa</p>
                        </div>
                    </a>

                    <a href="{{ route('public.news.index') }}" class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                        <div class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs">
                            <img src="{{ asset('images/logo_catur.png') }}" alt="Pengumuman" class="w-full h-full object-contain p-2.5 bg-[#f2f4f6]">
                        </div>
                        <div class="space-y-1 flex-1 min-w-0">
                            <span class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Pengumuman</span>
                            <h4 class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                Penyesuaian Jam Pelayanan Kantor Desa Catur Selama Bulan Ini
                            </h4>
                            <p class="text-[11px] text-[#75777e] font-medium">05 Okt 2023 • Sekretariat Desa</p>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        <!-- Mobile Bottom Action Button: Lihat Semua Berita (block sm:hidden) -->
        <div class="block sm:hidden text-center pt-2">
            <a href="{{ route('public.news.index') }}" 
               class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 min-h-[44px]">
                <span>Lihat Semua Berita</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Subtle Fade-Up Entrance Animations for Home Page */
    @keyframes fadeUpSubtle {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-up-enter {
        animation: fadeUpSubtle 0.75s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .fade-up-scroll {
        opacity: 0;
        transform: translateY(18px);
        transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }

    .fade-up-scroll.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

<!-- ========================================================= -->
<!-- SECTION 3: PERPUSTAKAAN DIGITAL "REMEN MAOS DESA CATUR" -->
<!-- ========================================================= -->
<section id="perpustakaan-digital" 
         class="w-full bg-[#f8fafc] py-16 sm:py-20 lg:py-24 border-b border-[#c5c6ce]/50 overflow-hidden flex items-center min-h-[580px] lg:min-h-[640px] fade-up-scroll">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-center">
            
            {{-- Left Column: Text & Bullet Points & Action Button (order-2 on mobile, order-1 on desktop) --}}
            <div class="order-2 lg:order-1 lg:col-span-5 space-y-6 sm:space-y-7 text-center lg:text-left">

                {{-- Headline & Description --}}
                <div class="space-y-3.5">
                    <h2 class="font-['Public_Sans',sans-serif] text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0A3D29] leading-tight tracking-tight">
                        Perpustakaan Digital Remen Maos Desa Catur
                    </h2>
                    
                    <p class="text-sm sm:text-base text-slate-600 font-normal leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Akses perpustakaan digital hanya dari genggaman anda, Jelajahi koleksi buku menarik dimanapun dan kapanpun.
                    </p>
                </div>

                {{-- 3 Bullet Points with Dark Green Circle Checkmarks --}}
                <div class="space-y-3.5 pt-1 inline-flex flex-col items-start text-left max-w-md mx-auto lg:mx-0">
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-[#0A3D29] text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-slate-800">1.000+ Judul Buku Digital & Edukasi</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-[#0A3D29] text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-slate-800">Akses Gratis 24 Jam Tanpa Batas</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-[#0A3D29] text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-slate-800">Tersinkronisasi Perpustakaan Daerah Boyolali</span>
                    </div>
                </div>

                {{-- Action Button: Buka Perpustakaan Digital ↗ --}}
                <div class="pt-2 flex justify-center lg:justify-start">
                    <a href="{{ $libraryUrl ?? 'https://perpustakaan.boyolali.go.id' }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2.5 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 group shrink-0">
                        <span>Buka Perpustakaan Digital</span>
                        <svg class="w-4 h-4 text-white group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>

            </div>

            {{-- Right Column: Transparent Seamless 3D Multi-Device Showcase Image (order-1 on mobile, order-2 on desktop) --}}
            <div class="order-1 lg:order-2 lg:col-span-7">
                <div class="w-full max-w-[640px] mx-auto relative"
                     x-data="{ loaded: false }"
                     x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                    <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none rounded-2xl"></div>
                    <img x-ref="img"
                         src="{{ asset('images/remen_maos_mockup.png') }}" 
                         alt="Remen Maos Desa Catur Multi-Device Showcase" 
                         loading="lazy"
                         @load="loaded = true;"
                         class="w-full h-auto object-contain drop-shadow-2xl hover:scale-[1.03] transition-all duration-700 pointer-events-auto"
                         :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAIN CONTAINER FOR LOWER SECTIONS (Aparatur Desa, Peta) -->
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 sm:pt-10 sm:pb-16 space-y-16 fade-up-scroll">

    <!-- ========================================================= -->
    <!-- SECTION 4: APARATUR DESA (PERANGKAT DESA CATUR)             -->
    <!-- ========================================================= -->
    <section class="py-4 space-y-6 lg:space-y-8">
        
        <!-- Header Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-200 text-center sm:text-left">
            <h2 class="font-['Public_Sans',sans-serif] text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight">
                Perangkat Desa Catur
            </h2>
            
            <!-- Desktop Action Button (Right Aligned) -->
            <a href="{{ route('public.officials') }}" 
               class="hidden sm:inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 shrink-0">
                <span>Lihat Semua Aparatur</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        {{-- 1. MOBILE ONLY SINGLE-CARD AUTO-SLIDING & SWIPEABLE CAROUSEL (sm:hidden) --}}
        <div class="block sm:hidden relative" x-data="{ 
            activeSlide: 0, 
            totalSlides: {{ (isset($officials) && $officials->count() > 0) ? min($officials->count(), 8) : 4 }},
            timer: null,
            touchStartX: 0,
            touchEndX: 0,
            init() {
                this.startAutoSlide();
            },
            startAutoSlide() {
                this.stopAutoSlide();
                this.timer = setInterval(() => {
                    this.nextSlide();
                }, 3500);
            },
            stopAutoSlide() {
                if (this.timer) clearInterval(this.timer);
            },
            nextSlide() {
                this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            },
            prevSlide() {
                this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
            },
            handleTouchStart(e) {
                this.touchStartX = e.changedTouches[0].screenX;
                this.stopAutoSlide();
            },
            handleTouchEnd(e) {
                this.touchEndX = e.changedTouches[0].screenX;
                if (this.touchEndX < this.touchStartX - 40) {
                    this.nextSlide();
                } else if (this.touchEndX > this.touchStartX + 40) {
                    this.prevSlide();
                }
                this.startAutoSlide();
            }
        }" @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()">
            
            <div class="relative overflow-hidden py-1">
                <div class="flex transition-transform duration-500 ease-out" 
                     :style="`transform: translateX(-${activeSlide * 100}%);`"
                     @touchstart="handleTouchStart($event)"
                     @touchend="handleTouchEnd($event)">
                    
                    @if(isset($officials) && $officials->count() > 0)
                        @foreach($officials as $official)
                            <div class="w-full shrink-0 flex justify-center px-4">
                                {{-- Compact Minimalist Mobile Card --}}
                                <div class="w-full max-w-[230px] p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between text-center">
                                    <div>
                                        <!-- Photo Container (Compact with Sparkling Shimmer Skeleton) -->
                                        <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-2.5 flex items-center justify-center shadow-2xs"
                                             x-data="{ loaded: false }"
                                             x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                            @if($official->photo_path)
                                                <!-- Shimmer Skeleton Glow (Active only while loading) -->
                                                <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                                <img x-ref="img"
                                                     src="{{ asset('storage/' . $official->photo_path) }}" 
                                                     alt="{{ $official->name }}" 
                                                     loading="lazy"
                                                     @load="loaded = true;"
                                                     class="relative z-10 w-full h-full object-cover object-top transition-all duration-700"
                                                     :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Position Text -->
                                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                            {{ $official->position }}
                                        </p>

                                        <!-- Official Name -->
                                        <h3 class="font-['Public_Sans',sans-serif] text-sm font-extrabold text-slate-800 leading-snug line-clamp-2">
                                            {{ $official->name }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Mobile Fallback Card 1: Kepala Desa -->
                        <div class="w-full shrink-0 flex justify-center px-4">
                            <div class="w-full max-w-[230px] p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between text-center">
                                <div>
                                    <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-2.5 flex items-center justify-center shadow-2xs">
                                        <div class="w-12 h-12 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                        Kepala Desa Catur
                                    </p>
                                    <h3 class="font-['Public_Sans',sans-serif] text-sm font-extrabold text-slate-800 leading-snug">
                                        Dra. NUNIK S RAHAYU, M.Pd
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Fallback Card 2: Sekretaris Desa -->
                        <div class="w-full shrink-0 flex justify-center px-4">
                            <div class="w-full max-w-[230px] p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between text-center">
                                <div>
                                    <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-2.5 flex items-center justify-center shadow-2xs">
                                        <div class="w-12 h-12 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                        Sekretaris Desa
                                    </p>
                                    <h3 class="font-['Public_Sans',sans-serif] text-sm font-extrabold text-slate-800 leading-snug">
                                        Bambang Sugeng, S.Sos.
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Fallback Card 3: Kaur Keuangan -->
                        <div class="w-full shrink-0 flex justify-center px-4">
                            <div class="w-full max-w-[230px] p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between text-center">
                                <div>
                                    <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-2.5 flex items-center justify-center shadow-2xs">
                                        <div class="w-12 h-12 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                        Kaur Keuangan
                                    </p>
                                    <h3 class="font-['Public_Sans',sans-serif] text-sm font-extrabold text-slate-800 leading-snug">
                                        Siti Rahmawati, A.Md.
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Fallback Card 4: Kaur Perencanaan & Umum -->
                        <div class="w-full shrink-0 flex justify-center px-4">
                            <div class="w-full max-w-[230px] p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex flex-col justify-between text-center">
                                <div>
                                    <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-2.5 flex items-center justify-center shadow-2xs">
                                        <div class="w-12 h-12 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                        Kaur Perencanaan & Umum
                                    </p>
                                    <h3 class="font-['Public_Sans',sans-serif] text-sm font-extrabold text-slate-800 leading-snug">
                                        Tri Santoso, S.T.
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Floating Navigation Arrow Buttons for Mobile Carousel -->
                <button @click="prevSlide(); startAutoSlide()" 
                        class="absolute left-1 top-[42%] -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white/95 backdrop-blur-md shadow-md text-[#191c1e] hover:bg-[#0A3D29] hover:text-white flex items-center justify-center transition-all border border-[#c5c6ce]/60 active:scale-90"
                        aria-label="Aparatur Sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button @click="nextSlide(); startAutoSlide()" 
                        class="absolute right-1 top-[42%] -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white/95 backdrop-blur-md shadow-md text-[#191c1e] hover:bg-[#0A3D29] hover:text-white flex items-center justify-center transition-all border border-[#c5c6ce]/60 active:scale-90"
                        aria-label="Aparatur Selanjutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Carousel Indicators (Dots) --}}
            <div class="flex justify-center items-center gap-1.5 pt-3">
                <template x-for="i in totalSlides" :key="i">
                    <button @click="activeSlide = i - 1; startAutoSlide()" 
                            class="h-1.5 rounded-full transition-all duration-300"
                            :class="activeSlide === (i - 1) ? 'w-5 bg-[#0A3D29]' : 'w-1.5 bg-slate-300'"
                            :aria-label="'Slide ' + i">
                    </button>
                </template>
            </div>
        </div>

        {{-- 2. DESKTOP/TABLET GRID (hidden sm:grid) --}}
        <div class="hidden sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($officials) && $officials->count() > 0)
                @foreach($officials->take(4) as $official)
                    <div class="group flex flex-col justify-between p-3.5 sm:p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-[#0A3D29]/30 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div>
                            <!-- Photo Container with Sparkling Shimmer Skeleton Glow -->
                            <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3.5 flex items-center justify-center shadow-2xs"
                                 x-data="{ loaded: false }"
                                 x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                @if($official->photo_path)
                                    <!-- Shimmer Skeleton Glow (Active only while loading) -->
                                    <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                    <img x-ref="img"
                                         src="{{ asset('storage/' . $official->photo_path) }}" 
                                         alt="{{ $official->name }}" 
                                         loading="lazy"
                                         @load="loaded = true;"
                                         class="relative z-10 w-full h-full object-cover object-top group-hover:scale-105 transition-all duration-700"
                                         :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] group-hover:bg-emerald-50 transition-colors">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Position Text (Minimalist Typography, No Wrapper) -->
                            <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                                {{ $official->position }}
                            </p>

                            <!-- Official Name (Bold Contrast) -->
                            <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                {{ $official->name }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Mockup Card 1: Kepala Desa -->
                <div class="group flex flex-col justify-between p-3.5 sm:p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-[#0A3D29]/30 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div>
                        <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3.5 flex items-center justify-center shadow-2xs">
                            <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] transition-colors">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                            Kepala Desa Catur
                        </p>
                        <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 leading-snug">
                            Dra. NUNIK S RAHAYU, M.Pd
                        </h3>
                    </div>
                </div>

                <!-- Mockup Card 2: Sekretaris Desa -->
                <div class="group flex flex-col justify-between p-3.5 sm:p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-[#0A3D29]/30 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div>
                        <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3.5 flex items-center justify-center shadow-2xs">
                            <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] transition-colors">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                            Sekretaris Desa
                        </p>
                        <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 leading-snug">
                            Bambang Sugeng, S.Sos.
                        </h3>
                    </div>
                </div>

                <!-- Mockup Card 3: Kaur Keuangan -->
                <div class="group flex flex-col justify-between p-3.5 sm:p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-[#0A3D29]/30 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div>
                        <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3.5 flex items-center justify-center shadow-2xs">
                            <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] transition-colors">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                            Kaur Keuangan
                        </p>
                        <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 leading-snug">
                            Siti Rahmawati, A.Md.
                        </h3>
                    </div>
                </div>

                <!-- Mockup Card 4: Kaur Perencanaan & Umum -->
                <div class="group flex flex-col justify-between p-3.5 sm:p-4 rounded-2xl bg-white border border-slate-200/80 hover:border-[#0A3D29]/30 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div>
                        <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3.5 flex items-center justify-center shadow-2xs">
                            <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] transition-colors">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                            Kaur Perencanaan & Umum
                        </p>
                        <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 leading-snug">
                            Tri Santoso, S.T.
                        </h3>
                    </div>
                </div>
            @endif
        </div>

        <!-- Mobile Bottom Action Button: Lihat Semua Aparatur (block sm:hidden) -->
        <div class="block sm:hidden text-center pt-2">
            <a href="{{ route('public.officials') }}" 
               class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 min-h-[44px]">
                <span>Lihat Semua Aparatur</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </section>

</div> <!-- End of Main Container -->

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.05,
            rootMargin: '0px 0px -30px 0px'
        });

        document.querySelectorAll('.fade-up-scroll').forEach(el => observer.observe(el));
    });
</script>
@endpush

@endsection
