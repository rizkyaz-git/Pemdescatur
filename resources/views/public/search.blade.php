@extends('layouts.public')

@section('title', 'Pencarian - Web Profile Desa Catur Sambi Boyolali')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-12">

    <!-- Minimalist Search Header -->
    <div class="space-y-6 max-w-3xl text-left">
        <div class="space-y-2">
            <x-breadcrumbs :items="[
                ['label' => 'BERANDA', 'url' => route('home')],
                ['label' => 'Pencarian']
            ]" />
            <h1 class="font-serif text-3xl sm:text-4xl text-slate-900 font-bold tracking-tight">
                Cari Data & Layanan Desa
            </h1>
            <p class="text-sm font-light text-slate-500 leading-relaxed">
                Telusuri warta berita, struktur aparatur desa, arsip layanan surat, pengaduan, galeri kegiatan, dan program Desa Catur.
            </p>
        </div>

        <!-- Clean Form -->
        <form action="{{ url('/pencarian') }}" method="GET" class="relative max-w-2xl">
            <div class="relative flex items-center">
                <input type="text" 
                       name="q" 
                       value="{{ $query }}" 
                       placeholder="Ketik kata kunci pencarian..." 
                       class="w-full pl-11 pr-24 py-3.5 rounded-xl bg-white text-slate-900 text-sm font-normal border border-slate-200 focus:border-[#0A3D29] focus:outline-none focus:ring-1 focus:ring-[#0A3D29] transition-all placeholder:text-slate-400 shadow-2xs">
                
                <svg class="w-4 h-4 text-slate-400 absolute left-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <button type="submit" class="absolute right-1.5 bg-[#0A3D29] hover:bg-[#145C3B] text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Search Results Section -->
    <div class="space-y-6 pt-2">
        @if(!empty($query))
            <div class="flex items-baseline justify-between border-b border-slate-100 pb-4">
                <div class="space-x-1.5">
                    <span class="text-sm font-light text-slate-500">Hasil pencarian untuk</span>
                    <span class="font-serif font-bold text-slate-900 text-base sm:text-lg">“{{ $query }}”</span>
                </div>
                <span class="text-xs font-light text-slate-400">
                    {{ $total }} hasil
                </span>
            </div>
        @endif

        @if(!empty($query) && count($results) > 0)
            <div class="divide-y divide-slate-100">
                @foreach($results as $item)
                    <article class="py-6 first:pt-0 last:pb-0 group">
                        <a href="{{ $item['url'] }}" class="block space-y-2">
                            <!-- Category / Type Metadata -->
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-semibold tracking-wider uppercase text-[#0A3D29]">
                                    {{ $item['badge'] ?? $item['type'] }}
                                </span>
                                <span class="text-slate-300 text-xs font-light">/</span>
                                <span class="text-[11px] font-light text-slate-400 tracking-wide">
                                    {{ $item['category'] }}
                                </span>
                            </div>

                            <!-- Title (Bold Serif Contrast) -->
                            <h2 class="font-serif text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#0A3D29] transition-colors leading-snug">
                                {{ $item['title'] }}
                            </h2>

                            <!-- Snippet (Light Sans Body) -->
                            <p class="text-xs sm:text-sm font-light text-slate-600 leading-relaxed line-clamp-2 max-w-3xl">
                                {{ $item['snippet'] }}
                            </p>

                            <!-- Subtle Action Indicator -->
                            <div class="pt-1 flex items-center gap-1 text-xs font-medium text-slate-400 group-hover:text-[#0A3D29] transition-colors">
                                <span>Buka halaman</span>
                                <span class="transition-transform group-hover:translate-x-0.5">→</span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @elseif(!empty($query))
            <!-- Minimalist Empty State -->
            <div class="py-16 text-center max-w-md mx-auto space-y-3">
                <h3 class="font-serif text-xl font-bold text-slate-900">Tidak ada hasil ditemukan</h3>
                <p class="text-xs sm:text-sm font-light text-slate-500 leading-relaxed">
                    Tidak ditemukan informasi yang sesuai dengan kata kunci <span class="font-medium text-slate-800">“{{ $query }}”</span>. Silakan periksa kembali ejaan atau gunakan kata kunci umum lainnya.
                </p>
                <div class="pt-2">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0A3D29] hover:underline">
                        <span>← Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Minimal Initial State -->
            <div class="py-12 border-t border-slate-100 text-center">
                <p class="text-xs sm:text-sm font-light text-slate-400">
                    Ketik kata kunci pada kolom di atas untuk memulai penelusuran informasi desa.
                </p>
            </div>
        @endif
    </div>

</div>

@endsection
