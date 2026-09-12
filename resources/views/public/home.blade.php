@extends('layouts.public')

@section('title', 'Beranda - Web Profile Desa Catur Sambi Boyolali')

@section('content')

    <!-- ========================================================= -->
    <!-- SECTION 1: HERO SECTION (FULL LANDSCAPE BACKGROUND WITH SOFT GRADIENT OVERLAY) -->
    <!-- ========================================================= -->
    <section
        class="relative w-full bg-[#0A3D29] overflow-hidden -mt-20 pt-28 pb-36 min-h-screen min-h-[100dvh] flex flex-col justify-center items-center sm:min-h-0 sm:block sm:pt-44 sm:pb-32 lg:pt-48 lg:pb-36">

        @php
            $heroImageSrc = (!empty($globalHeroImage) && (file_exists(public_path('storage/' . $globalHeroImage)) || file_exists(storage_path('app/public/' . $globalHeroImage))))
                ? asset('storage/' . $globalHeroImage)
                : asset('images/hero_landscape.png');
        @endphp
        <!-- Hero Background Image - Clear Scenic View with Soft Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImageSrc }}" alt="Pemerintah Desa Catur Sambi Boyolali"
                class="w-full h-full object-cover object-center brightness-[0.58] [mask-image:linear-gradient(to_bottom,black_85%,transparent_100%)] -webkit-[mask-image:linear-gradient(to_bottom,black_85%,transparent_100%)]">
            <!-- Soft Green Gradient Overlay for Text Contrast & High Image Visibility -->
            <div
                class="absolute inset-0 bg-gradient-to-b from-[#041A12]/60 via-[#072F20]/45 to-[#0A3D29]/95 pointer-events-none">
            </div>
        </div>

        <!-- Content Container (Centered Vertically on Mobile, Exact Original Layout on Desktop) -->
        <div
            class="relative z-10 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 text-center flex-1 flex flex-col justify-center items-center py-5 sm:py-0 sm:block">
            <div
                class="max-w-xl sm:max-w-3xl lg:max-w-4xl mx-auto space-y-3 sm:space-y-6 flex flex-col items-center pt-0 sm:pt-8 lg:pt-10">

                <!-- 1. Headline (Fade Up Entrance Animation) -->
                <h1
                    class="font-serif text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-[1.2] sm:leading-[1.16] tracking-tight text-center max-w-4xl mx-auto drop-shadow-md fade-up-enter">
                    Selamat Datang di Website Resmi Pemerintah Desa Catur
                </h1>

                <!-- 2. Location Address Text (Clean, Unwrapped Text Under Headline) -->
                <p
                    class="text-xs sm:text-sm lg:text-base font-medium text-white/90 tracking-wide flex items-center justify-center gap-1.5 drop-shadow-sm mx-auto fade-up-enter [animation-delay:150ms]">
                    <span class="whitespace-normal sm:whitespace-nowrap">Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi,
                        Kab. Boyolali, Jawa Tengah 57376</span>
                </p>

            </div>
        </div>

    </section>

    <!-- FLOATING SHORTCUT CARDS CONTAINER (Overlapping Hero Section Exactly at 50% Center on Desktop, Raised Inside Hero on Mobile) -->
    <div
        class="relative z-30 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-56 mb-28 sm:-mt-14 sm:mb-6 lg:-mt-16 lg:mb-10 fade-up-enter [animation-delay:250ms]">

        <!-- A. MOBILE MODE ONLY (< sm): Single Unified Floating Card with 5 Side-by-Side Items & Elevation Shadow -->
        <div
            class="block sm:hidden bg-white rounded-2xl shadow-[0_12px_30px_-5px_rgba(0,0,0,0.22)] border border-slate-100 ring-1 ring-slate-900/5 py-3 px-1">
            <div class="grid grid-cols-5 divide-x divide-slate-100 text-center">

                <!-- 1. Berita & Kabar -->
                <a href="{{ route('public.news.index') }}"
                    class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                    <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6" />
                    </svg>
                    <span
                        class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Berita</span>
                </a>

                <!-- 2. Surat Mandiri -->
                <a href="{{ route('warga.letter.index') }}"
                    class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                    <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span
                        class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Surat</span>
                </a>

                <!-- 3. Pengaduan Warga -->
                <a href="{{ route('warga.complaint.index') }}"
                    class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                    <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.01 5.395m-1.01-5.395c.379 1.764.575 3.567.575 5.395 0 1.828-.196 3.631-.575 5.395m0 0a23.909 23.909 0 01-1.01 5.395m1.01-5.395A23.74 23.74 0 0118.795 21" />
                    </svg>
                    <span
                        class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Aduan</span>
                </a>

                <!-- 4. Perpustakaan Digital -->
                <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" target="_blank"
                    rel="noopener noreferrer"
                    class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                    <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span
                        class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Perpus</span>
                </a>

                <!-- 5. PPK Ormawa -->
                <a href="{{ route('public.ppko') }}"
                    class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                    <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span
                        class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">PPKO</span>
                </a>

            </div>
        </div>

        <!-- B. TABLET/DESKTOP MODE (>= sm): Single Unified Bar Card Container with Thin Vertical Dividers & Clean Alignment -->
        <div class="hidden sm:block bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 divide-y sm:divide-y-0 sm:divide-x divide-slate-100/90">

                <!-- Card 1: Berita & Kabar -->
                <a href="{{ route('public.news.index') }}"
                    class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6" />
                        </svg>
                        <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                            Berita Desa
                        </h3>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                        Informasi agenda, pengumuman, dan berita desa.
                    </p>
                </a>

                <!-- Card 2: Surat Mandiri -->
                <a href="{{ route('warga.letter.index') }}"
                    class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                            Surat Mandiri
                        </h3>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                        Unduh template surat resmi siap cetak desa.
                    </p>
                </a>

                <!-- Card 3: Pengaduan Warga -->
                <a href="{{ route('warga.complaint.index') }}"
                    class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.01 5.395m-1.01-5.395c.379 1.764.575 3.567.575 5.395 0 1.828-.196 3.631-.575 5.395m0 0a23.909 23.909 0 01-1.01 5.395m1.01-5.395A23.74 23.74 0 0118.795 21" />
                        </svg>
                        <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                            Pengaduan
                        </h3>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                        Saluran aspirasi dan keluhan fasilitas warga.
                    </p>
                </a>

                <!-- Card 4: Perpustakaan Digital -->
                <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" target="_blank"
                    rel="noopener noreferrer"
                    class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                            Remen Maos
                        </h3>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                        Koleksi buku digital perpustakaan online desa.
                    </p>
                </a>

                <!-- Card 5: PPK Ormawa -->
                <a href="{{ route('public.ppko') }}"
                    class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                            PPKO UMS
                        </h3>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                        Halaman PPK Ormawa Catur Cerdas UMS.
                    </p>
                </a>

            </div>
        </div>

    </div>

    <!-- ========================================================= -->
    <!-- SECTION 2: BERITA TERKINI (FEATURED & EDITORIAL MAGAZINE LAYOUT) -->
    <!-- ========================================================= -->
    <section id="berita-terkini"
        class="w-full bg-white py-10 sm:py-16 lg:py-20 border-b border-[#c5c6ce]/50 flex flex-col justify-center min-h-0 lg:min-h-[600px] fade-up-scroll">
        <div class="w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            <!-- Header Title -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-200 text-center sm:text-left">
                <h2
                    class="font-['Public_Sans',sans-serif] text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight">
                    Berita Terbaru
                </h2>

                <!-- Desktop Action Button (Right Aligned) -->
                <a href="{{ route('public.news.index') }}"
                    class="hidden sm:inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 shrink-0">
                    <span>Tampilkan Semua</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            {{-- 1. MOBILE ONLY AUTO-SLIDING CAROUSEL (lg:hidden) --}}
            @if(isset($latestNews) && $latestNews->count() > 0)
                @php
                    $firstNews = $latestNews->first();
                    $sideNews = $latestNews->slice(1, 3);
                    $firstImageExists = $firstNews && $firstNews->image_path && (file_exists(public_path('storage/' . $firstNews->image_path)) || file_exists(storage_path('app/public/' . $firstNews->image_path)));
                    $firstImageSrc = $firstImageExists ? asset('storage/' . $firstNews->image_path) : asset('images/sawah_irigasi.png');
                    $firstFormattedDate = $firstNews ? ($firstNews->published_at ? $firstNews->published_at->format('d M Y') : $firstNews->created_at->format('d M Y')) : '';
                    $firstAuthorName = $firstNews ? ($firstNews->author->name ?? 'Admin Desa') : 'Admin Desa';

                    $fallbackSideNews = [
                        [
                            'title' => 'Peningkatan Kualitas Jalan Poros Dusun I Selesai Dikerjakan',
                            'category' => 'Pembangunan',
                            'date' => '10 Okt 2023',
                            'author' => 'Admin Desa',
                            'image' => asset('images/hero_landscape.png'),
                            'url' => route('public.news.index'),
                            'excerpt' => 'Peningkatan kualitas jalan poros Dusun I telah rampung untuk mempermudah akses dan mobilitas warga desa.',
                        ],
                        [
                            'title' => 'Pelatihan Pengolahan Hasil Pertanian bagi Kelompok Tani & UMKM',
                            'category' => 'Pemberdayaan',
                            'date' => '08 Okt 2023',
                            'author' => 'Admin Desa',
                            'image' => asset('images/umbul_siraman.png'),
                            'url' => route('public.news.index'),
                            'excerpt' => 'Pelatihan pengolahan dan pemasaran hasil tani organik bagi petani lokal serta pelaku usaha desa.',
                        ],
                        [
                            'title' => 'Penyesuaian Jam Pelayanan Kantor Desa Catur Selama Bulan Ini',
                            'category' => 'Pengumuman',
                            'date' => '05 Okt 2023',
                            'author' => 'Sekretariat Desa',
                            'image' => asset('images/logo_catur.png'),
                            'url' => route('public.news.index'),
                            'excerpt' => 'Pemberitahuan perubahan jam layanan tatap muka administrasi kependudukan di Kantor Balai Desa Catur.',
                        ],
                    ];

                    $displaySideNews = [];
                    foreach ($sideNews as $sItem) {
                        $sImgExists = $sItem->image_path && (file_exists(public_path('storage/' . $sItem->image_path)) || file_exists(storage_path('app/public/' . $sItem->image_path)));
                        $displaySideNews[] = [
                            'title' => $sItem->title,
                            'category' => $sItem->category,
                            'date' => $sItem->published_at ? $sItem->published_at->format('d M Y') : $sItem->created_at->format('d M Y'),
                            'author' => $sItem->author->name ?? 'Admin Desa',
                            'image' => $sImgExists ? asset('storage/' . $sItem->image_path) : asset('images/hero_landscape.png'),
                            'url' => route('public.news.show', $sItem->slug),
                            'excerpt' => $sItem->excerpt ?? Str::limit(strip_tags($sItem->content), 130),
                        ];
                    }
                    $fbIndex = 0;
                    while (count($displaySideNews) < 3 && isset($fallbackSideNews[$fbIndex])) {
                        $displaySideNews[] = $fallbackSideNews[$fbIndex++];
                    }

                    $carouselItems = array_merge([
                        [
                            'title' => $firstNews->title,
                            'category' => $firstNews->category,
                            'date' => $firstFormattedDate,
                            'author' => $firstAuthorName,
                            'image' => $firstImageSrc,
                            'url' => route('public.news.show', $firstNews->slug),
                            'excerpt' => $firstNews->excerpt ?? Str::limit(strip_tags($firstNews->content), 130),
                        ]
                    ], $displaySideNews);
                @endphp

                <div class="block lg:hidden relative"
                    x-data="{ 
                                                                                                                                                                activeSlide: 0, 
                                                                                                                                                                totalSlides: {{ count($carouselItems) }},
                                                                                                                                                                timer: null,
                                                                                                                                                                touchStartX: 0,
                                                                                                                                                                touchStartY: 0,
                                                                                                                                                                init() {
                                                                                                                                                                    this.startAutoSlide();
                                                                                                                                                                },
                                                                                                                                                                startAutoSlide() {
                                                                                                                                                                    this.stopAutoSlide();
                                                                                                                                                                    this.timer = setInterval(() => {
                                                                                                                                                                        this.nextSlide();
                                                                                                                                                                    }, 4000);
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
                                                                                                                                                                    this.stopAutoSlide();
                                                                                                                                                                    this.touchStartX = e.touches[0].clientX;
                                                                                                                                                                    this.touchStartY = e.touches[0].clientY;
                                                                                                                                                                },
                                                                                                                                                                handleTouchEnd(e) {
                                                                                                                                                                    const diffX = e.changedTouches[0].clientX - this.touchStartX;
                                                                                                                                                                    const diffY = e.changedTouches[0].clientY - this.touchStartY;
                                                                                                                                                                    if (Math.abs(diffX) > 35 && Math.abs(diffX) > Math.abs(diffY)) {
                                                                                                                                                                        if (diffX < 0) {
                                                                                                                                                                            this.nextSlide();
                                                                                                                                                                        } else {
                                                                                                                                                                            this.prevSlide();
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                    this.startAutoSlide();
                                                                                                                                                                }
                                                                                                                                                            }"
                    @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()" @touchstart.passive="handleTouchStart($event)"
                    @touchend="handleTouchEnd($event)">

                    <div class="relative overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-out"
                            :style="`transform: translateX(-${activeSlide * 100}%);`">

                            @foreach($carouselItems as $cNews)
                                <div class="w-full shrink-0 px-0.5">
                                    <a href="{{ $cNews['url'] }}" class="group block space-y-2.5">
                                        <div class="relative w-full aspect-[16/9] sm:aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 shadow-2xs"
                                            x-data="{ loaded: false }"
                                            x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                            <div x-show="!loaded"
                                                class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                            <img x-ref="img" src="{{ $cNews['image'] }}" alt="{{ $cNews['title'] }}" loading="lazy"
                                                @load="loaded = true;"
                                                x-on:error="loaded = true; $el.src = '{{ asset('images/sawah_irigasi.png') }}';"
                                                class="w-full h-full object-cover transition-all duration-700"
                                                :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                        </div>
                                        <div class="space-y-1.5">
                                            <span
                                                class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">
                                                {{ $cNews['category'] }}
                                            </span>
                                            <h3
                                                class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug line-clamp-2">
                                                {{ $cNews['title'] }}
                                            </h3>
                                            <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                                <span>{{ $cNews['date'] }}</span>
                                                <span>•</span>
                                                <span>{{ $cNews['author'] }}</span>
                                            </div>
                                            <p class="text-xs text-[#44474e] leading-relaxed font-normal line-clamp-2">
                                                {{ $cNews['excerpt'] }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Navigation Controls: Left/Right Arrows + Center Dots -->
                    <div class="flex items-center justify-between pt-3 px-1">
                        <button @click="prevSlide(); startAutoSlide()"
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-[#0A3D29] hover:text-white text-slate-700 flex items-center justify-center transition-all shadow-xs active:scale-95 cursor-pointer"
                            aria-label="Berita Sebelumnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Dots Indicator -->
                        <div class="flex items-center justify-center gap-1.5">
                            <template x-for="i in totalSlides" :key="i">
                                <button @click="activeSlide = i - 1; startAutoSlide()"
                                    class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                                    :class="activeSlide === (i - 1) ? 'w-5 bg-[#0A3D29]' : 'w-1.5 bg-[#c5c6ce]'"></button>
                            </template>
                        </div>

                        <button @click="nextSlide(); startAutoSlide()"
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-[#0A3D29] hover:text-white text-slate-700 flex items-center justify-center transition-all shadow-xs active:scale-95 cursor-pointer"
                            aria-label="Berita Selanjutnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- 2. DESKTOP ONLY EDITORIAL GRID (hidden lg:grid) --}}
                <div class="hidden lg:grid grid-cols-12 gap-8 items-start">
                    <div class="col-span-7">
                        <a href="{{ route('public.news.show', $firstNews->slug) }}" class="group block space-y-2.5">
                            <div class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-100 shadow-2xs group-hover:shadow-md transition-all duration-500"
                                x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                <div x-show="!loaded" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none">
                                </div>
                                <img x-ref="img" src="{{ $firstImageSrc }}" alt="{{ $firstNews->title }}" loading="lazy"
                                    @load="loaded = true;"
                                    x-on:error="loaded = true; $el.src = '{{ asset('images/sawah_irigasi.png') }}';"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700"
                                    :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                            </div>

                            <div class="space-y-1.5">
                                <span
                                    class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">
                                    {{ $firstNews->category }}
                                </span>

                                <h3
                                    class="font-['Public_Sans',sans-serif] text-xl lg:text-2xl font-extrabold text-slate-800 group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    {{ $firstNews->title }}
                                </h3>

                                <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                    <span>{{ $firstFormattedDate }}</span>
                                    <span>•</span>
                                    <span>{{ $firstAuthorName }}</span>
                                </div>

                                <p class="text-xs sm:text-sm text-[#44474e] leading-relaxed font-normal line-clamp-2">
                                    {{ $firstNews->excerpt ?? Str::limit(strip_tags($firstNews->content), 140) }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="col-span-5 space-y-4">
                        @foreach($displaySideNews as $sNews)
                            <a href="{{ $sNews['url'] }}"
                                class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                                <div class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs group-hover:shadow-xs transition-all duration-300"
                                    x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                    <div x-show="!loaded" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none">
                                    </div>
                                    <img x-ref="img" src="{{ $sNews['image'] }}" alt="{{ $sNews['title'] }}" loading="lazy"
                                        @load="loaded = true;"
                                        x-on:error="loaded = true; $el.src = '{{ asset('images/hero_landscape.png') }}';"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700"
                                        :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                </div>

                                <div class="space-y-1 flex-1 min-w-0">
                                    <span
                                        class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">
                                        {{ $sNews['category'] }}
                                    </span>

                                    <h4
                                        class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                        {{ $sNews['title'] }}
                                    </h4>

                                    <p class="text-[11px] text-[#75777e] font-medium">
                                        {{ $sNews['date'] }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Desktop Fallback Mockup Layout (No DB News) -->
                <div class="block lg:hidden relative"
                    x-data="{ 
                                                                                                                                                                activeSlide: 0, 
                                                                                                                                                                totalSlides: 4,
                                                                                                                                                                timer: null,
                                                                                                                                                                init() { this.startAutoSlide(); },
                                                                                                                                                                startAutoSlide() { this.stopAutoSlide(); this.timer = setInterval(() => { this.nextSlide(); }, 3500); },
                                                                                                                                                                stopAutoSlide() { if (this.timer) clearInterval(this.timer); },
                                                                                                                                                                nextSlide() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides; },
                                                                                                                                                                prevSlide() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides; }
                                                                                                                                                            }"
                    @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()" @touchstart="stopAutoSlide()"
                    @touchend="startAutoSlide()">
                    <div class="relative overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-out"
                            :style="`transform: translateX(-${activeSlide * 100}%);`">
                            <div class="w-full shrink-0 px-0.5">
                                <a href="{{ route('public.news.index') }}" class="group block space-y-2.5">
                                    <div
                                        class="relative w-full aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 shadow-2xs">
                                        <img src="{{ asset('images/sawah_irigasi.png') }}" alt="Panen Padi"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="space-y-1.5">
                                        <span
                                            class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Kegiatan</span>
                                        <h3
                                            class="font-['Public_Sans',sans-serif] text-lg font-extrabold text-[#191c1e] leading-snug">
                                            Panen Padi Organik Melimpah 3 Kali Setahun Didukung Irigasi Desa Catur
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
                        </div>
                    </div>
                </div>

                <div class="hidden lg:grid grid-cols-12 gap-8 items-start">
                    <div class="col-span-7">
                        <a href="{{ route('public.news.index') }}" class="group block space-y-2.5">
                            <div
                                class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-100 shadow-2xs group-hover:shadow-md transition-all duration-500">
                                <img src="{{ asset('images/sawah_irigasi.png') }}" alt="Kerja Bakti"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            </div>
                            <div class="space-y-1.5">
                                <span
                                    class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Kegiatan
                                    Desa</span>
                                <h3
                                    class="font-['Public_Sans',sans-serif] text-xl lg:text-2xl font-extrabold text-slate-800 group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    Kerja Bakti Rutin Bersihkan Saluran Irigasi Jelang Musim Tanam Padi
                                </h3>
                                <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                    <span>12 Okt 2023</span> • <span>Admin Desa</span>
                                </div>
                                <p class="text-xs sm:text-sm text-[#44474e] leading-relaxed font-normal line-clamp-2">
                                    Warga Desa Catur bergotong royong membersihkan saluran irigasi utama untuk menyambut musim
                                    tanam padi...
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="col-span-5 space-y-4">
                        <a href="{{ route('public.news.index') }}"
                            class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                            <div
                                class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs">
                                <img src="{{ asset('images/hero_landscape.png') }}" alt="Pembangunan"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="space-y-1 flex-1 min-w-0">
                                <span
                                    class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Pembangunan</span>
                                <h4
                                    class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    Peningkatan Kualitas Jalan Poros Dusun I Selesai Dikerjakan
                                </h4>
                                <p class="text-[11px] text-[#75777e] font-medium">10 Okt 2023 • Admin Desa</p>
                            </div>
                        </a>

                        <a href="{{ route('public.news.index') }}"
                            class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                            <div
                                class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs">
                                <img src="{{ asset('images/umbul_siraman.png') }}" alt="Pemberdayaan"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="space-y-1 flex-1 min-w-0">
                                <span
                                    class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Pemberdayaan</span>
                                <h4
                                    class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    Pelatihan Pengolahan Hasil Pertanian bagi Kelompok Tani & UMKM
                                </h4>
                                <p class="text-[11px] text-[#75777e] font-medium">08 Okt 2023 • Admin Desa</p>
                            </div>
                        </a>

                        <a href="{{ route('public.news.index') }}"
                            class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-white border border-transparent hover:border-[#c5c6ce]/60 hover:shadow-2xs transition-all duration-300">
                            <div
                                class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs">
                                <img src="{{ asset('images/logo_catur.png') }}" alt="Pengumuman"
                                    class="w-full h-full object-contain p-2.5 bg-[#f2f4f6]">
                            </div>
                            <div class="space-y-1 flex-1 min-w-0">
                                <span
                                    class="text-xs font-bold text-[#0A3D29] uppercase tracking-wide block font-['Inter',sans-serif]">Pengumuman</span>
                                <h4
                                    class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
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
                    <span>Tampilkan Semua</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
        class="w-full bg-[#0A3D29] text-white py-16 sm:py-20 lg:py-24 border-b border-[#072B1D] overflow-hidden flex items-center min-h-[580px] lg:min-h-[640px] fade-up-scroll">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-center">

                {{-- Left Column: Text & Bullet Points & Action Button (order-2 on mobile, order-1 on desktop) --}}
                <div class="order-2 lg:order-1 lg:col-span-5 space-y-6 sm:space-y-7 text-left">

                    {{-- Headline & Description --}}
                    <div class="space-y-3.5">
                        <h2 class="space-y-1 sm:space-y-2">
                            <span
                                class="block font-['Public_Sans',sans-serif] text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                                Remen Maos
                            </span>
                            <span
                                class="block font-['Public_Sans',sans-serif] text-xl sm:text-2xl lg:text-3xl font-extrabold text-emerald-300 leading-tight tracking-tight">
                                Perpustakaan Digital Desa Catur
                            </span>
                        </h2>

                        <p class="text-sm sm:text-base text-white/85 font-normal leading-relaxed max-w-xl">
                            Akses perpustakaan digital hanya dari genggaman anda, Jelajahi koleksi buku menarik dimanapun
                            dan kapanpun.
                        </p>
                    </div>

                    {{-- 3 Bullet Points with Glowing Emerald Badges --}}
                    <div class="space-y-3.5 pt-1 flex flex-col items-start text-left max-w-lg w-full">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-5 h-5 rounded-full bg-white/15 border border-white/25 text-emerald-300 flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-white/90 leading-snug">Beragam Judul Buku
                                Digital menarik untuk dibaca</span>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-5 h-5 rounded-full bg-white/15 border border-white/25 text-emerald-300 flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-white/90 leading-snug">Akses Gratis 24 Jam
                                Tanpa Batas dari semua perangkat anda</span>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-5 h-5 rounded-full bg-white/15 border border-white/25 text-emerald-300 flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-white/90 leading-snug">Dikelola oleh
                                Perpustakaan Daerah Boyolali</span>
                        </div>
                    </div>

                    {{-- Action Button: Kunjungi Remen Maos Catur --}}
                    <div class="pt-2 flex justify-start">
                        <a href="{{ $libraryUrl ?? 'https://perpustakaan.boyolali.go.id' }}" target="_blank"
                            rel="noopener noreferrer"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 bg-white hover:bg-emerald-50 text-[#0A3D29] font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 group shrink-0">
                            <span>Kunjungi Remen Maos Catur</span>
                            <svg class="w-4 h-4 text-[#0A3D29] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>

                </div>

                {{-- Right Column: Transparent Seamless 3D Multi-Device Showcase Image (order-1 on mobile, order-2 on
                desktop) --}}
                <div class="order-1 lg:order-2 lg:col-span-7 flex items-center justify-center">
                    <div class="w-full max-w-[720px] mx-auto relative py-4 sm:py-6" x-data="{ loaded: false }"
                        x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">

                        {{-- Ambient Soft Glow / Spotlight behind mockup to soften cutout edges --}}
                        <div class="absolute inset-0 m-auto w-[90%] h-[85%] rounded-full pointer-events-none -z-0 opacity-80"
                            style="background: radial-gradient(ellipse at center, rgba(52, 211, 153, 0.28) 0%, rgba(16, 185, 129, 0.12) 45%, transparent 72%); filter: blur(40px); transform: translate3d(0, 0, 0);">
                        </div>

                        <div x-show="!loaded"
                            class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none rounded-2xl"></div>
                        <img x-ref="img"
                            src="{{ asset('images/remen_maos_mockup.png') }}?v={{ file_exists(public_path('images/remen_maos_mockup.png')) ? filemtime(public_path('images/remen_maos_mockup.png')) : time() }}"
                            alt="Perpustakaan Digital Remen Maos Desa Catur Multi-Device Mockup" width="1181" height="619"
                            loading="eager" decoding="async" @load="loaded = true;" x-on:error="loaded = true;"
                            class="w-full h-auto object-contain hover:scale-[1.015] transition-all duration-700 pointer-events-auto relative z-10"
                            style="filter: drop-shadow(0 25px 35px rgba(0, 0, 0, 0.50)) drop-shadow(0 0 20px rgba(52, 211, 153, 0.25)) drop-shadow(0 4px 12px rgba(0, 0, 0, 0.35));"
                            :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                    </div>
                </div>

            </div>
        </div>
    </section>




    <!-- MAIN CONTAINER FOR LOWER SECTIONS (Aparatur Desa, Peta) -->
    <div class="w-full bg-[#F8FAF7] border-b border-[#DCE6DA]">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-16 fade-up-scroll">

            <!-- ========================================================= -->
            <!-- SECTION 4: APARATUR DESA (PERANGKAT DESA CATUR)             -->
            <!-- ========================================================= -->
            @php
                $officialList = [];
                if(isset($officials) && $officials->count() > 0) {
                    foreach($officials as $off) {
                        $officialList[] = [
                            'name' => $off->name,
                            'position' => $off->position,
                            'photo' => $off->photo_path ? asset('storage/' . $off->photo_path) : null,
                        ];
                    }
                } else {
                    $officialList = [
                        ['name' => 'Dra. NUNIK S RAHAYU, M.Pd', 'position' => 'Kepala Desa Catur', 'photo' => null],
                        ['name' => 'Bambang Sugeng, S.Sos.', 'position' => 'Sekretaris Desa', 'photo' => null],
                        ['name' => 'Siti Rahmawati, A.Md.', 'position' => 'Kaur Keuangan', 'photo' => null],
                        ['name' => 'Tri Santoso, S.T.', 'position' => 'Kaur Perencanaan & Umum', 'photo' => null],
                        ['name' => 'Joko Widodo, S.P.', 'position' => 'Kasi Pelayanan', 'photo' => null],
                    ];
                }
                $totalUnique = count($officialList);
                // Repeat 5 sets for infinite seamless sliding
                $allCards = [];
                for ($r = 0; $r < 5; $r++) {
                    foreach ($officialList as $item) {
                        $allCards[] = $item;
                    }
                }
                $initialIndex = $totalUnique * 2; // Start in middle set (Set 2)
            @endphp

            <section class="py-4 space-y-6 lg:space-y-8" 
                     x-data="{
                         totalUnique: {{ $totalUnique }},
                         totalCards: {{ count($allCards) }},
                         currentIndex: {{ $initialIndex }},
                         cardWidth: 240,
                         gap: 20,
                         containerWidth: 1000,
                         isDesktop: window.innerWidth >= 640,
                         isDragging: false,
                         dragStartX: 0,
                         dragOffset: 0,
                         withTransition: true,

                         init() {
                             this.updateDimensions();
                             window.addEventListener('resize', () => {
                                 this.updateDimensions();
                             });
                         },

                         updateDimensions() {
                             if (this.$refs.container) {
                                 this.containerWidth = this.$refs.container.clientWidth;
                             }
                             this.isDesktop = window.innerWidth >= 640;
                             this.cardWidth = this.isDesktop ? 240 : 210;
                             this.gap = this.isDesktop ? 20 : 12;
                         },

                         getStep() {
                             return this.cardWidth + this.gap;
                         },

                         getTransform() {
                             const step = this.getStep();
                             const centerPos = (this.containerWidth / 2) - (this.currentIndex * step + this.cardWidth / 2);
                             return centerPos + this.dragOffset;
                         },

                         next() {
                             this.goTo(this.currentIndex + 1);
                         },

                         prev() {
                             this.goTo(this.currentIndex - 1);
                         },

                         goTo(index) {
                             this.withTransition = true;
                             this.currentIndex = index;
                             this.checkWrap();
                         },

                         checkWrap() {
                             setTimeout(() => {
                                 const minBoundary = this.totalUnique;
                                 const maxBoundary = this.totalUnique * 3;
                                 if (this.currentIndex < minBoundary || this.currentIndex >= maxBoundary) {
                                     this.withTransition = false;
                                     const offsetInSet = ((this.currentIndex % this.totalUnique) + this.totalUnique) % this.totalUnique;
                                     this.currentIndex = this.totalUnique * 2 + offsetInSet;
                                 }
                             }, 360);
                         },

                         handleTouchStart(e) {
                             this.isDragging = true;
                             this.dragStartX = e.touches[0].clientX;
                             this.dragOffset = 0;
                         },

                         handleTouchMove(e) {
                             if (!this.isDragging) return;
                             this.dragOffset = e.touches[0].clientX - this.dragStartX;
                         },

                         handleTouchEnd() {
                             if (!this.isDragging) return;
                             this.isDragging = false;
                             if (this.dragOffset < -35) {
                                 this.next();
                             } else if (this.dragOffset > 35) {
                                 this.prev();
                             }
                             this.dragOffset = 0;
                         },

                         handleMouseDown(e) {
                             this.isDragging = true;
                             this.dragStartX = e.clientX;
                             this.dragOffset = 0;
                         },

                         handleMouseMove(e) {
                             if (!this.isDragging) return;
                             this.dragOffset = e.clientX - this.dragStartX;
                         },

                         handleMouseUp() {
                             if (!this.isDragging) return;
                             this.isDragging = false;
                             if (this.dragOffset < -35) {
                                 this.next();
                             } else if (this.dragOffset > 35) {
                                 this.prev();
                             }
                             this.dragOffset = 0;
                         }
                     }">

                <!-- Header Title -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-200 text-center sm:text-left">
                    <div>
                        <h2 class="font-['Public_Sans',sans-serif] text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight">
                            Perangkat Desa Catur
                        </h2>
                    </div>

                    <!-- Desktop Action Button (Right Aligned) -->
                    <a href="{{ route('public.officials') }}"
                        class="hidden sm:inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 shrink-0">
                        <span>Lihat Semua Aparatur</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Carousel Stage Container with Floating Glassmorphism Navigation Buttons -->
                <div class="relative group/stage">

                    <!-- Floating Glassmorphism Button: Kiri -->
                    <button type="button" @click="prev()"
                        class="absolute left-1 sm:left-3 md:left-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/70 hover:bg-white/95 active:scale-90 backdrop-blur-md border border-white/80 text-[#0A3D29] flex items-center justify-center transition-all duration-200 shadow-[0_8px_22px_rgba(0,0,0,0.12)] hover:shadow-[0_12px_28px_rgba(0,0,0,0.18)] cursor-pointer group"
                        aria-label="Aparatur Sebelumnya">
                        <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Floating Glassmorphism Button: Kanan -->
                    <button type="button" @click="next()"
                        class="absolute right-1 sm:right-3 md:right-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/70 hover:bg-white/95 active:scale-90 backdrop-blur-md border border-white/80 text-[#0A3D29] flex items-center justify-center transition-all duration-200 shadow-[0_8px_22px_rgba(0,0,0,0.12)] hover:shadow-[0_12px_28px_rgba(0,0,0,0.18)] cursor-pointer group"
                        aria-label="Aparatur Selanjutnya">
                        <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Carousel Stage (Overflow Hidden, Centered Track) -->
                    <div x-ref="container" 
                         class="relative overflow-hidden py-4 select-none touch-pan-y"
                         @touchstart="handleTouchStart($event)"
                         @touchmove="handleTouchMove($event)"
                         @touchend="handleTouchEnd()"
                         @mousedown="handleMouseDown($event)"
                         @mousemove="handleMouseMove($event)"
                         @mouseup="handleMouseUp()"
                         @mouseleave="handleMouseUp()">

                        <!-- Sliding Track -->
                        <div class="flex items-center"
                             :style="`transform: translateX(${getTransform()}px); transition: ${withTransition ? 'transform 360ms cubic-bezier(0.25, 1, 0.5, 1)' : 'none'};`">
                            @foreach($allCards as $index => $card)
                                <div @click="goTo({{ $index }})"
                                     class="shrink-0 group flex flex-col justify-between p-3.5 sm:p-4 rounded-2xl bg-white border transition-all duration-300 ease-out cursor-pointer overflow-hidden transform"
                                     :style="`width: ${cardWidth}px; margin-right: ${gap}px;`"
                                     :class="{
                                         'filter-none opacity-100 scale-100 z-20 shadow-xl border-[#0A3D29]/40 ring-2 ring-[#0A3D29]/15': 
                                             (isDesktop && Math.abs({{ $index }} - currentIndex) <= 1) || (!isDesktop && {{ $index }} === currentIndex),
                                         'filter blur-[2px] opacity-50 scale-95 z-10 cursor-pointer hover:opacity-80': 
                                             (isDesktop && Math.abs({{ $index }} - currentIndex) === 2) || (!isDesktop && Math.abs({{ $index }} - currentIndex) === 1),
                                         'filter blur-[4px] opacity-10 scale-90 pointer-events-none z-0': 
                                             (isDesktop && Math.abs({{ $index }} - currentIndex) > 2) || (!isDesktop && Math.abs({{ $index }} - currentIndex) > 1)
                                     }">
                                    <div>
                                        <!-- Photo Container (Original Compact Card Style) -->
                                        <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3 sm:mb-3.5 flex items-center justify-center shadow-2xs"
                                            x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                            @if($card['photo'])
                                                <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                                <img x-ref="img" src="{{ $card['photo'] }}"
                                                    alt="{{ $card['name'] }}" loading="lazy" @load="loaded = true;"
                                                    class="relative z-10 w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                                                    :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                            @else
                                                <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] group-hover:bg-emerald-50 transition-colors">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Position Text (Original Minimalist Typography) -->
                                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                                            {{ $card['position'] }}
                                        </p>

                                        <!-- Official Name (Original Bold Typography) -->
                                        <h3 class="font-['Public_Sans',sans-serif] text-sm sm:text-base font-extrabold text-slate-800 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                            {{ $card['name'] }}
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Carousel Navigation Dots / Indicator -->
                <div class="flex justify-center items-center gap-1.5 pt-2">
                    <template x-for="i in totalUnique" :key="i">
                        <button @click="goTo(totalUnique * 2 + (i - 1))"
                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                            :class="(((currentIndex % totalUnique) + totalUnique) % totalUnique) === (i - 1) 
                                ? 'w-6 bg-[#0A3D29]' 
                                : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                            :aria-label="'Perangkat ' + i">
                        </button>
                    </template>
                </div>

                <!-- Mobile Bottom Action Button: Lihat Semua Aparatur (block sm:hidden) -->
                <div class="block sm:hidden text-center pt-2">
                    <a href="{{ route('public.officials') }}"
                        class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 min-h-[44px]">
                        <span>Lihat Semua Perangkat</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </section>
        </div>
    </div> <!-- End of Main Container with warm neutral background -->


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