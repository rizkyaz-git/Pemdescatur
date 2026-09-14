<!-- ========================================================= -->
<!-- SECTION 2: BERITA TERKINI (FEATURED & EDITORIAL MAGAZINE LAYOUT) -->
<!-- ========================================================= -->
<section id="berita-terkini"
    class="w-full bg-white py-10 sm:py-16 lg:py-20 border-b border-[#c5c6ce]/50 flex flex-col justify-center min-h-0 lg:min-h-[600px] scroll-reveal">
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
                                    <div class="space-y-1.5 pt-0.5">
                                        <h3
                                            class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug">
                                            {{ $cNews['title'] }}
                                        </h3>
                                        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $cNews['date'] }}</span>
                                        </div>
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
                        <div class="space-y-2 pt-0.5">
                            <h3
                                class="font-['Public_Sans',sans-serif] text-xl lg:text-2xl font-extrabold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                {{ $firstNews->title }}
                            </h3>
                            <div class="flex items-center gap-4 text-xs text-slate-500 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $firstFormattedDate }}</span>
                                </div>
                                <span>•</span>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ $firstAuthorName }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-span-5 space-y-4">
                    @foreach($displaySideNews as $sNews)
                        <a href="{{ $sNews['url'] }}"
                            class="group flex items-start gap-4 p-2 -mx-2 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200/80 transition-all duration-300">
                            <div class="relative w-28 md:w-32 aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 shadow-2xs"
                                x-data="{ loaded: false }" x-init="if ($refs.sImg && $refs.sImg.complete) { loaded = true; }">
                                <div x-show="!loaded" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                <img x-ref="sImg" src="{{ $sNews['image'] }}" alt="{{ $sNews['title'] }}" loading="lazy"
                                    @load="loaded = true;"
                                    x-on:error="loaded = true; $el.src = '{{ asset('images/hero_landscape.png') }}';"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                            </div>
                            <div class="space-y-1 flex-1 min-w-0">
                                <h4
                                    class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                    {{ $sNews['title'] }}
                                </h4>
                                <p class="text-[11px] text-slate-400 font-medium">{{ $sNews['date'] }}</p>
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
                                <div class="space-y-1.5 pt-0.5">
                                    <h3
                                        class="font-['Public_Sans',sans-serif] text-lg font-extrabold text-[#191c1e] leading-snug">
                                        Panen Padi Organik Melimpah 3 Kali Setahun Didukung Irigasi Desa Catur
                                    </h3>
                                    <div class="flex items-center gap-1 text-xs text-slate-400 font-medium">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>02 Sep 2026</span>
                                    </div>
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
                        <div class="space-y-2 pt-0.5">
                            <h3
                                class="font-['Public_Sans',sans-serif] text-xl lg:text-2xl font-extrabold text-slate-800 group-hover:text-[#0A3D29] leading-snug transition-colors">
                                Kerja Bakti Rutin Bersihkan Saluran Irigasi Jelang Musim Tanam Padi
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm text-slate-500 font-medium">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>12 Okt 2023</span>
                            </div>
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
                            <h4
                                class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors">
                                Peningkatan Kualitas Jalan Poros Dusun I Selesai Dikerjakan
                            </h4>
                            <p class="text-[11px] text-slate-400 font-medium">10 Okt 2023</p>
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
                            <h4
                                class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors">
                                Pelatihan Pengolahan Hasil Pertanian bagi Kelompok Tani & UMKM
                            </h4>
                            <p class="text-[11px] text-slate-400 font-medium">08 Okt 2023</p>
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
                            <h4
                                class="font-['Public_Sans',sans-serif] text-sm lg:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors">
                                Penyesuaian Jam Pelayanan Kantor Desa Catur Selama Bulan Ini
                            </h4>
                            <p class="text-[11px] text-slate-400 font-medium">05 Okt 2023</p>
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
