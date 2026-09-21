@extends('layouts.public')

@section('title', 'Galeri Foto Kegiatan - Pemerintah Desa Catur')
@section('meta_description', 'Dokumentasi foto kegiatan Pemerintah Desa Catur')

@section('content')

<!-- Unified Main Page Container (Clean White Canvas) -->
<div class="bg-white min-h-screen py-8 sm:py-10" 
     x-data="{ 
         filterOpen: false, 
         activeModal: false, 
         backdropVisible: false,
         contentVisible: false,
         isClosing: false,
         activeImage: '', 
         activeTitle: '', 
         activeCaption: '', 
         activeDate: '', 
          activeCategory: '', 
          activeUrl: '',
          downloadFileName: '',
          zoomLevel: 1,
          panX: 0,
          panY: 0,
          isDragging: false,
          hasDragged: false,
          dragStartX: 0,
          dragStartY: 0,
          dragStartPanX: 0,
          dragStartPanY: 0,
          isReady: false,
          originElement: null,
          touchTimer: null,
          touchStartX: 0,
          touchStartY: 0,
          longPressTriggered: false,

          zoomIn() {
              if (this.zoomLevel < 3) {
                  this.zoomLevel = Math.min(3, +(this.zoomLevel + 0.5).toFixed(1));
              }
          },

          zoomOut() {
              if (this.zoomLevel > 1) {
                  this.zoomLevel = Math.max(1, +(this.zoomLevel - 0.5).toFixed(1));
                  if (this.zoomLevel === 1) {
                      this.panX = 0;
                      this.panY = 0;
                  }
              }
          },

          resetZoom() {
              this.zoomLevel = 1;
              this.panX = 0;
              this.panY = 0;
          },

          toggleZoom() {
              if (this.zoomLevel > 1) {
                  this.zoomLevel = 1;
                  this.panX = 0;
                  this.panY = 0;
              } else {
                  this.zoomLevel = 2;
              }
          },

          startDrag(e) {
              if (this.zoomLevel <= 1) return;
              this.isDragging = true;
              this.hasDragged = false;
              const clientX = e.touches ? e.touches[0].clientX : e.clientX;
              const clientY = e.touches ? e.touches[0].clientY : e.clientY;
              this.dragStartX = clientX;
              this.dragStartY = clientY;
              this.dragStartPanX = this.panX;
              this.dragStartPanY = this.panY;
          },

          onDrag(e) {
              if (!this.isDragging || this.zoomLevel <= 1) return;
              const clientX = e.touches ? e.touches[0].clientX : e.clientX;
              const clientY = e.touches ? e.touches[0].clientY : e.clientY;
              const deltaX = clientX - this.dragStartX;
              const deltaY = clientY - this.dragStartY;
              if (Math.hypot(deltaX, deltaY) > 5) {
                  this.hasDragged = true;
              }
              this.panX = this.dragStartPanX + deltaX;
              this.panY = this.dragStartPanY + deltaY;
          },

          endDrag() {
              this.isDragging = false;
          },

          handleImageClick(e) {
              if (this.hasDragged) {
                  this.hasDragged = false;
                  return;
              }
              this.toggleZoom();
          },

          openLightbox(e, data) {
              if (this.activeModal) return;

              this.activeImage = data.image;
              this.activeTitle = data.title;
              this.activeCaption = data.caption;
              this.activeDate = data.date;
              this.activeCategory = data.category;
              this.activeUrl = data.url;
              this.zoomLevel = 1;
              this.panX = 0;
              this.panY = 0;
              this.isDragging = false;
              this.hasDragged = false;

              // Format nama file untuk unduhan
              const rawTitle = data.title ? data.title.trim().replace(/[^a-zA-Z0-9_\-\s]/g, '').replace(/\s+/g, '_') : 'foto-desa-catur';
              this.downloadFileName = `${rawTitle || 'foto-desa-catur'}.jpg`;

              this.isClosing = false;
              this.activeModal = true;
              this.backdropVisible = false;
              this.contentVisible = false;
              document.body.style.overflow = 'hidden';

              this.$nextTick(() => {
                  requestAnimationFrame(() => {
                      this.backdropVisible = true;
                      this.contentVisible = true;
                  });
              });
          },

          closeLightbox() {
              if (this.isClosing || !this.activeModal) return;
              this.isClosing = true;
              this.contentVisible = false;
              this.backdropVisible = false;
              this.zoomLevel = 1;
              this.panX = 0;
              this.panY = 0;
              this.isDragging = false;
              this.hasDragged = false;

              setTimeout(() => {
                  this.activeModal = false;
                  this.isClosing = false;
                  document.body.style.overflow = '';
              }, 200);
          },

         async downloadActiveImage(e) {
             if (!this.activeImage) return;
             try {
                 const response = await fetch(this.activeImage);
                 if (!response.ok) throw new Error('Download failed');
                 const blob = await response.blob();
                 const blobUrl = window.URL.createObjectURL(blob);
                 const a = document.createElement('a');
                 a.style.display = 'none';
                 a.href = blobUrl;
                 a.download = this.downloadFileName || 'foto-desa-catur.jpg';
                 document.body.appendChild(a);
                 a.click();
                 window.URL.revokeObjectURL(blobUrl);
                 document.body.removeChild(a);
             } catch (err) {
                 const a = document.createElement('a');
                 a.href = this.activeImage;
                 a.download = this.downloadFileName || 'foto-desa-catur.jpg';
                 a.target = '_blank';
                 document.body.appendChild(a);
                 a.click();
                 document.body.removeChild(a);
             }
         },

         handleTouchStart(e, data) {
             if (!e.touches || e.touches.length !== 1) return;
             this.longPressTriggered = false;
             this.touchStartX = e.touches[0].clientX;
             this.touchStartY = e.touches[0].clientY;

             if (this.touchTimer) clearTimeout(this.touchTimer);
             this.touchTimer = setTimeout(() => {
                 this.longPressTriggered = true;
                 if (navigator.vibrate) {
                     try { navigator.vibrate(40); } catch(err) {}
                 }
                 this.openLightbox(e, data);
             }, 450);
         },

         handleTouchMove(e) {
             if (!this.touchTimer) return;
             const moveX = e.touches[0].clientX;
             const moveY = e.touches[0].clientY;
             if (Math.hypot(moveX - this.touchStartX, moveY - this.touchStartY) > 10) {
                 clearTimeout(this.touchTimer);
                 this.touchTimer = null;
             }
         },

         handleTouchEnd() {
             if (this.touchTimer) {
                 clearTimeout(this.touchTimer);
                 this.touchTimer = null;
             }
         },

         handleClick(e, data) {
             if (this.longPressTriggered) {
                 this.longPressTriggered = false;
                 return;
             }
             this.openLightbox(e, data);
         }
     }"
     x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 120); })"
     @keydown.escape.window="closeLightbox()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 sm:space-y-6">
        
        <!-- Header Title & Action Buttons (Terbaru, Populer & Filter Kategori) -->
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 text-left">
            
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

            <!-- Action Buttons Desktop: Terbaru & Populer (Satu Pembungkus) + Filter Dropdown (Terpisah & Fill Solid) -->
            <div class="hidden sm:flex items-center gap-2.5 relative">
                
                <!-- Pembungkus Segmented: Terbaru & Populer (Tidak terlalu rounded / rounded-lg) -->
                <div class="inline-flex items-center p-1 bg-slate-100/90 rounded-lg border border-slate-200/80 shadow-2xs">
                    <!-- Tombol Terbaru -->
                    <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'latest'])) }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md text-xs transition-all {{ (!request('sort') || request('sort') === 'latest') ? 'bg-white text-[#0A3D29] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Terbaru</span>
                    </a>

                    <!-- Tombol Populer -->
                    <a href="{{ route('public.gallery', array_merge(request()->except(['sort', 'page']), ['sort' => 'popular'])) }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md text-xs transition-all {{ (request('sort') === 'popular') ? 'bg-white text-[#0A3D29] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>Populer</span>
                    </a>
                </div>

                <!-- Tombol Filter Dropdown (Terpisah & Fill Solid) -->
                <div class="relative">
                    <button type="button" 
                            @click="filterOpen = !filterOpen" 
                            title="Filter Kategori{{ request('category') ? ': ' . request('category') : '' }}"
                            class="relative inline-flex items-center justify-center w-9 h-9 rounded-lg text-xs font-bold transition-all cursor-pointer bg-[#0A3D29] text-white hover:bg-[#072B1D] shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        @if(request('category'))
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-emerald-400 ring-2 ring-[#0A3D29]"></span>
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
                         class="absolute right-0 mt-2 w-56 bg-white rounded-lg border border-slate-200 shadow-xl z-50 p-1.5 space-y-0.5">
                        
                        <a href="{{ route('public.gallery', request()->except(['category', 'page'])) }}" 
                           class="block px-3 py-1.5 rounded-md text-xs font-medium transition {{ !request('category') ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-slate-100' }}">
                            Semua Kategori
                        </a>

                        @foreach($categories as $cat)
                            <a href="{{ route('public.gallery', array_merge(request()->except(['page']), ['category' => $cat])) }}" 
                               class="block px-3 py-1.5 rounded-md text-xs font-medium transition {{ request('category') === $cat ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-slate-100' }}">
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
                 class="columns-2 sm:columns-2 lg:columns-3 xl:columns-4 gap-3 sm:gap-5 lg:gap-6"
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
                    <div class="columns-2 sm:columns-2 lg:columns-3 xl:columns-4 gap-3 sm:gap-5 lg:gap-6">
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
                                $galleryData = [
                                    'image' => $imgUrl,
                                    'title' => $item->title,
                                    'caption' => $item->image_caption ?? $item->excerpt ?? '',
                                    'date' => $formattedDate,
                                    'category' => $item->category ?? 'Berita Desa',
                                    'url' => $newsUrl,
                                ];
                            @endphp

                            <div class="break-inside-avoid mb-3 sm:mb-5 lg:mb-6 group relative {{ $currentAspect }} rounded-xl overflow-hidden bg-slate-900/5 shadow-xs hover:shadow-2xl transition-all duration-500 cursor-pointer select-none"
                                 @touchstart="handleTouchStart($event, @js($galleryData))"
                                 @touchmove="handleTouchMove($event)"
                                 @touchend="handleTouchEnd()"
                                 @click="handleClick($event, @js($galleryData))">
                                
                                <!-- Foto Sebagai Fokus Utama (Tidak terdistorsi dengan object-cover & Zoom-in halus saat hover) -->
                                <img src="{{ $imgUrl }}" 
                                     alt="{{ $item->title }}" 
                                     loading="lazy"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 ease-out select-none">
                                
                                <!-- Gradasi Gelap Transparan (Mendukung keterbacaan teks, menggelap halus saat hover) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent opacity-80 group-hover:opacity-95 transition-opacity duration-300 pointer-events-none"></div>

                                <!-- HANYA JUDUL FOTO di Bagian Bawah (Teks putih, lebih jelas & smooth saat hover) -->
                                <div class="absolute inset-x-0 bottom-0 p-2.5 sm:p-5 lg:p-6 z-10 pointer-events-none">
                                    <h2 class="font-serif font-bold text-white/95 group-hover:text-white text-xs sm:text-base lg:text-lg leading-snug drop-shadow-md transform translate-y-1 group-hover:translate-y-0 transition-all duration-300 line-clamp-2 sm:line-clamp-3">
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
    <!-- DARK EDITORIAL PHOTO VIEWER                                               -->
    <!-- ========================================================================= -->
    <div x-show="activeModal" 
         x-cloak 
         class="fixed inset-0 z-[100000] overflow-hidden select-none bg-[#0D0F0E] transition-opacity duration-200 ease-out"
         :class="backdropVisible ? 'opacity-100' : 'opacity-0 pointer-events-none'"
         @click="closeLightbox()"
         @keydown.escape.window="closeLightbox()"
         @mousemove.window="onDrag($event)"
         @mouseup.window="endDrag()"
         @touchmove.window="onDrag($event)"
         @touchend.window="endDrag()">
        
        <!-- Header Controls (Dark Glassmorphism membiaskan latar) -->
        <div class="absolute top-0 inset-x-0 z-30 flex items-center justify-between px-4 py-3 sm:px-8 sm:py-4 pointer-events-auto bg-[#0D0F0E]/75 border-b border-white/[0.08] transition-opacity duration-200 ease-out"
             style="-webkit-backdrop-filter: blur(20px) saturate(150%); backdrop-filter: blur(20px) saturate(150%);"
             :class="contentVisible ? 'opacity-100' : 'opacity-0'"
             @click.stop>
            
            <!-- Subtle Label (Editorial Context) -->
            <span class="text-[11px] uppercase tracking-[0.2em] text-neutral-400 font-medium hidden sm:inline select-none">
                Pratinjau Gambar
            </span>

            <!-- Right: Minimalist Editorial Controls -->
            <div class="flex items-center gap-2 sm:gap-2.5 ml-auto">
                <!-- Tombol Unduh -->
                <button type="button" 
                        @click.stop="downloadActiveImage($event)"
                        title="Unduh foto asli"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-neutral-300 hover:text-white bg-white/[0.04] hover:bg-white/[0.09] border border-white/15 hover:border-white/30 text-xs font-medium transition-colors duration-150 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Unduh</span>
                </button>

                <!-- Tombol Close (×) -->
                <button type="button" 
                        @click.stop="closeLightbox()"
                        title="Tutup (Esc)"
                        class="w-8 h-8 rounded-md text-neutral-400 hover:text-white bg-white/[0.04] hover:bg-white/[0.09] border border-white/10 hover:border-white/20 flex items-center justify-center transition-colors duration-150 cursor-pointer focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Center Stage: Foto Sebagai Focal Point Utama (Dapat di-Zoom & di-Geser/Pan) -->
        <div class="absolute inset-0 z-10 flex items-center justify-center select-none overflow-hidden"
             @click.self="closeLightbox()">
            <img x-ref="modalImage"
                 :src="activeImage" 
                 :alt="activeTitle" 
                 @mousedown="startDrag($event)"
                 @touchstart.passive="startDrag($event)"
                 @click.stop="handleImageClick($event)"
                 class="max-h-[calc(100dvh-230px)] sm:max-h-[calc(100vh-220px)] max-w-[94vw] w-auto h-auto object-contain rounded-none shadow-2xl select-none will-change-transform"
                 :class="[
                     contentVisible ? 'opacity-100' : 'opacity-0',
                     zoomLevel > 1 ? (isDragging ? 'cursor-grabbing touch-none' : 'cursor-grab touch-none') : 'cursor-zoom-in'
                 ]"
                 :style="'transform: translate3d(' + panX + 'px, ' + panY + 'px, 0) scale(' + (contentVisible ? zoomLevel : 0.97) + '); transform-origin: center center; ' + (isDragging ? 'transition: none;' : 'transition: transform 200ms ease-out;')">
        </div>

        <!-- Bottom Wrapper: Memposisikan Zoom Controls dan Caption Bar Secara Independen -->
        <div class="absolute bottom-0 inset-x-0 z-30 pointer-events-none flex flex-col justify-end transition-opacity duration-200 ease-out"
             :class="contentVisible ? 'opacity-100' : 'opacity-0'">
            
            <!-- Floating Dark Glassmorphic Zoom Controls (Independen, Nyata Membiaskan Foto) -->
            <div class="w-full max-w-7xl mx-auto px-4 sm:px-8 flex justify-end sm:justify-center mb-2.5 sm:mb-3 pointer-events-none">
                <div class="pointer-events-auto flex items-center gap-1.5 p-1 rounded-lg bg-neutral-900/60 hover:bg-neutral-900/75 border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)] select-none"
                     style="-webkit-backdrop-filter: blur(24px) saturate(200%); backdrop-filter: blur(24px) saturate(200%);"
                     @click.stop>
                    
                    <!-- Zoom Out (-) -->
                    <button type="button" 
                            @click.stop="zoomOut()" 
                            :disabled="zoomLevel <= 1" 
                            title="Perkecil (-)"
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-white/90 hover:text-white bg-white/[0.08] hover:bg-white/[0.18] active:bg-white/25 border border-white/10 disabled:opacity-25 disabled:pointer-events-none transition-all duration-150 cursor-pointer">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </button>

                    <!-- Indicator / Reset Zoom (Desktop) -->
                    <button type="button" 
                            @click.stop="resetZoom()" 
                            title="Reset Ukuran (100%)"
                            class="hidden sm:flex px-2.5 h-7 sm:h-8 rounded-lg text-[11px] sm:text-xs font-mono font-medium text-white/90 hover:text-white bg-white/[0.08] hover:bg-white/[0.18] active:bg-white/25 border border-white/10 transition-all duration-150 items-center justify-center min-w-[44px] cursor-pointer">
                        <span x-text="Math.round(zoomLevel * 100) + '%'"></span>
                    </button>

                    <!-- Zoom In (+) -->
                    <button type="button" 
                            @click.stop="zoomIn()" 
                            :disabled="zoomLevel >= 3" 
                            title="Perbesar (+)"
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-white/90 hover:text-white bg-white/[0.08] hover:bg-white/[0.18] active:bg-white/25 border border-white/10 disabled:opacity-25 disabled:pointer-events-none transition-all duration-150 cursor-pointer">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Bottom: Information & Editorial Caption -->
            <div class="w-full border-t border-white/[0.08] bg-[#0D0F0E]/80 px-5 py-4 sm:px-8 sm:py-5 lg:px-12 pointer-events-auto"
                 style="-webkit-backdrop-filter: blur(20px) saturate(150%); backdrop-filter: blur(20px) saturate(150%);"
                 @click.stop>
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3.5 sm:gap-8">
                    
                    <!-- Left: Metadata, Title, and Description -->
                    <div class="min-w-0 flex-1 space-y-3">
                        <!-- Metadata: Category · Date (Level 3 Hierarchy) -->
                        <div class="flex items-center gap-2 sm:gap-2.5 text-neutral-400">
                            <span class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.1em] text-neutral-400" x-text="activeCategory"></span>
                            <span class="text-neutral-600 text-xs select-none">·</span>
                            <span class="text-xs sm:text-sm font-normal text-neutral-400" x-text="activeDate"></span>
                        </div>

                        <!-- Title: Primary Focal Point (Level 1 Hierarchy) -->
                        <h2 class="font-serif text-xl sm:text-2xl lg:text-[30px] font-medium sm:font-semibold text-white/95 leading-[1.18] tracking-[-0.015em] max-w-3xl lg:max-w-[70%]" x-text="activeTitle"></h2>

                        <!-- Description: Secondary Information (Level 2 Hierarchy) -->
                        <p class="text-sm sm:text-[15px] text-neutral-400 leading-relaxed font-normal max-w-2xl lg:max-w-3xl line-clamp-2 sm:line-clamp-3" 
                           x-show="activeCaption && activeCaption.trim() !== '' && activeCaption !== activeTitle" 
                           x-text="activeCaption"></p>
                    </div>

                    <!-- Right / Bottom: Editorial Text CTA (Level 4 Hierarchy) -->
                    <div class="shrink-0 flex items-center self-start sm:self-end pt-1 sm:pt-0" x-show="activeUrl">
                        <a :href="activeUrl" 
                           title="Buka artikel berita terkait"
                           class="group inline-flex items-center gap-1.5 text-sm sm:text-[15px] font-medium text-neutral-300 hover:text-emerald-400 transition-colors duration-200 py-0.5">
                            <span>Lihat berita</span>
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection
