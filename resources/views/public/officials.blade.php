@extends('layouts.public')

@section('title', 'Struktur Organisasi Perangkat Desa Catur')

@section('content')

    {{-- =========================================================== --}}
    {{-- 1. TOP HEADER (Rata Kiri dengan Navigasi Breadcrumb)        --}}
    {{-- =========================================================== --}}
    <header class="bg-white pt-6 sm:pt-10 pb-4 sm:pb-6 text-left max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" style="margin: 0 auto;">
        <x-breadcrumbs :items="[
            ['label' => 'BERANDA', 'url' => route('home')],
            ['label' => 'Pemerintahan']
        ]" />
        <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#20332A] tracking-tight leading-tight">
            Struktur Organisasi Perangkat Desa
        </h1>
    </header>

    <!-- Main Content Area (Latar Standar Putih Datar) -->
    <div class="bg-white pt-2 pb-12 sm:pt-4 sm:pb-18">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" style="margin: 0 auto;">

            @if(isset($officials) && $officials->count() > 0)
            <div x-data="{ isReady: false }" x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 120); })" class="relative">

                <!-- 1. SKELETON SCREEN LOADING STATE (Responsive Grid) -->
                <div x-show="!isReady" aria-busy="true">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                        @for($i = 0; $i < min(8, max(4, $officials->count())); $i++)
                            <x-skeleton.official-card />
                        @endfor
                    </div>
                </div>

                <!-- 2. REAL CONTENT (Progressively Revealed with Zero Layout Shift) -->
                <div x-show="isReady" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">

                    <!-- Grid Struktur Organisasi Perangkat Desa (Semua Kartu Seragam) -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                        @foreach($officials as $official)
                            <div
                                class="bg-white rounded-lg p-3 sm:p-4 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-slate-50/50 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                                <div>
                                    <!-- Photo Container (Rasio Aspek 3:4) -->
                                    <div class="relative rounded-lg overflow-hidden aspect-[3/4] w-full bg-slate-100 border border-slate-200/70 mb-3 flex items-center justify-center shadow-xs"
                                        x-data="{ loaded: false, error: false }"
                                        x-init="if ($refs.offImg && $refs.offImg.complete) { loaded = true; }">
                                        @if(!empty($official->photo_path))
                                            <div x-show="!loaded && !error"
                                                class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                            <img x-ref="offImg" src="{{ asset('storage/' . $official->photo_path) }}"
                                                alt="{{ $official->name }}" loading="lazy" x-on:load="loaded = true;"
                                                x-on:error="error = true;"
                                                class="relative z-10 w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                                                :class="(loaded && !error) ? 'opacity-100' : 'opacity-0'">
                                            <div x-show="error"
                                                class="absolute inset-0 flex items-center justify-center bg-slate-100 text-[#145C3B]/60">
                                                <svg class="w-10 h-10 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-[#145C3B]/60">
                                                <svg class="w-10 h-10 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Tulisan Jabatan -->
                                    <p
                                        class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                                        {{ $official->position }}
                                    </p>

                                    <!-- Nama -->
                                    <h3
                                        class="font-['Public_Sans',sans-serif] text-xs sm:text-sm font-extrabold text-slate-800 leading-snug line-clamp-2 group-hover:text-[#0A3D29] transition-colors">
                                        {{ $official->name }}
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>

@endsection