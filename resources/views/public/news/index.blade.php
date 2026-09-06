@extends('layouts.public')

@section('title', 'Berita & Pengumuman - Web Profile Desa Catur')

@section('content')

<!-- Unified Main Page Container (Matching Body Background bg-[#F7F8F2]) -->
<div class="bg-[#F7F8F2] min-h-screen py-8 sm:py-10" x-data="{ filterOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Title & Action Buttons (Terbaru & Filter) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6 pb-6 border-b border-slate-200/80">
            
            <!-- Clean Title Only -->
            <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#20332A] leading-tight tracking-tight">
                Berita & Pengumuman
            </h1>

            <!-- Desktop Only Action Buttons: Terbaru & Filter (hidden sm:flex) -->
            <div class="hidden sm:flex items-center gap-2.5 relative">
                
                <!-- Tombol Terbaru -->
                <a href="{{ route('public.news.index', ['sort' => 'latest']) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold transition-all backdrop-blur-xl backdrop-saturate-150 {{ !request('category') && (!request('sort') || request('sort') === 'latest') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white/80 text-[#20332A] hover:bg-white border border-slate-200/80 shadow-2xs' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Terbaru</span>
                </a>

                <!-- Tombol Filter Dropdown -->
                <div class="relative">
                    <button type="button" 
                            @click="filterOpen = !filterOpen" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold transition-all backdrop-blur-xl backdrop-saturate-150 cursor-pointer {{ request('category') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white/80 text-[#20332A] hover:bg-white border border-slate-200/80 shadow-2xs' }}">
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
                         class="absolute right-0 mt-2 w-52 bg-white/90 backdrop-blur-2xl rounded-2xl border border-white/90 shadow-2xl z-50 p-2 space-y-1">
                        
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

        <!-- Mobile Floating Bottom Capsule Bar (Frosted Glass Glassmorphism with Refraction) -->
        <div class="sm:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999] pointer-events-auto"
             x-data="{ 
                 mobileTab: '{{ request('category') ? 'filter' : (request('sort') === 'latest' || !request('sort') ? 'latest' : 'filter') }}',
                 mobileFilterOpen: false 
             }"
             @click.away="mobileFilterOpen = false">
            
            <!-- Refracting Glass Capsule Outer Container -->
            <div class="relative flex items-center h-11 bg-white/70 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white/90 ring-1 ring-slate-900/10 shadow-2xl shadow-emerald-950/10 p-1 rounded-full w-[190px]">
                
                <!-- Refracting Frosted Glass Flowing Indicator Pill -->
                <div class="absolute top-1 bottom-1 rounded-full bg-[#0A3D29]/15 backdrop-blur-2xl backdrop-saturate-200 border border-[#0A3D29]/25 shadow-xs transition-all duration-300 ease-out pointer-events-none"
                     :style="mobileTab === 'latest' ? 'left: 4px; width: calc(50% - 4px);' : 'left: 50%; width: calc(50% - 4px);'">
                </div>

                <!-- Button 1: Terbaru -->
                <a href="{{ route('public.news.index', ['sort' => 'latest']) }}" 
                   @click="mobileTab = 'latest'; mobileFilterOpen = false"
                   class="relative z-10 flex-1 h-full flex items-center justify-center rounded-full text-xs font-extrabold transition-colors duration-300 select-none"
                   :class="mobileTab === 'latest' ? 'text-[#0A3D29]' : 'text-[#6C7B72] hover:text-[#20332A]'">
                    <span>Terbaru</span>
                </a>

                <!-- Button 2: Filter -->
                <button type="button" 
                        @click="mobileTab = 'filter'; mobileFilterOpen = !mobileFilterOpen"
                        class="relative z-10 flex-1 h-full flex items-center justify-center gap-1 rounded-full text-xs font-extrabold transition-colors duration-300 select-none cursor-pointer"
                        :class="mobileTab === 'filter' ? 'text-[#0A3D29]' : 'text-[#6C7B72] hover:text-[#20332A]'">
                    <span>Filter</span>
                    <svg class="w-3 h-3 transition-transform duration-200" :class="mobileFilterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Category Dropdown Popup (Frosted Glass Refraction) -->
            <div x-show="mobileFilterOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="absolute bottom-14 left-1/2 -translate-x-1/2 w-48 bg-white/90 backdrop-blur-3xl backdrop-saturate-200 rounded-2xl border border-white/90 shadow-2xl p-1.5 space-y-0.5 z-[999999]">
                
                <a href="{{ route('public.news.index') }}" 
                   class="block px-3 py-1.5 rounded-xl text-[11px] font-bold transition {{ !request('category') ? 'bg-[#EAF1E8] text-[#0A3D29]' : 'text-slate-700 hover:bg-slate-50' }}">
                    Semua Kategori
                </a>

                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $cat)
                        <a href="{{ route('public.news.index', ['category' => $cat]) }}" 
                           class="block px-3 py-1.5 rounded-xl text-[11px] font-semibold transition {{ request('category') === $cat ? 'bg-[#EAF1E8] text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                @else
                    <a href="{{ route('public.news.index', ['category' => 'Berita']) }}" 
                       class="block px-3 py-1.5 rounded-xl text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
                        Berita
                    </a>
                    <a href="{{ route('public.news.index', ['category' => 'Pengumuman']) }}" 
                       class="block px-3 py-1.5 rounded-xl text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
                        Pengumuman
                    </a>
                    <a href="{{ route('public.news.index', ['category' => 'Kegiatan']) }}" 
                       class="block px-3 py-1.5 rounded-xl text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
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
            @endphp

            <!-- Frameless 4-Column Editorial Magazine Grid (Matching User's Screenshot Design) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 pb-4">
                @foreach($newsList as $index => $news)
                    @php
                        $imageSrc = $news->image_path 
                            ? asset('storage/' . $news->image_path) 
                            : asset($defaultImages[$index % count($defaultImages)]);
                        $formattedDate = $news->published_at ? $news->published_at->format('d M Y') : $news->created_at->format('d M Y');
                        $authorName = $news->author->name ?? 'Admin Desa';
                    @endphp

                    <article class="group block space-y-2.5">
                        <!-- Top Image Banner with Sparkling Shimmer Preloader (Active only while loading) -->
                        <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden bg-slate-200/80 shadow-2xs"
                             x-data="{ loaded: false }"
                             x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                            <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                            <img x-ref="img"
                                 src="{{ $imageSrc }}" 
                                 alt="{{ $news->title }}" 
                                 loading="lazy"
                                 @load="loaded = true;"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500"
                                 :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                        </div>

                        <!-- Card Details Directly Under Image (Frameless Minimalist Editorial) -->
                        <div class="space-y-1.5">
                            <!-- Category Tag (Uppercase Green) -->
                            <span class="text-[11px] font-bold text-[#0A3D29] uppercase tracking-wider block font-['Inter',sans-serif]">
                                {{ $news->category }}
                            </span>

                            <!-- News Title -->
                            <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-[#191c1e] group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-2">
                                <a href="{{ route('public.news.show', $news->slug) }}" class="focus:outline-none">
                                    {{ $news->title }}
                                </a>
                            </h3>

                            <!-- Meta Date & Author -->
                            <div class="flex items-center gap-2 text-xs text-[#75777e] font-medium">
                                <span>{{ $formattedDate }}</span>
                                <span>•</span>
                                <span>{{ $authorName }}</span>
                            </div>

                            <!-- News Excerpt -->
                            <p class="text-xs text-[#44474e] leading-relaxed font-normal line-clamp-3 pt-0.5">
                                {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 120) }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pt-6">
                {{ $newsList->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <span class="text-4xl block mb-3">📰</span>
                <h3 class="font-serif text-lg font-bold text-slate-700">Belum ada berita ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        @endif

    </div>
</div>

@endsection
