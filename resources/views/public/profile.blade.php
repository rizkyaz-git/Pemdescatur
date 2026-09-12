@extends('layouts.public')

@section('title', 'Profil & Sejarah Desa Catur – Sambi, Boyolali')

@section('meta_description', 'Profil dan sejarah resmi Desa Catur, Kecamatan Sambi, Kabupaten Boyolali. Informasi asal usul nama, visi misi, perjalanan sejarah, dan kondisi geografis Desa Catur.')

@section('content')

    @php
        $coverImage = ($profile && $profile->image)
            ? asset('storage/' . $profile->image)
            : asset('images/hero_landscape.png');
    @endphp

    <!-- Classic Editorial Magazine Layout (Diselaraskan dengan Tema Hijau Botani Desa Catur) -->
    <div class="bg-white min-h-screen py-10 sm:py-14 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ========================================================================= --}}
            {{-- 1. TOP HEADER (Rata Kiri dengan Navigasi Breadcrumb)                      --}}
            {{-- ========================================================================= --}}
            <header class="text-left pb-8 sm:pb-10">
                <x-breadcrumbs :items="[
                    ['label' => 'BERANDA', 'url' => route('home')],
                    ['label' => 'Profil Desa']
                ]" />
                <h1
                    class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#20332A] tracking-tight leading-tight">
                    Profil Desa Catur
                </h1>
            </header>

            {{-- ========================================================================= --}}
            {{-- 2. EDITORIAL GRID (Main Story & Photo + Sidebar Data Wilayah)             --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start mt-2 sm:mt-4">

                {{-- ================= MAIN COLUMN: ~8 COLS (Main Story & Photo) ================= --}}
                <main class="lg:col-span-8 space-y-6">

                    <!-- Featured Large Landscape Photo -->
                    <div class="w-full aspect-[16/10] overflow-hidden bg-slate-100 border border-[#DCE6DA] rounded-lg">
                        <img src="{{ $coverImage }}" alt="Pemandangan Alam Desa Catur" class="w-full h-full object-cover">
                    </div>

                    <!-- Editorial Story Content -->
                    <div
                        class="prose prose-slate max-w-none text-[#20332A] text-sm sm:text-base leading-relaxed space-y-4 pt-1 font-sans prose-headings:font-serif prose-headings:text-[#20332A] prose-headings:tracking-tight prose-p:text-[#3E4D45] prose-p:leading-relaxed prose-blockquote:border-l-2 prose-blockquote:border-[#0A3D29] prose-blockquote:bg-[#EAF1E8]/30 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:italic prose-blockquote:font-serif prose-blockquote:rounded-r-sm prose-a:text-[#0A3D29] prose-a:font-semibold hover:prose-a:underline">

                        @if($profile && trim(strip_tags($profile->history)) !== '')
                            <div class="leading-relaxed space-y-3 text-[#3E4D45]">
                                {!! $profile->history !!}
                            </div>
                        @else
                            <p class="leading-relaxed text-[#3E4D45]">
                                Desa Catur merupakan salah satu desa di Kecamatan Sambi, Kabupaten Boyolali, Provinsi Jawa
                                Tengah yang membawahi 13 pedukuhan. Sejak dahulu Desa Catur terkenal dengan keteladanan sektor
                                pertanian padi organik yang didukung sistem irigasi stabil dari Waduk Wonotoro sepanjang tahun.
                            </p>
                        @endif

                    </div>

                </main>


                {{-- ================= RIGHT COLUMN: ~4 COLS (Card Panel Kanan) ================= --}}
                <aside class="lg:col-span-4 space-y-6">

                    <!-- Kartu: Data Geografis Ringkas (Dipindahkan di atas Batas Wilayah) -->
                    <div class="bg-white border border-[#DCE6DA] rounded-lg p-5 shadow-xs space-y-3">
                        <h3
                            class="font-serif font-bold text-xs uppercase tracking-widest text-[#0A3D29] border-b border-[#DCE6DA] pb-2">
                            Data Ringkas Wilayah
                        </h3>
                        <div class="space-y-2 text-xs text-[#4B5851]">
                            <div class="flex justify-between items-center py-1 border-b border-[#DCE6DA]/50">
                                <span class="text-[#6C7B72]">Luas Wilayah</span>
                                <span
                                    class="font-bold text-[#20332A]">{{ number_format($profile->luas_wilayah_ha ?? 244.5, 1) }}
                                    Ha</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#DCE6DA]/50">
                                <span class="text-[#6C7B72]">Ketinggian</span>
                                <span class="font-bold text-[#20332A]">{{ $profile->ketinggian_mdpl ?? 269 }} mdpl</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#DCE6DA]/50">
                                <span class="text-[#6C7B72]">Jumlah Kadus</span>
                                <span class="font-bold text-[#20332A]">3 Kebayanan</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#DCE6DA]/50">
                                <span class="text-[#6C7B72]">Jumlah Dukuh</span>
                                <span class="font-bold text-[#20332A]">13 Pedukuhan</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#DCE6DA]/50">
                                <span class="text-[#6C7B72]">Curah Hujan</span>
                                <span class="font-bold text-[#20332A]">{{ number_format($profile->curah_hujan_mm ?? 2368) }}
                                    mm/th</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu: Batas Wilayah & Peta -->
                    <div class="bg-white border border-[#DCE6DA] rounded-lg p-5 shadow-xs space-y-3">
                        <div class="flex items-center justify-between border-b border-[#DCE6DA] pb-2">
                            <h3 class="font-serif font-bold text-xs uppercase tracking-widest text-[#0A3D29]">
                                Batas Wilayah
                            </h3>
                            <a href="https://maps.app.goo.gl/E4SedfywjCLU7X8E6" target="_blank" rel="noopener noreferrer"
                                class="text-[11px] font-bold text-[#0A3D29] hover:underline">
                                Maps ↗
                            </a>
                        </div>

                        <div class="space-y-1.5 text-xs text-[#4B5851]">
                            <p><span class="text-[#6C7B72] font-bold uppercase text-[10px]">Utara:</span> <span
                                    class="text-[#20332A] font-medium">{{ $profile->batas_utara ?? 'Desa Ngaglik' }}</span>
                            </p>
                            <p><span class="text-[#6C7B72] font-bold uppercase text-[10px]">Timur:</span> <span
                                    class="text-[#20332A] font-medium">{{ $profile->batas_timur ?? 'Desa Tawengan' }}</span>
                            </p>
                            <p><span class="text-[#6C7B72] font-bold uppercase text-[10px]">Selatan:</span> <span
                                    class="text-[#20332A] font-medium">{{ $profile->batas_selatan ?? 'Desa Glintang' }}</span>
                            </p>
                            <p><span class="text-[#6C7B72] font-bold uppercase text-[10px]">Barat:</span> <span
                                    class="text-[#20332A] font-medium">{{ $profile->batas_barat ?? 'Desa Papringan' }}</span>
                            </p>
                        </div>

                        <!-- Clean Embedded Map -->
                        <div class="w-full h-80 sm:h-96 lg:h-[420px] overflow-hidden border border-[#DCE6DA] rounded-md mt-2">
                            <iframe src="https://maps.google.com/maps?q=Catur%2C+Sambi%2C+Boyolali&t=h&z=14&output=embed"
                                class="w-full h-full border-0" loading="lazy" title="Peta Satelit Wilayah Desa Catur"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                </aside>

            </div>

        </div>
    </div>

@endsection