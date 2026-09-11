@extends('layouts.public')

@section('title', 'Galeri Foto Kegiatan - Desa Catur Sambi Boyolali')
@section('meta_description', 'Dokumentasi visual foto kegiatan, pembangunan, potensi desa wisata, pertanian, dan kemasyarakatan Pemerintah Desa Catur, Boyolali.')

@section('content')

<!-- Unified Main Page Container (Clean White Canvas) -->
<div class="bg-white min-h-screen py-8 sm:py-10" 
     x-data="{ 
         filterOpen: false, 
         activeModal: false, 
         activeImage: '', 
         activeTitle: '', 
         activeCaption: '', 
         activeDate: '', 
         activeCategory: '', 
         activeUrl: '',
         isReady: false
     }"
     x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 120); })"
     @keydown.escape.window="activeModal = false">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Title & Action Buttons (Terbaru, Populer & Filter Kategori) -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 sm:gap-6 pb-6 border-b border-slate-200/80 text-left">
            
            <!-- Clean Title & Subtitle with Route Breadcrumbs -->
            <div>
                <x-breadcrumbs :items="[
                    ['label' => 'BERANDA', 'url' => route('home')],
                    ['label' => 'Galeri Foto']
                ]" />
                <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#20332A] leading-tight tracking-tight">
                    Galeri Foto Kegiatan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                    Dokumentasi visual kegiatan, pembangunan, dan potensi kemasyarakatan Desa Catur dari berita resmi desa.
                </p>
            </div>

            <!-- Action Buttons: Terbaru & Filter Dropdown -->
            <div class="flex items-center gap-2.5 relative flex-wrap sm:flex-nowrap">
                
                <!-- Tombol Terbaru -->
                <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'latest'])) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold transition-all backdrop-blur-xl {{ (!request('sort') || request('sort') === 'latest') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80 shadow-2xs' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Terbaru</span>
                </a>

                <!-- Tombol Populer -->
                <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'popular'])) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold transition-all backdrop-blur-xl {{ (request('sort') === 'popular') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80 shadow-2xs' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>Populer</span>
                </a>

                <!-- Tombol Filter Dropdown -->
                <div class="relative">
                    <button type="button" 
                            @click="filterOpen = !filterOpen" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer {{ request('category') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80 shadow-2xs' }}">
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
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl border border-slate-200 shadow-2xl z-50 p-2 space-y-1">
                        
                        <a href="{{ route('public.gallery', request()->except(['category', 'page'])) }}" 
                           class="block px-3.5 py-2 rounded-xl text-xs font-bold transition {{ !request('category') ? 'bg-[#0A3D29]/15 text-[#0A3D29]' : 'text-slate-700 hover:bg-slate-100/70' }}">
                            Semua Kategori
                        </a>

                        @foreach($categories as $cat)
                            <a href="{{ route('public.gallery', array_merge(request()->except(['page']), ['category' => $cat])) }}" 
                               class="block px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request('category') === $cat ? 'bg-[#0A3D29]/15 text-[#0A3D29]' : 'text-slate-700 hover:bg-slate-100/70' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        <!-- Gallery Grid Container with Progressive Reveal -->
        <div class="relative min-h-[400px]" :aria-busy="!isReady">
            <!-- Skeleton Grid (Initial Loading State) -->
            <div x-show="!isReady" 
                 x-transition:leave="transition-opacity duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                 aria-hidden="true">
                @for($i = 0; $i < 6; $i++)
                    <x-skeleton.gallery-card />
                @endfor
            </div>

            <!-- Real Content (Fades in smoothly) -->
            <div x-show="isReady" 
                 x-cloak
                 x-transition:enter="transition-opacity duration-300 ease-out"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                @if(isset($galleries) && $galleries->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        @foreach($galleries as $item)
                            @php
                                $imageExists = $item->image_path && (
                                    file_exists(public_path('storage/' . $item->image_path)) || 
                                    file_exists(storage_path('app/public/' . $item->image_path)) ||
                                    file_exists(public_path($item->image_path))
                                );
                                if ($imageExists) {
                                    $imgUrl = file_exists(public_path($item->image_path)) 
                                        ? asset($item->image_path) 
                                        : asset('storage/' . $item->image_path);
                                } else {
                                    $imgUrl = asset('images/hero_landscape.png');
                                }
                                $formattedDate = $item->published_at ? $item->published_at->translatedFormat('d F Y') : $item->created_at->translatedFormat('d F Y');
                                $newsUrl = route('public.news.show', $item->slug);
                            @endphp

                            <div class="group bg-white rounded-2xl border border-slate-200/90 hover:border-[#0A3D29]/40 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden cursor-pointer"
                                 @click="
                                    activeModal = true; 
                                    activeImage = '{{ $imgUrl }}'; 
                                    activeTitle = '{{ addslashes($item->title) }}'; 
                                    activeCaption = '{{ addslashes($item->image_caption ?? $item->excerpt ?? '') }}'; 
                                    activeDate = '{{ $formattedDate }}'; 
                                    activeCategory = '{{ addslashes($item->category ?? 'Berita Desa') }}'; 
                                    activeUrl = '{{ $newsUrl }}';
                                 ">
                                
                                <!-- Image Container with 16:10 Ratio & Shimmer Glow -->
                                <div class="relative aspect-[16/10] bg-slate-100 overflow-hidden" x-data="{ imgLoaded: false }">
                                    <!-- Image Shimmer Placeholder -->
                                    <div x-show="!imgLoaded" class="absolute inset-0 skeleton-shimmer" aria-hidden="true"></div>

                                    <img src="{{ $imgUrl }}" 
                                         alt="{{ $item->title }}" 
                                         loading="lazy"
                                         @load="imgLoaded = true"
                                         :class="imgLoaded ? 'opacity-100' : 'opacity-0'"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 ease-out">
                                    
                                    <!-- Category Badge Overlay -->
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#0A3D29]/80 backdrop-blur-md text-white shadow-xs border border-white/20">
                                            {{ $item->category ?? 'Berita' }}
                                        </span>
                                    </div>

                                    <!-- Hover Overlay: Magnifier Icon -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <div class="w-11 h-11 rounded-full bg-white/90 text-[#0A3D29] flex items-center justify-center shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3">
                                    <div>
                                        <h2 class="font-serif font-bold text-sm sm:text-base text-slate-900 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                            {{ $item->title }}
                                        </h2>
                                        @if(!empty($item->image_caption))
                                            <p class="text-xs text-slate-500 line-clamp-1 mt-1 font-normal italic">
                                                {{ $item->image_caption }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Bottom Meta Row -->
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                                        <span class="flex items-center gap-1.5 font-medium">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $formattedDate }}</span>
                                        </span>
                                        <span class="text-[#0A3D29] font-bold inline-flex items-center gap-1 group-hover:underline">
                                            <span>Lihat</span>
                                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination Links -->
                    <div class="pt-8 flex justify-center">
                        {{ $galleries->links() }}
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-20 bg-slate-50/80 rounded-3xl border border-slate-200/80 max-w-2xl mx-auto px-6 space-y-4">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center mx-auto shadow-xs">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-serif text-lg sm:text-xl font-bold text-slate-800">
                            Belum Ada Foto untuk Kategori Ini
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                            Foto dokumentasi visual akan otomatis muncul saat berita dengan lampiran gambar dipublikasikan.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('public.gallery') }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0A3D29] text-white text-xs font-bold shadow-xs hover:bg-[#072B1D] transition">
                                <span>Tampilkan Semua Foto</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- LIGHTBOX PREVIEW MODAL (INTERAKTIF & ELEGAN)                               -->
    <!-- ========================================================================= -->
    <div x-show="activeModal" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-black/85 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="activeModal = false">
        
        <div class="relative max-w-4xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl border border-white/20 flex flex-col max-h-[90vh]" 
             @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <!-- Close Button Top Floating -->
            <button @click="activeModal = false" 
                    type="button"
                    class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center shadow-lg transition-all focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Large Photo Display Area -->
            <div class="bg-black/95 flex items-center justify-center overflow-hidden flex-1 min-h-[300px] max-h-[60vh] relative">
                <img :src="activeImage" 
                     :alt="activeTitle" 
                     class="w-full h-full max-h-[60vh] object-contain select-none">
            </div>

            <!-- Modal Info Footer -->
            <div class="p-6 sm:p-7 bg-white border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1.5 max-w-xl">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-[#0A3D29] text-[11px] font-bold" x-text="activeCategory"></span>
                        <span class="text-xs text-slate-400 font-medium" x-text="activeDate"></span>
                    </div>
                    <h3 class="font-serif text-lg sm:text-xl font-bold text-slate-900 leading-snug" x-text="activeTitle"></h3>
                    <p class="text-xs sm:text-sm text-slate-600 font-normal line-clamp-2" x-text="activeCaption" x-show="activeCaption"></p>
                </div>

                <div class="shrink-0 pt-2 sm:pt-0">
                    <a :href="activeUrl" 
                       class="inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-xl shadow-md transition-all">
                        <span>Baca Berita Terkait</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
