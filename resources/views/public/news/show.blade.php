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

@push('styles')
<style>
    /* ========================================================================= */
    /* QUILL RICH TEXT CONTENT FORMATTING FOR NEWS ARTICLE                      */
    /* ========================================================================= */
    .article-body-content {
        color: #334155;
        font-size: 1.0625rem;
        line-height: 1.8;
        font-family: 'Public Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .article-body-content p {
        margin-bottom: 1.25rem;
    }
    .article-body-content p:last-child {
        margin-bottom: 0;
    }

    /* Headings */
    .article-body-content h1 {
        font-family: 'Public Sans', 'Inter', sans-serif;
        font-size: 1.875rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        letter-spacing: -0.02em;
    }
    .article-body-content h2 {
        font-family: 'Public Sans', 'Inter', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 1.75rem;
        margin-bottom: 0.5rem;
        line-height: 1.35;
        letter-spacing: -0.015em;
    }
    .article-body-content h3 {
        font-family: 'Public Sans', 'Inter', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    .article-body-content h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
    }
    .article-body-content h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }
    .article-body-content h6 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    /* Inline text formatting */
    .article-body-content strong,
    .article-body-content b {
        font-weight: 700;
        color: #0f172a;
    }
    .article-body-content em,
    .article-body-content i {
        font-style: italic;
    }
    .article-body-content u {
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .article-body-content s {
        text-decoration: line-through;
    }

    /* Lists */
    .article-body-content ol {
        list-style-type: decimal !important;
        padding-left: 1.75rem !important;
        margin-top: 0.75rem !important;
        margin-bottom: 1.25rem !important;
    }
    .article-body-content ul {
        list-style-type: disc !important;
        padding-left: 1.75rem !important;
        margin-top: 0.75rem !important;
        margin-bottom: 1.25rem !important;
    }
    .article-body-content li {
        margin-bottom: 0.5rem;
        line-height: 1.75;
    }
    .article-body-content ol > li::marker {
        font-weight: 700;
        color: #0A3D29;
    }
    .article-body-content ul > li::marker {
        color: #0A3D29;
    }

    /* Blockquote */
    .article-body-content blockquote {
        border-left: 3px solid #cbd5e1;
        background-color: #f8fafc;
        padding: 0.75rem 1.25rem;
        margin: 1.5rem 0;
        font-style: italic;
        border-radius: 0 0.5rem 0.5rem 0;
        color: #475569;
    }

    /* Links */
    .article-body-content a {
        color: #0A3D29;
        font-weight: 600;
        text-decoration: underline;
        text-underline-offset: 3px;
        transition: color 0.15s;
    }
    .article-body-content a:hover {
        color: #145C3B;
    }

    /* Images inside content */
    .article-body-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1.5rem auto;
        display: block;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    /* Code blocks */
    .article-body-content pre {
        background-color: #0f172a;
        color: #f8fafc;
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1.25rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }
    .article-body-content code {
        background-color: #f1f5f9;
        color: #0f172a;
        padding: 0.15rem 0.35rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }

    /* Quill Alignment Rules */
    .article-body-content .ql-align-center {
        text-align: center !important;
    }
    .article-body-content .ql-align-right {
        text-align: right !important;
    }
    .article-body-content .ql-align-justify {
        text-align: justify !important;
        text-justify: inter-word;
    }
    .article-body-content .ql-align-left {
        text-align: left !important;
    }

    /* Quill Indentation Rules */
    .article-body-content .ql-indent-1 { padding-left: 2rem !important; }
    .article-body-content .ql-indent-2 { padding-left: 4rem !important; }
    .article-body-content .ql-indent-3 { padding-left: 6rem !important; }
    .article-body-content .ql-indent-4 { padding-left: 8rem !important; }
    .article-body-content .ql-indent-5 { padding-left: 10rem !important; }
    .article-body-content .ql-indent-6 { padding-left: 12rem !important; }
    .article-body-content .ql-indent-7 { padding-left: 14rem !important; }
    .article-body-content .ql-indent-8 { padding-left: 16rem !important; }
</style>
@endpush

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
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden shadow-xs">
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
                        <span class="text-slate-600 font-medium text-xs">
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

                <!-- 2. Featured Image Card & Caption -->
                <figure class="space-y-2">
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
                    @if(!empty($news->image_caption))
                        <figcaption class="text-xs sm:text-[13px] text-slate-500 italic text-center px-3 leading-relaxed flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $news->image_caption }}</span>
                        </figcaption>
                    @endif
                </figure>

                <!-- 3. Article Lead / Excerpt (Clean Editorial Flow) -->
                @if($news->excerpt)
                    <p class="text-base sm:text-lg text-slate-600 font-medium leading-relaxed">
                        {{ $news->excerpt }}
                    </p>
                @endif

                <!-- 4. Article Body Content (Rich Text Formatting from Editor) -->
                <div class="article-body-content pt-1">
                    @if(strip_tags($news->content) !== $news->content)
                        {!! $news->content !!}
                    @else
                        {!! nl2br(e($news->content)) !!}
                    @endif
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
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-emerald-600 hover:text-white text-slate-600 flex items-center justify-center border border-slate-200/80 transition-all active:scale-95 shadow-xs" 
                           title="Bagikan ke WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.276-.1-.477-.15-.678.15-.201.3-.777.978-.953 1.179-.176.2-.351.226-.652.075-.301-.15-1.272-.469-2.423-1.496-.896-.799-1.5-1.786-1.676-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.176.201-.301.301-.502.101-.2.05-.376-.025-.527-.075-.15-.678-1.634-.929-2.238-.244-.588-.493-.509-.678-.518-.176-.009-.376-.011-.577-.011-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.512 0 1.482 1.079 2.912 1.23 3.113.15.2 2.124 3.243 5.145 4.548.719.311 1.28.497 1.718.636.722.23 1.379.197 1.9-.12.58-.354 1.78-1.066 2.03-1.758.251-.692.251-1.285.176-1.41-.075-.125-.276-.2-.577-.35zM12.004 2C6.48 2 2 6.48 2 12.004c0 1.91.536 3.693 1.464 5.216L2.1 22l4.908-1.328A9.957 9.957 0 0012.004 22C17.528 22 22 17.528 22 12.004 22 6.48 17.528 2 12.004 2zm0 18.292c-1.656 0-3.19-.504-4.475-1.368l-.321-.214-3.32.898.892-3.238-.235-.349A8.258 8.258 0 013.712 12c0-4.572 3.72-8.292 8.292-8.292 4.572 0 8.292 3.72 8.292 8.292 0 4.572-3.72 8.292-8.292 8.292z"/>
                            </svg>
                        </a>

                        <!-- Facebook -->
                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href)" 
                           target="_blank" rel="noopener" 
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-600 flex items-center justify-center border border-slate-200/80 transition-all active:scale-95 shadow-xs" 
                           title="Bagikan ke Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        <!-- Salin Tautan (Copy Link with inline feedback) -->
                        <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2500)" 
                                class="inline-flex items-center gap-1.5 px-3 h-9 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200/80 transition-all active:scale-95 cursor-pointer shadow-xs"
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
                                            <span class="font-medium text-[11px] text-slate-500">
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
