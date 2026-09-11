@extends('layouts.public')

@section('title', 'Struktur Organisasi Perangkat Desa - Web Profile Desa Catur')

@section('content')

    {{-- =========================================================== --}}
    {{-- 1. TOP HEADER (Rata Kiri dengan Navigasi Breadcrumb)        --}}
    {{-- =========================================================== --}}
    <header class="bg-white pt-8 sm:pt-10 pb-4 sm:pb-6 text-left max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
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
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">

            @if(isset($officials) && $officials->count() > 0)
            <div x-data="{ isReady: false }" x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 120); })" class="relative">

                <!-- 1. SKELETON SCREEN LOADING STATE (Mobile & Desktop 1:1 Match) -->
                <div x-show="!isReady" aria-busy="true">
                    <!-- Mobile Skeletons (2 Cols) -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 md:hidden">
                        @for($i = 0; $i < min(6, $officials->count()); $i++)
                            <x-skeleton.official-card />
                        @endfor
                    </div>

                    <!-- Desktop Skeletons -->
                    <div class="hidden md:block space-y-6 lg:space-y-8">
                        <!-- Head Official Skeleton -->
                        <div class="bg-white rounded-xl p-5 lg:p-7 border border-slate-200/90 shadow-xs flex flex-row items-center gap-6 lg:gap-8">
                            <div class="w-40 lg:w-48 aspect-[3/4] rounded-lg skeleton-shimmer shrink-0"></div>
                            <div class="space-y-3 flex-1 min-w-0">
                                <div class="w-28 h-3.5 rounded-sm skeleton-shimmer"></div>
                                <div class="w-72 h-8 rounded skeleton-shimmer"></div>
                            </div>
                        </div>

                        <!-- 4-Col Grid Skeletons -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                            @for($i = 0; $i < min(8, max(4, $otherOfficials->count())); $i++)
                                <x-skeleton.official-card class="bg-white p-3.5 sm:p-4" />
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- 2. REAL CONTENT (Progressively Revealed with Zero Layout Shift) -->
                <div x-show="isReady" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">

                    <!-- A. TAMPILAN MOBILE (Layar < 768px) -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 md:hidden">
                        @foreach($officials as $official)
                            <div
                                class="bg-slate-50/80 rounded-xl p-2.5 sm:p-3.5 border border-slate-200/90 shadow-xs flex flex-col justify-between group hover:border-[#0A3D29]/40 hover:bg-white transition-all duration-200">
                                <div>
                                    <!-- Foto dengan rasio aspek 3:4 -->
                                    <div class="relative rounded-lg overflow-hidden aspect-[3/4] w-full bg-slate-100 border border-slate-200/70 mb-2.5 flex items-center justify-center shadow-xs"
                                        x-data="{ loaded: false, error: false }"
                                        x-init="if ($refs.mImg && $refs.mImg.complete) { loaded = true; }">
                                        @if(!empty($official->photo_path))
                                            <div x-show="!loaded && !error"
                                                class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                            <img x-ref="mImg" src="{{ asset('storage/' . $official->photo_path) }}"
                                                alt="{{ $official->name }}" loading="lazy" x-on:load="loaded = true;"
                                                x-on:error="error = true;"
                                                class="relative z-10 w-full h-full object-cover object-top transition-opacity duration-300"
                                                :class="(loaded && !error) ? 'opacity-100' : 'opacity-0'">
                                            <div x-show="error"
                                                class="absolute inset-0 flex items-center justify-center bg-slate-100 text-[#145C3B]/60">
                                                <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-[#145C3B]/60">
                                                <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Tulisan Jabatan -->
                                    <p
                                        class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
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

                    <!-- B. TAMPILAN DESKTOP (Layar >= 768px) -->
                    <div class="hidden md:block space-y-6 lg:space-y-8">
                        <!-- 1. Kartu Sekretaris Desa di Desktop -->
                        @if($headOfficial)
                            @php
                                $headPhoto = $headOfficial->photo_path ?? null;
                                $headName = $headOfficial->name ?? 'HANANTO ADI KUSUMO, S.AP';
                                $headPosition = $headOfficial->position ?? 'SEKRETARIS DESA';
                            @endphp

                            <div
                                class="bg-white rounded-xl p-5 lg:p-7 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-slate-50/50 shadow-xs hover:shadow-md transition-all duration-300 flex flex-row items-center gap-6 lg:gap-8 group">
                                <!-- Foto Profil Sekretaris Desa (Rasio Aspek 3:4) -->
                                <div class="relative w-40 lg:w-48 aspect-[3/4] rounded-lg overflow-hidden bg-slate-100 border border-slate-200/80 shrink-0 shadow-xs flex items-center justify-center"
                                    x-data="{ loaded: false, error: false }"
                                    x-init="if ($refs.hImg && $refs.hImg.complete) { loaded = true; }">
                                    @if(!empty($headPhoto))
                                        <div x-show="!loaded && !error"
                                            class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                        <img x-ref="hImg" src="{{ asset('storage/' . $headPhoto) }}" alt="{{ $headName }}" loading="lazy"
                                            x-on:load="loaded = true;" x-on:error="error = true;"
                                            class="relative z-10 w-full h-full object-cover object-top group-hover:scale-105 transition-all duration-500"
                                            :class="(loaded && !error) ? 'opacity-100' : 'opacity-0'">
                                        <div x-show="error"
                                            class="absolute inset-0 flex items-center justify-center bg-slate-100 text-[#145C3B]/60">
                                            <svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-[#145C3B]/60">
                                            <svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Detail Informasi Sekretaris Desa -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-[#0A3D29] mb-1">
                                        {{ $headPosition }}
                                    </p>
                                    <h2
                                        class="font-['Public_Sans',sans-serif] text-2xl lg:text-3xl font-extrabold text-slate-800 leading-snug group-hover:text-[#0A3D29] transition-colors">
                                        {{ $headName }}
                                    </h2>
                                </div>
                            </div>
                        @endif

                        <!-- 2. Grid Perangkat Desa Lainnya di Desktop (4 Kolom) -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                            @foreach($otherOfficials as $official)
                                <div
                                    class="bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-slate-50/50 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                                    <div>
                                        <!-- Photo Container (Rasio Aspek 3:4) -->
                                        <div class="relative rounded-lg overflow-hidden aspect-[3/4] w-full bg-slate-100 border border-slate-200/70 mb-3.5 flex items-center justify-center shadow-xs"
                                            x-data="{ loaded: false, error: false }"
                                            x-init="if ($refs.dImg && $refs.dImg.complete) { loaded = true; }">
                                            @if(!empty($official->photo_path))
                                                <div x-show="!loaded && !error"
                                                    class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
                                                <img x-ref="dImg" src="{{ asset('storage/' . $official->photo_path) }}"
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
            </div>

            @endif

        </div>
    </div>

@endsection