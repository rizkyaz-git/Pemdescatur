@extends('layouts.public')

@section('title', 'Berita & Pengumuman - Website Pemdes Catur')

@section('content')

    <!-- Main Editorial Canvas -->
    <div class="bg-white min-h-screen py-4 sm:py-7">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-5">

            <!-- 1. Header: Breadcrumb & Title -->
            <header class="space-y-1 text-left">
                <x-breadcrumbs :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita & Pengumuman']
        ]" />
                <div>
                    <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[#0A3D29] tracking-tight leading-tight">
                        Berita & Pengumuman
                    </h1>
                </div>
            </header>

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
                    $isFiltered = request('category') || request('q');
                    $groupedByCategory = $newsList->getCollection()->groupBy('category');
                @endphp

                <div x-data="{ isReady: false }" x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 50); })"
                    class="space-y-12 sm:space-y-14">

                    <!-- Skeleton Loading State -->
                    <div x-show="!isReady" aria-busy="true" class="space-y-10">
                        @if(!$isFiltered && request('page', 1) == 1)
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-7 items-stretch">
                                <div class="lg:col-span-3 space-y-3">
                                    <div class="w-28 h-5 rounded skeleton-shimmer mb-3"></div>
                                    @for($i = 0; $i < 4; $i++)
                                        <div class="flex gap-2.5 py-2">
                                            <div class="w-14 h-14 rounded-md skeleton-shimmer shrink-0"></div>
                                            <div class="flex-1 space-y-1.5">
                                                <div class="w-14 h-2.5 rounded skeleton-shimmer"></div>
                                                <div class="w-full h-3.5 rounded skeleton-shimmer"></div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="lg:col-span-6 space-y-3">
                                    <div class="w-full aspect-[16/10] rounded-lg skeleton-shimmer"></div>
                                    <div class="w-24 h-4 rounded skeleton-shimmer"></div>
                                    <div class="w-3/4 h-6 rounded skeleton-shimmer"></div>
                                </div>
                                <div class="lg:col-span-3">
                                    <div class="w-full h-64 sm:h-80 rounded-lg skeleton-shimmer"></div>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div class="w-36 h-5 rounded skeleton-shimmer"></div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6">
                                @for($i = 0; $i < 4; $i++)
                                    @if($i === 0)
                                        <div class="space-y-2">
                                            <div class="w-full aspect-[16/10] rounded-lg skeleton-shimmer"></div>
                                            <div class="w-16 h-3 rounded skeleton-shimmer"></div>
                                            <div class="w-full h-4 rounded skeleton-shimmer"></div>
                                        </div>
                                    @else
                                        <div class="flex items-start gap-3 sm:block sm:space-y-2 border-t border-slate-100 pt-3 sm:border-t-0 sm:pt-0">
                                            <div class="w-16 h-16 sm:w-full sm:aspect-[16/10] rounded-md sm:rounded-lg skeleton-shimmer shrink-0 sm:mb-2.5"></div>
                                            <div class="flex-1 space-y-1.5 sm:space-y-2">
                                                <div class="w-16 h-3 rounded skeleton-shimmer"></div>
                                                <div class="w-full h-4 rounded skeleton-shimmer"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Real Editorial Content -->
                    <div x-show="isReady" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="space-y-12 sm:space-y-14">

                        {{-- 3. HERO 3-KOLOM EDITORIAL (Hanya pada Beranda Berita Halaman 1 tanpa filter) --}}
                        @if(!$isFiltered && request('page', 1) == 1)
                            <section aria-label="Hero Berita dan Cuaca Desa Catur"
                                class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-7 items-stretch">

                                <!-- KOLOM 1: KABAR TERKINI (SISI KIRI ≈ 25%) -->
                                <div class="lg:col-span-3 order-2 lg:order-1 flex flex-col justify-between text-left">
                                    <div>
                                        <div class="border-b border-slate-100 pb-2.5 mb-2">
                                            <h2 class="font-serif text-lg font-bold text-slate-900 tracking-tight">
                                                Kabar Terkini
                                            </h2>
                                        </div>

                                        @php
                                            // Ambil 3-4 artikel selain artikel berita utama
                                            $kabarItems = $newsList->getCollection();
                                            if (isset($latestNews) && $latestNews) {
                                                $kabarItems = $kabarItems->where('id', '!=', $latestNews->id);
                                            }
                                            $kabarItems = $kabarItems->take(4);
                                        @endphp

                                        <div class="divide-y divide-slate-100">
                                            @foreach($kabarItems as $kIndex => $item)
                                                @php
                                                    $kImgExists = $item->image_path && (file_exists(public_path('storage/' . $item->image_path)) || file_exists(storage_path('app/public/' . $item->image_path)));
                                                    $kFallback = asset($defaultImages[($kIndex + 1) % count($defaultImages)]);
                                                    $kImg = $kImgExists ? asset('storage/' . $item->image_path) : $kFallback;
                                                    $kDate = $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y');
                                                @endphp
                                                <article class="group py-3 first:pt-1 last:pb-0">
                                                    <a href="{{ route('public.news.show', $item->slug) }}"
                                                        class="flex items-start gap-3 focus:outline-none">
                                                        <div
                                                            class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 rounded-md overflow-hidden bg-slate-100">
                                                            <img src="{{ $kImg }}" alt="{{ $item->title }}"
                                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                        </div>
                                                        <div class="flex-1 min-w-0 space-y-0.5">
                                                            <span
                                                                class="text-[10px] font-semibold text-[#0A3D29] uppercase tracking-wider block">
                                                                {{ $item->category }}
                                                            </span>
                                                            <h3
                                                                class="font-serif text-xs sm:text-sm font-semibold text-slate-800 group-hover:text-[#0A3D29] leading-snug line-clamp-2 transition-colors">
                                                                {{ $item->title }}
                                                            </h3>
                                                            <p class="text-[11px] text-slate-400">
                                                                {{ $kDate }}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </article>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- KOLOM 2: BERITA UTAMA (TENGAH ≈ 50% - UKURAN MENGIKUTI 4 DAFTAR KIRI) -->
                                <div class="lg:col-span-6 order-1 lg:order-2 text-left flex flex-col justify-between h-full">
                                    @if(isset($latestNews) && $latestNews)
                                        @php
                                            $lImgExists = $latestNews->image_path && (file_exists(public_path('storage/' . $latestNews->image_path)) || file_exists(storage_path('app/public/' . $latestNews->image_path)));
                                            $lFallback = asset($defaultImages[0]);
                                            $lImg = $lImgExists ? asset('storage/' . $latestNews->image_path) : $lFallback;
                                            $lDate = $latestNews->published_at ? $latestNews->published_at->format('d M Y') : $latestNews->created_at->format('d M Y');
                                        @endphp

                                        <article class="group block h-full flex flex-col justify-between">
                                            <a href="{{ route('public.news.show', $latestNews->slug) }}"
                                                class="block h-full flex flex-col justify-between focus:outline-none">
                                                <!-- Image Utama: diselaraskan agar total tinggi sejajar dengan 4 daftar kiri -->
                                                <div class="relative w-full h-44 sm:h-48 lg:h-52 overflow-hidden rounded-lg bg-slate-100 mb-3 shrink-0">
                                                    <img src="{{ $lImg }}" alt="{{ $latestNews->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500">
                                                </div>

                                                <!-- Metadata & Judul Editorial -->
                                                <div class="space-y-2 flex-1 flex flex-col justify-between pt-1">
                                                    <div class="space-y-1.5">
                                                        <span class="text-[11px] font-semibold text-[#0A3D29] tracking-wider uppercase inline-block">
                                                            {{ $latestNews->category ?: 'Berita Utama' }}
                                                        </span>
                                                        <h2 class="font-serif text-xl sm:text-2xl lg:text-[24px] xl:text-[26px] font-bold text-slate-900 group-hover:text-[#0A3D29] leading-snug transition-colors line-clamp-3">
                                                            {{ $latestNews->title }}
                                                        </h2>
                                                        @if($latestNews->excerpt)
                                                            <p class="text-xs sm:text-sm text-slate-600 line-clamp-2 leading-relaxed pt-0.5">
                                                                {{ $latestNews->excerpt }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center gap-2.5 text-xs text-slate-400 pt-2 border-t border-slate-50">
                                                        <span>{{ $lDate }}</span>
                                                        @if($latestNews->views_count)
                                                            <span>•</span>
                                                            <span>{{ number_format($latestNews->views_count) }} views</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </article>
                                    @endif
                                </div>

                                <!-- KOLOM 3: WEATHER DESA CATUR (SISI KANAN ≈ 25% - MENGIKUTI TINGGI HERO) -->
                                <div class="lg:col-span-3 order-3 lg:order-3 flex flex-col justify-between h-full">
                                    @include('public.news.partials.weather-card', ['weather' => $weather ?? null])
                                </div>

                            </section>
                        @endif

                        {{-- 4. KONDISI TAMPILAN: JIKA SEDANG DIFILTER (Kategori atau Pencarian) --}}
                        @if($isFiltered)
                            <section class="space-y-6 text-left">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 pb-3">
                                    <div class="space-y-1">
                                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                                            @if(request('category') && request('q'))
                                                Kategori: {{ request('category') }} & Pencarian: "{{ request('q') }}"
                                            @elseif(request('category'))
                                                Kategori: {{ request('category') }}
                                            @elseif(request('q'))
                                                Hasil Pencarian: "{{ request('q') }}"
                                            @endif
                                        </h2>
                                        <p class="text-xs text-slate-400 font-medium">
                                            Menampilkan {{ $newsList->total() }} berita ditemukan
                                        </p>
                                    </div>

                                    <a href="{{ route('public.news.index') }}"
                                        class="inline-flex items-center gap-1 text-xs font-semibold text-[#0A3D29] hover:text-[#062c1d] transition-colors">
                                        <span>Tampilkan Semua Berita</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>

                                <!-- Grid Katalog Berita Paginated -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                    @foreach($newsList as $cIndex => $item)
                                        @php
                                            $cImgExists = $item->image_path && (file_exists(public_path('storage/' . $item->image_path)) || file_exists(storage_path('app/public/' . $item->image_path)));
                                            $cFallback = asset($defaultImages[($cIndex + 1) % count($defaultImages)]);
                                            $cImg = $cImgExists ? asset('storage/' . $item->image_path) : $cFallback;
                                            $cDate = $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y');
                                        @endphp
                                        <article class="group block text-left">
                                            <a href="{{ route('public.news.show', $item->slug) }}" class="block focus:outline-none">
                                                <div
                                                    class="relative w-full aspect-[16/10] overflow-hidden rounded-lg bg-slate-100 mb-2.5">
                                                    <img src="{{ $cImg }}" alt="{{ $item->title }}" loading="lazy"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                </div>
                                                <div class="space-y-1">
                                                    <span
                                                        class="text-[10px] font-semibold text-[#0A3D29] uppercase tracking-wider block">
                                                        {{ $item->category }}
                                                    </span>
                                                    <h3
                                                        class="font-serif text-sm sm:text-[15px] font-bold text-slate-900 group-hover:text-[#0A3D29] leading-snug line-clamp-2 transition-colors">
                                                        {{ $item->title }}
                                                    </h3>
                                                    <p class="text-[11px] text-slate-400">
                                                        {{ $cDate }}
                                                    </p>
                                                </div>
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </section>

                            {{-- 5. KONDISI DEFAULT: LANGSUNG KE SECTION KATEGORI (SETELAH HERO, TANPA SECTION TAMBAHAN) --}}
                        @else
                            <div class="space-y-12 sm:space-y-14 pt-2 sm:pt-4">
                                @foreach($groupedByCategory as $categoryName => $articles)
                                    <section class="space-y-4 text-left">
                                        <!-- Category Row Header -->
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                            <h2 class="font-serif text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                                                {{ $categoryName ?: 'Berita Terkini' }}
                                            </h2>
                                            @if($categoryName)
                                                <a href="{{ route('public.news.index', ['category' => $categoryName]) }}"
                                                    class="text-xs font-semibold text-[#0A3D29] hover:text-[#062c1d] flex items-center gap-1 group">
                                                    <span>Lihat semua</span>
                                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Grid Responsif: Mobile (1 Kartu Besar Atas + Daftar Ramping Bawah), Desktop (Grid 4 Kolom) -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6">
                                            @foreach($articles->take(4) as $cIndex => $item)
                                                @php
                                                    $cImgExists = $item->image_path && (file_exists(public_path('storage/' . $item->image_path)) || file_exists(storage_path('app/public/' . $item->image_path)));
                                                    $cFallback = asset($defaultImages[($cIndex + 1) % count($defaultImages)]);
                                                    $cImg = $cImgExists ? asset('storage/' . $item->image_path) : $cFallback;
                                                    $cDate = $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y');
                                                @endphp
                                                @if($cIndex === 0)
                                                    <!-- Item Teratas: Kartu Besar Utama Kategori -->
                                                    <article class="group block text-left">
                                                        <a href="{{ route('public.news.show', $item->slug) }}" class="block focus:outline-none">
                                                            <div
                                                                class="relative w-full aspect-[16/10] overflow-hidden rounded-lg bg-slate-100 mb-2.5">
                                                                <img src="{{ $cImg }}" alt="{{ $item->title }}" loading="lazy"
                                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                            </div>
                                                            <div class="space-y-1">
                                                                <span
                                                                    class="text-[10px] font-semibold text-[#0A3D29] uppercase tracking-wider block">
                                                                    {{ $item->category }}
                                                                </span>
                                                                <h3
                                                                    class="font-serif text-sm sm:text-[15px] font-bold text-slate-900 group-hover:text-[#0A3D29] leading-snug line-clamp-2 transition-colors">
                                                                    {{ $item->title }}
                                                                </h3>
                                                                <p class="text-[11px] text-slate-400">
                                                                    {{ $cDate }}
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </article>
                                                @else
                                                    <!-- Item Bawahnya: Daftar Ramping di Mobile (Gaya Kabar Terkini), Kartu Grid di Desktop -->
                                                    <article class="group text-left border-t border-slate-100 pt-3 sm:border-t-0 sm:pt-0">
                                                        <a href="{{ route('public.news.show', $item->slug) }}" class="flex items-start gap-3 sm:block focus:outline-none">
                                                            <div
                                                                class="w-16 h-16 sm:w-full sm:h-auto sm:aspect-[16/10] shrink-0 overflow-hidden rounded-md sm:rounded-lg bg-slate-100 sm:mb-2.5">
                                                                <img src="{{ $cImg }}" alt="{{ $item->title }}" loading="lazy"
                                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                            </div>
                                                            <div class="flex-1 min-w-0 space-y-0.5 sm:space-y-1">
                                                                <span
                                                                    class="text-[10px] font-semibold text-[#0A3D29] uppercase tracking-wider block">
                                                                    {{ $item->category }}
                                                                </span>
                                                                <h3
                                                                    class="font-serif text-xs sm:text-[15px] font-semibold sm:font-bold text-slate-800 sm:text-slate-900 group-hover:text-[#0A3D29] leading-snug line-clamp-2 transition-colors">
                                                                    {{ $item->title }}
                                                                </h3>
                                                                <p class="text-[11px] text-slate-400">
                                                                    {{ $cDate }}
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </article>
                                                @endif
                                            @endforeach
                                        </div>
                                    </section>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 6. Minimal Clean Pagination -->
                @if($newsList->hasPages())
                    <div class="pt-8 pb-4 flex justify-center">
                        <div class="w-full max-w-xl">
                            {{ $newsList->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-16 px-4 bg-slate-50/50 rounded-lg border border-slate-200/80 max-w-md mx-auto my-8">
                    <span class="text-4xl block mb-3">📰</span>
                    <h3 class="font-serif text-lg font-bold text-slate-800">Belum ada berita ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        @if(request('q'))
                            Tidak ada artikel yang cocok dengan kata kunci "{{ request('q') }}".
                        @elseif(request('category'))
                            Belum ada artikel pada kategori {{ request('category') }}.
                        @else
                            Belum ada berita yang tersedia saat ini.
                        @endif
                    </p>
                    @if(request('q') || request('category'))
                        <div class="pt-4">
                            <a href="{{ route('public.news.index') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md text-xs font-semibold bg-[#0A3D29] text-white hover:bg-[#062c1d] transition-colors">
                                Reset Filter & Tampilkan Semua
                            </a>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

@endsection