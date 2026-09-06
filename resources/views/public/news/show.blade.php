@extends('layouts.public')

@section('title', $news->title . ' - Web Profile Desa Catur')

@section('content')

@php
    $defaultImages = [
        'images/sawah_irigasi.png',
        'images/umbul_siraman.png',
        'images/coffee_plantation.png',
        'images/masjid_wonokusumo.png',
        'images/hero_landscape.png',
        'images/culture_pura.png',
    ];
    $mainImageSrc = $news->image_path 
        ? asset('storage/' . $news->image_path) 
        : asset($defaultImages[$news->id % count($defaultImages)]);
@endphp

<!-- Main Container (Clean White Canvas) -->
<div class="bg-white min-h-screen py-6 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- 2-Column Grid (Main Article 8 cols + Sidebar 4 cols) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 lg:items-start"
              x-data="{ 
                  copied: false,
                  likesCount: {{ $news->likes_count ?? 0 }},
                  isLiked: {{ session()->has('liked_news_' . $news->id) ? 'true' : 'false' }},
                  async toggleLike() {
                      try {
                          const response = await fetch('{{ route('public.news.like', $news->slug) }}', {
                              method: 'POST',
                              headers: {
                                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                  'Content-Type': 'application/json',
                                  'Accept': 'application/json'
                              }
                          });
                          const data = await response.json();
                          if (data.success) {
                              this.likesCount = data.likes_count;
                              this.isLiked = data.is_liked;
                          }
                      } catch (e) {
                          console.error(e);
                      }
                  }
              }">

            <!-- ================= LEFT / MAIN ARTICLE COLUMN (col-span-8) ================= -->
            <article class="lg:col-span-8 space-y-6">

                <!-- 1. Header Title & Meta Info Section -->
                <div class="space-y-4">
                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight tracking-tight">
                        {{ $news->title }}
                    </h1>

                    <!-- Author & Meta Info Row (Avatar, Name, Category, Date, Views) -->
                    <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-500 font-medium flex-wrap">
                        <!-- Profile Avatar & Name -->
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden shadow-2xs">
                                @if(file_exists(public_path('images/logo_catur.png')))
                                    <img src="{{ asset('images/logo_catur.png') }}" alt="Logo Pemdes Catur" class="w-full h-full object-contain p-0.5 bg-white">
                                @else
                                    <span>P</span>
                                @endif
                            </div>
                            <span class="font-bold text-slate-900">Admin Pemdes Catur</span>
                        </div>

                        <span class="text-slate-300">•</span>

                        <!-- Category -->
                        <span class="text-[#0A3D29] font-semibold bg-[#EAF1E8] px-2.5 py-0.5 rounded-md text-xs">
                            {{ $news->category }}
                        </span>

                        <span class="text-slate-300">•</span>

                        <!-- Published Date -->
                        <span>{{ $news->published_at ? $news->published_at->translatedFormat('d F Y') : $news->created_at->translatedFormat('d F Y') }}</span>

                        <span class="text-slate-300">•</span>

                        <!-- Views Counter -->
                        <span class="flex items-center gap-1 text-slate-500">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>{{ number_format($news->views_count ?? 0) }} dilihat</span>
                        </span>
                    </div>
                </div>

                <!-- 2. Featured Image Card -->
                <div class="rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 shadow-xs relative"
                     x-data="{ loaded: false }"
                     x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                    <img x-ref="img"
                         src="{{ $mainImageSrc }}" 
                         alt="{{ $news->title }}" 
                         @load="loaded = true;"
                         class="w-full h-auto max-h-[460px] object-cover transition-opacity duration-300"
                         :class="loaded ? 'opacity-100' : 'opacity-0'">
                </div>

                <!-- 3. Article Lead / Excerpt (Clean Editorial Flow) -->
                @if($news->excerpt)
                    <p class="text-base sm:text-lg text-slate-600 font-medium leading-relaxed">
                        {{ $news->excerpt }}
                    </p>
                @endif

                <!-- 4. Article Body Content -->
                <div class="prose prose-slate max-w-none text-slate-800 text-base sm:text-lg leading-relaxed space-y-4 pt-1">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <!-- 5. Bottom Action Bar (Like & Streamlined Social Share) -->
                <div class="pt-6 mt-8 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <!-- Interactive Like Button -->
                    <button @click="toggleLike()" 
                            class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl border transition-all cursor-pointer active:scale-95 w-fit"
                            :class="isLiked ? 'bg-[#0A3D29] text-white border-[#0A3D29] shadow-xs' : 'bg-slate-50 text-slate-700 border-slate-200/80 hover:bg-slate-100'">
                        <svg class="w-4 h-4 transition-transform" :class="isLiked ? 'fill-current text-white scale-110' : 'fill-none stroke-current text-slate-600'" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 001.99-1.68l1.54-9A2 2 0 0017.72 9H14zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/>
                        </svg>
                        <span><span x-text="likesCount">{{ number_format($news->likes_count ?? 0) }}</span> Menyukai</span>
                    </button>

                    <!-- Streamlined Social Share Actions -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-slate-400 mr-1">Bagikan:</span>
                        
                        <!-- WhatsApp -->
                        <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('{{ $news->title }} ' + window.location.href)" 
                           target="_blank" rel="noopener" 
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-emerald-600 hover:text-white text-slate-600 flex items-center justify-center border border-slate-200/80 transition-all active:scale-95 shadow-2xs" 
                           title="Bagikan ke WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                            </svg>
                        </a>

                        <!-- Facebook -->
                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href)" 
                           target="_blank" rel="noopener" 
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-600 flex items-center justify-center border border-slate-200/80 transition-all active:scale-95 shadow-2xs" 
                           title="Bagikan ke Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        <!-- Salin Tautan (Copy Link with inline feedback) -->
                        <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2500)" 
                                class="inline-flex items-center gap-1.5 px-3 h-9 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200/80 transition-all active:scale-95 cursor-pointer shadow-2xs"
                                title="Salin Tautan">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <svg x-show="copied" class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'">Salin Tautan</span>
                        </button>
                    </div>
                </div>

            </article>


            <!-- ================= RIGHT / SIDEBAR COLUMN (col-span-4) ================= -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24 lg:self-start lg:pl-2">
                
                <!-- Related Articles Block -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <h3 class="font-bold text-base text-slate-900 tracking-tight">
                            Berita Terkait
                        </h3>
                        <a href="{{ route('public.news.index') }}" class="text-xs font-semibold text-[#0A3D29] hover:underline">
                            Lihat semua →
                        </a>
                    </div>

                    @if(isset($recentNews) && $recentNews->count() > 0)
                        <div class="space-y-3 pt-1">
                            @foreach($recentNews as $item)
                                @php
                                    $itemImageSrc = $item->image_path 
                                        ? asset('storage/' . $item->image_path) 
                                        : asset($defaultImages[$item->id % count($defaultImages)]);
                                @endphp
                                <a href="{{ route('public.news.show', $item->slug) }}" class="group flex gap-3.5 items-start p-2 -mx-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    
                                    <!-- Image Thumbnail -->
                                    <div class="w-24 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200/70 shrink-0 relative">
                                        <img src="{{ $itemImageSrc }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>

                                    <!-- Content Info -->
                                    <div class="space-y-1 min-w-0 flex-1">
                                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-[#0A3D29] transition-colors line-clamp-2 leading-snug">
                                            {{ $item->title }}
                                        </h4>
                                        <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium pt-0.5">
                                            <span class="uppercase tracking-wider font-semibold text-[10px] text-[#0A3D29]">
                                                {{ $item->category }}
                                            </span>
                                            <span>•</span>
                                            <span>{{ number_format($item->views_count ?? 0) }} dilihat</span>
                                        </div>
                                    </div>

                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">Belum ada berita terkait lainnya.</p>
                    @endif
                </div>

            </aside>

        </div>

    </div>
</div>

@endsection
