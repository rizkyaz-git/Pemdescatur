@extends('layouts.public')

@section('title', 'Galeri Foto Kegiatan - Pemerintah Desa Catur')
@section('meta_description', 'Dokumentasi foto kegiatan Pemerintah Desa Catur')

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
                    Galeri Foto
                </h1>
            </div>

            <!-- Action Buttons Desktop: Terbaru, Populer & Filter Dropdown -->
            <div class="hidden sm:flex items-center gap-2.5 relative">
                
                <!-- Tombol Terbaru -->
                <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'latest'])) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all backdrop-blur-xl {{ (!request('sort') || request('sort') === 'latest') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80 shadow-2xs' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Terbaru</span>
                </a>

                <!-- Tombol Populer -->
                <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'popular'])) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all backdrop-blur-xl {{ (request('sort') === 'popular') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80 shadow-2xs' }}">
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
                            title="Filter Kategori{{ request('category') ? ': ' . request('category') : '' }}"
                            class="relative inline-flex items-center justify-center w-9 h-9 rounded-xl text-xs font-bold transition-all cursor-pointer {{ request('category') ? 'bg-[#0A3D29]/15 text-[#0A3D29] border border-[#0A3D29]/30 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80 shadow-2xs' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        @if(request('category'))
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#0A3D29]"></span>
                        @endif
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
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl border border-slate-200 shadow-2xl z-50 p-2 space-y-1">
                        
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

        <!-- Mobile Floating Bottom Capsule Bar -->
        <div class="sm:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999] pointer-events-auto"
             x-data="{ 
                 mobileTab: '{{ request('category') ? 'filter' : (request('sort') === 'popular' ? 'popular' : 'latest') }}',
                 mobileFilterOpen: false 
             }"
             @click.away="mobileFilterOpen = false">
            
            <!-- Capsule Outer Container (Compact & Snug fit to prevent collision with scroll-to-top) -->
            <div class="relative flex items-center h-11 bg-white/75 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl p-1 rounded-xl w-[210px] transition-all duration-300">
                
                <!-- Flowing Indicator Pill -->
                <div class="absolute top-1 bottom-1 rounded-lg bg-[#0A3D29]/10 transition-all duration-200 ease-out pointer-events-none"
                     :style="mobileTab === 'latest' ? 'left: 4px; width: calc((100% - 44px) / 2);' : (mobileTab === 'popular' ? 'left: calc(4px + (100% - 44px) / 2); width: calc((100% - 44px) / 2);' : 'left: calc(100% - 40px); width: 36px;')">
                </div>

                <!-- Button 1: Terbaru -->
                <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'latest'])) }}" 
                   @click="mobileTab = 'latest'; mobileFilterOpen = false"
                   class="relative z-10 flex-1 h-full flex items-center justify-center rounded-lg text-xs transition-colors duration-200 select-none"
                   :class="mobileTab === 'latest' ? 'text-[#0A3D29] font-bold' : 'text-slate-600 font-medium hover:text-slate-900'">
                    <span>Terbaru</span>
                </a>

                <!-- Button 2: Populer -->
                <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'popular'])) }}" 
                   @click="mobileTab = 'popular'; mobileFilterOpen = false"
                   class="relative z-10 flex-1 h-full flex items-center justify-center rounded-lg text-xs transition-colors duration-200 select-none"
                   :class="mobileTab === 'popular' ? 'text-[#0A3D29] font-bold' : 'text-slate-600 font-medium hover:text-slate-900'">
                    <span>Populer</span>
                </a>

                <!-- Button 3: Filter (Hanya Ikon Saja - Mengepaskan Area Ikon) -->
                <button type="button" 
                        @click="mobileTab = 'filter'; mobileFilterOpen = !mobileFilterOpen"
                        title="Filter Kategori"
                        class="relative z-10 w-9 h-full flex items-center justify-center rounded-lg transition-colors duration-200 select-none cursor-pointer shrink-0"
                        :class="mobileTab === 'filter' ? 'text-[#0A3D29]' : 'text-slate-600 hover:text-slate-900'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    @if(request('category'))
                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-[#0A3D29]"></span>
                    @endif
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
                 class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2 w-56 max-h-60 overflow-y-auto bg-white/85 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 rounded-xl border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl p-1.5 space-y-0.5 z-[999999]">
                
                <a href="{{ route('public.gallery', request()->except(['category', 'page'])) }}" 
                   class="block px-3 py-2 rounded-xl text-xs transition {{ !request('category') ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-white/60 font-medium' }}">
                    Semua Kategori
                </a>

                @foreach($categories as $cat)
                    <a href="{{ route('public.gallery', array_merge(request()->except(['page']), ['category' => $cat])) }}" 
                       class="block px-3 py-2 rounded-xl text-xs transition {{ request('category') === $cat ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-white/60 font-medium' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Gallery Masonry Collage Container with Progressive Reveal -->
        <div class="relative min-h-[400px]" :aria-busy="!isReady">
            <!-- Skeleton Masonry Grid (Initial Loading State) -->
            <div x-show="!isReady" 
                 x-transition:leave="transition-opacity duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 sm:gap-5 lg:gap-6"
                 aria-hidden="true">
                @php
                    $skeletonAspects = ['aspect-[4/5]', 'aspect-[16/11]', 'aspect-[3/4]', 'aspect-square', 'aspect-[16/10]', 'aspect-[5/6]'];
                @endphp
                @for($i = 0; $i < 6; $i++)
                    <x-skeleton.gallery-card :aspect="$skeletonAspects[$i % count($skeletonAspects)]" />
                @endfor
            </div>

            <!-- Real Content (Fades in smoothly) -->
            <div x-show="isReady" 
                 x-cloak
                 x-transition:enter="transition-opacity duration-300 ease-out"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                @if(isset($galleries) && $galleries->count() > 0)
                    <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 sm:gap-5 lg:gap-6">
                        @php
                            // Variasi aspek rasio foto untuk menciptakan layout asymmetric masonry collage yang dinamis, modern, dan tetap seimbang
                            $aspectRhythms = [
                                'aspect-[4/5]',   // Tall portrait
                                'aspect-[16/11]', // Clean landscape
                                'aspect-[3/4]',   // Vertical portrait
                                'aspect-square',  // Square
                                'aspect-[16/10]', // Wide landscape
                                'aspect-[5/6]',   // Medium portrait
                                'aspect-[4/3]',   // Classic landscape
                                'aspect-[3/4]',   // Elegant portrait
                            ];
                        @endphp
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
                                $currentAspect = $aspectRhythms[$loop->index % count($aspectRhythms)];
                            @endphp

                            <div class="break-inside-avoid mb-4 sm:mb-5 lg:mb-6 group relative {{ $currentAspect }} rounded-lg overflow-hidden bg-slate-900/5 shadow-xs hover:shadow-2xl transition-all duration-500 cursor-pointer"
                                 @click="
                                    activeModal = true; 
                                    activeImage = '{{ $imgUrl }}'; 
                                    activeTitle = '{{ addslashes($item->title) }}'; 
                                    activeCaption = '{{ addslashes($item->image_caption ?? $item->excerpt ?? '') }}'; 
                                    activeDate = '{{ $formattedDate }}'; 
                                    activeCategory = '{{ addslashes($item->category ?? 'Berita Desa') }}'; 
                                    activeUrl = '{{ $newsUrl }}';
                                 ">
                                
                                <!-- Foto Sebagai Fokus Utama (Tidak terdistorsi dengan object-cover & Zoom-in halus saat hover) -->
                                <img src="{{ $imgUrl }}" 
                                     alt="{{ $item->title }}" 
                                     loading="lazy"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 ease-out select-none">
                                
                                <!-- Gradasi Gelap Transparan (Mendukung keterbacaan teks, menggelap halus saat hover) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent opacity-80 group-hover:opacity-95 transition-opacity duration-300 pointer-events-none"></div>

                                <!-- HANYA JUDUL FOTO di Bagian Bawah (Teks putih, lebih jelas & smooth saat hover) -->
                                <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5 lg:p-6 z-10 pointer-events-none">
                                    <h2 class="font-serif font-bold text-white/95 group-hover:text-white text-sm sm:text-base lg:text-lg leading-snug drop-shadow-md transform translate-y-1 group-hover:translate-y-0 transition-all duration-300 line-clamp-2 sm:line-clamp-3">
                                        {{ $item->title }}
                                    </h2>
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
                    <div class="text-center py-20 bg-slate-50/80 rounded-xl border border-slate-200/80 max-w-2xl mx-auto px-6 space-y-4">
                        <div class="w-16 h-16 rounded-xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center mx-auto shadow-xs">
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
    <!-- LIGHTBOX PREVIEW MODAL (GLASSMORPHISM BURAM MEMBIASKAN GALERI)             -->
    <!-- ========================================================================= -->
    <div x-show="activeModal" 
         x-cloak 
         class="fixed inset-0 z-[100000] flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-black/60 backdrop-blur-xs overflow-y-auto"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="activeModal = false">
        
        <div class="relative max-w-3xl w-full rounded-lg overflow-hidden shadow-2xl border border-white/30 flex flex-col max-h-[90vh] my-auto bg-slate-900/20 backdrop-blur-md" 
             @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <!-- Tombol Silang Menyesuaikan Latar untuk Keterbacaan yang Baik -->
            <button @click="activeModal = false" 
                    type="button"
                    title="Tutup"
                    class="absolute top-3 right-3 z-20 w-9 h-9 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center shadow-lg backdrop-blur-md border border-white/30 transition-all duration-200 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Photo Display Area - Mengepaskan Frame Proporsional (Object Cover) -->
            <div class="relative w-full aspect-[16/10] max-h-[65vh] bg-black/40 overflow-hidden">
                <img :src="activeImage" 
                     :alt="activeTitle" 
                     class="w-full h-full object-cover select-none">
            </div>

            <!-- Latar Bagian Judul & Tanggal Bergaya Kaca Buram Glassmorphism (Membiaskan Halaman Galeri) -->
            <div class="px-5 py-4 bg-white/85 backdrop-blur-xl border-t border-white/40 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                <div class="min-w-0 flex-1 space-y-1">
                    <span class="inline-block text-[11px] sm:text-xs text-slate-500 font-medium" x-text="activeDate"></span>
                    <h3 class="font-serif text-sm sm:text-base font-bold text-slate-900 leading-snug line-clamp-none sm:line-clamp-2" x-text="activeTitle"></h3>
                </div>
                <a :href="activeUrl" 
                   x-show="activeUrl"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:py-1.5 rounded-md border border-[#0A3D29] text-[#0A3D29] hover:bg-[#0A3D29]/5 text-xs font-semibold transition-colors shrink-0">
                    <span>Lihat Berita</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
