@extends('layouts.public')

@section('title', 'Berita & Pengumuman - Web Profile Desa Catur')

@section('content')

<!-- Unified Main Page Container (Clean White Canvas) -->
<div class="bg-white min-h-screen py-8 sm:py-10" x-data="{ filterOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Title & Action Buttons (Terbaru & Filter) -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 sm:gap-6 pb-6 border-b border-slate-200/80 text-left">
            
            <!-- Clean Title with Route Breadcrumbs -->
            <div>
                <x-breadcrumbs :items="[
                    ['label' => 'BERANDA', 'url' => route('home')],
                    ['label' => 'Berita']
                ]" />
                <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#20332A] leading-tight tracking-tight">
                    Berita & Pengumuman
                </h1>
            </div>

            <!-- Desktop Only Action Buttons: Terbaru & Filter (hidden sm:flex) -->
            <div class="hidden sm:flex items-center gap-2.5 relative">
                
                <!-- Tombol Terbaru -->
                <a href="{{ route('public.news.index', ['sort' => 'latest']) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all backdrop-blur-xl backdrop-saturate-150 {{ !request('category') && (!request('sort') || request('sort') === 'latest') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white/80 text-[#20332A] hover:bg-white border border-slate-200/80 shadow-2xs' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Terbaru</span>
                </a>

                <!-- Tombol Filter Dropdown -->
                <div class="relative">
                    <button type="button" 
                            @click="filterOpen = !filterOpen" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all backdrop-blur-xl backdrop-saturate-150 cursor-pointer {{ request('category') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white/80 text-[#20332A] hover:bg-white border border-slate-200/80 shadow-2xs' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter{{ request('category') ? ': ' . request('category') : '' }}</span>
                        <svg class="w-3 h-3 transition-transform duration-200" :class="filterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Filter Category Dropdown Menu -->
                    <div x-show="filterOpen" 
                         @click.away="filterOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="absolute right-0 mt-2 w-52 bg-white/90 backdrop-blur-2xl rounded-xl border border-white/90 shadow-2xl z-50 p-2 space-y-1">
                        
                        <a href="{{ route('public.news.index') }}" 
                           class="block px-3.5 py-2 rounded-xl text-xs font-bold transition {{ !request('category') ? 'bg-[#0A3D29]/15 text-[#0A3D29]' : 'text-slate-700 hover:bg-slate-100/60' }}">
                            Semua Kategori
                        </a>

                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $cat)
                                <a href="{{ route('public.news.index', ['category' => $cat]) }}" 
                                   class="block px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ request('category') === $cat ? 'bg-[#0A3D29]/15 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-slate-100/60' }}">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        @else
                            <a href="{{ route('public.news.index', ['category' => 'Berita']) }}" 
                               class="block px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100/60">
                                Berita
                            </a>
                            <a href="{{ route('public.news.index', ['category' => 'Pengumuman']) }}" 
                               class="block px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100/60">
                                Pengumuman
                            </a>
                            <a href="{{ route('public.news.index', ['category' => 'Kegiatan']) }}" 
                               class="block px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100/60">
                                Kegiatan
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile Floating Bottom Capsule Bar -->
        <div class="sm:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999] pointer-events-auto"
             x-data="{ 
                 mobileTab: '{{ request('category') ? 'filter' : (request('sort') === 'latest' || !request('sort') ? 'latest' : 'filter') }}',
                 mobileFilterOpen: false 
             }"
             @click.away="mobileFilterOpen = false">
            
            <!-- Capsule Outer Container (Matching Glassmorphism) -->
            <div class="relative flex items-center h-11 bg-white/75 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl p-1 rounded-xl w-[205px] transition-all duration-300">
                
                <!-- Flowing Indicator Pill -->
                <div class="absolute top-1 bottom-1 rounded-lg bg-[#0A3D29]/10 transition-all duration-200 ease-out pointer-events-none"
                     :style="mobileTab === 'latest' ? 'left: 4px; width: calc(50% - 4px);' : 'left: 50%; width: calc(50% - 4px);'">
                </div>

                <!-- Button 1: Terbaru -->
                <a href="{{ route('public.news.index', ['sort' => 'latest']) }}" 
                   @click="mobileTab = 'latest'; mobileFilterOpen = false"
                   class="relative z-10 flex-1 h-full flex items-center justify-center rounded-lg text-xs transition-colors duration-200 select-none"
                   :class="mobileTab === 'latest' ? 'text-[#0A3D29] font-bold' : 'text-slate-600 font-medium hover:text-slate-900'">
                    <span>Terbaru</span>
                </a>

                <!-- Button 2: Filter -->
                <button type="button" 
                        @click="mobileTab = 'filter'; mobileFilterOpen = !mobileFilterOpen"
                        class="relative z-10 flex-1 h-full flex items-center justify-center gap-1 rounded-lg text-xs transition-colors duration-200 select-none cursor-pointer"
                        :class="mobileTab === 'filter' ? 'text-[#0A3D29] font-bold' : 'text-slate-600 font-medium hover:text-slate-900'">
                    <span>Filter</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="mobileFilterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Category Dropdown Popup (Muncul di Atas / Drop-Up) -->
            <div x-show="mobileFilterOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-3"
                 class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2 w-52 bg-white/80 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 rounded-xl border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl p-1.5 space-y-0.5 z-[999999]">
                
                <a href="{{ route('public.news.index') }}" 
                   class="block px-3 py-2 rounded-xl text-xs transition {{ !request('category') ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-white/60 font-medium' }}">
                    Semua Kategori
                </a>

                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $cat)
                        <a href="{{ route('public.news.index', ['category' => $cat]) }}" 
                           class="block px-3 py-2 rounded-xl text-xs transition {{ request('category') === $cat ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-white/60 font-medium' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                @else
                    <a href="{{ route('public.news.index', ['category' => 'Berita']) }}" 
                       class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-white/60">
                        Berita
                    </a>
                    <a href="{{ route('public.news.index', ['category' => 'Pengumuman']) }}" 
                       class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-white/60">
                        Pengumuman
                    </a>
                    <a href="{{ route('public.news.index', ['category' => 'Kegiatan']) }}" 
                       class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-white/60">
                        Kegiatan
                    </a>
                @endif
            </div>
        </div>


        @if($newsList->count() > 0)
            @php
                $defaultImages = [
                    'images/sawah_irigasi.png',
                    'images/umbul_siraman.png',
                    'images/coffee_plantation.png',
                    'images/masjid_wonokusumo.png',
                    'images/hero_landscape.png',
                    'images/culture_pura.png',
                ];
                $groupedByCategory = $newsList->getCollection()->groupBy('category');
            @endphp

            <div x-data="{ isReady: false }" x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 100); })" class="space-y-12 sm:space-y-16">
                <!-- 1. Skeleton Screen Loading State -->
                <div x-show="!isReady" aria-busy="true" class="space-y-10">
                    <div class="space-y-6">
                        <!-- Skeleton Header -->
                        <div class="flex items-center justify-between">
                            <div class="w-44 h-7 rounded skeleton-shimmer"></div>
                            <div class="w-28 h-4 rounded skeleton-shimmer"></div>
                        </div>
                        <!-- Large Featured Skeleton (Split) -->
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 bg-slate-50/50 rounded-xl p-4 sm:p-5 border border-slate-200/80 items-center">
                            <div class="lg:col-span-7 aspect-[16/10] sm:aspect-[16/9] rounded-xl skeleton-shimmer"></div>
                            <div class="lg:col-span-5 space-y-3">
                                <div class="w-full h-7 rounded skeleton-shimmer"></div>
                                <div class="w-4/5 h-7 rounded skeleton-shimmer"></div>
                                <div class="w-32 h-3.5 rounded skeleton-shimmer mt-2"></div>
                            </div>
                        </div>
                        <!-- Sub Grid Skeletons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                            @for($i = 0; $i < min(3, max(1, $newsList->count() - 1)); $i++)
                                <x-skeleton.news-card />
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- 2. Real Content Magazine Layout (Grouped by Category) -->
                <div x-show="isReady"
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="space-y-12 sm:space-y-16">
                    @foreach($groupedByCategory as $categoryName => $articles)
                        @php
                            $featuredNews = $articles->first();
                            $subArticles = $articles->slice(1);
                        @endphp

                        <section class="space-y-6">
                            <!-- Category Section Header -->
                            <div class="flex items-center justify-between">
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#20332A] tracking-tight">
                                    <span class="relative inline-block">
                                        <span class="relative z-10">{{ $categoryName ?: 'Berita Terkini' }}</span>
                                        <span class="absolute -inset-x-1.5 bottom-0.5 sm:bottom-1 h-3 sm:h-3.5 bg-gradient-to-r from-emerald-200/90 via-[#6EE7B7]/75 to-emerald-200/60 -rotate-0.5 rounded-xs -z-0 pointer-events-none"></span>
                                    </span>
                                </h2>
                                @if(!request('category') && $categoryName)
                                    <a href="{{ route('public.news.index', ['category' => $categoryName]) }}" 
                                       class="italic text-xs sm:text-sm font-medium text-[#0A3D29] hover:text-[#062c1d] flex items-center gap-1.5 transition-colors group shrink-0">
                                        <span>Lihat Selengkapnya</span>
                                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            @if($featuredNews)
                                @php
                                    $fImageExists = $featuredNews->image_path && (file_exists(public_path('storage/' . $featuredNews->image_path)) || file_exists(storage_path('app/public/' . $featuredNews->image_path)));
                                    $fFallbackImg = asset($defaultImages[0]);
                                    $fImageSrc = $fImageExists ? asset('storage/' . $featuredNews->image_path) : $fFallbackImg;
                                    $fFormattedDate = $featuredNews->published_at ? $featuredNews->published_at->format('d M Y') : $featuredNews->created_at->format('d M Y');
                                @endphp

                                <!-- Large Featured Post (Split Magazine Hero Layout) -->
                                <article class="group bg-slate-50/70 hover:bg-slate-50 rounded-xl p-4 sm:p-5 lg:p-6 border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-300">
                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
                                        <!-- Featured Image -->
                                        <div class="lg:col-span-7">
                                            <a href="{{ route('public.news.show', $featuredNews->slug) }}" 
                                               class="block relative w-full aspect-[16/10] sm:aspect-[16/9] rounded-xl overflow-hidden bg-slate-200/80 shadow-xs focus:outline-none"
                                               x-data="{ loaded: false }"
                                               x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                                <div x-show="!loaded" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                                <img x-ref="img"
                                                     src="{{ $fImageSrc }}" 
                                                     alt="{{ $featuredNews->title }}" 
                                                     loading="lazy"
                                                     @load="loaded = true;"
                                                     x-on:error="loaded = true; $el.src = '{{ $fFallbackImg }}';"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500"
                                                     :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                            </a>
                                        </div>

                                        <!-- Featured Headline (Title & Date Only) -->
                                        <div class="lg:col-span-5 flex flex-col justify-center space-y-3 text-left">
                                            <h3 class="font-['Public_Sans',sans-serif] text-xl sm:text-2xl lg:text-3xl font-extrabold text-[#191c1e] group-hover:text-[#0A3D29] leading-tight transition-colors">
                                                <a href="{{ route('public.news.show', $featuredNews->slug) }}" class="focus:outline-none">
                                                    {{ $featuredNews->title }}
                                                </a>
                                            </h3>

                                            <!-- Date Only -->
                                            <div class="flex items-center gap-1.5 text-xs sm:text-sm text-slate-500 font-medium">
                                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $fFormattedDate }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endif

                            <!-- Smaller Post Cards Arranged in a Grid Beneath (Title & Date Only) -->
                            @if($subArticles->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
                                    @foreach($subArticles as $sIndex => $subNews)
                                        @php
                                            $sImageExists = $subNews->image_path && (file_exists(public_path('storage/' . $subNews->image_path)) || file_exists(storage_path('app/public/' . $subNews->image_path)));
                                            $sFallbackImg = asset($defaultImages[($sIndex + 1) % count($defaultImages)]);
                                            $sImageSrc = $sImageExists ? asset('storage/' . $subNews->image_path) : $sFallbackImg;
                                            $sFormattedDate = $subNews->published_at ? $subNews->published_at->format('d M Y') : $subNews->created_at->format('d M Y');
                                        @endphp

                                        <article class="group block space-y-2.5 text-left">
                                            <!-- Sub Post Image -->
                                            <a href="{{ route('public.news.show', $subNews->slug) }}" 
                                               class="block relative w-full aspect-[16/10] rounded-xl overflow-hidden bg-slate-200/80 shadow-2xs group-hover:shadow-md transition-all focus:outline-none"
                                               x-data="{ loaded: false }"
                                               x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                                <div x-show="!loaded" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                                <img x-ref="img"
                                                     src="{{ $sImageSrc }}" 
                                                     alt="{{ $subNews->title }}" 
                                                     loading="lazy"
                                                     @load="loaded = true;"
                                                     x-on:error="loaded = true; $el.src = '{{ $sFallbackImg }}';"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500"
                                                     :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                            </a>

                                            <!-- Title & Date Only -->
                                            <div class="space-y-1.5 pt-0.5">
                                                <h4 class="font-['Public_Sans',sans-serif] text-sm sm:text-base font-bold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors">
                                                    <a href="{{ route('public.news.show', $subNews->slug) }}" class="focus:outline-none">
                                                        {{ $subNews->title }}
                                                    </a>
                                                </h4>

                                                <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span>{{ $sFormattedDate }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        </section>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if($newsList->hasPages())
                <div class="pt-8">
                    {{ $newsList->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 bg-white rounded-xl border border-slate-200">
                <span class="text-4xl block mb-3">📰</span>
                <h3 class="font-serif text-lg font-bold text-slate-700">Belum ada berita ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        @endif

    </div>
</div>

@endsection
