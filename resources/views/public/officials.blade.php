@extends('layouts.public')

@section('title', 'Struktur Organisasi Perangkat Desa - Web Profile Desa Catur')

@section('content')

{{-- =========================================================== --}}
{{-- HERO HEADER (EDITORIAL MAGAZINE STYLE - FLAT WHITE BG)      --}}
{{-- =========================================================== --}}
<section class="bg-white pt-6 pb-2 sm:pt-8 sm:pb-3">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-b border-slate-200/80 pb-4">
            <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Struktur Organisasi Perangkat Desa
            </h1>
        </div>
    </div>
</section>

<!-- Main Content Area (Latar Standar Putih Datar) -->
<div class="bg-white pt-4 pb-12 sm:pt-6 sm:pb-18">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">

        @if(isset($officials) && $officials->count() > 0)
            
            <!-- ========================================================= -->
            <!-- A. TAMPILAN MOBILE (Layar < 768px):                        -->
            <!-- SEMUA KARTU SAMA PERSIS TERMASUK SEKRETARIS DESA         -->
            <!-- ========================================================= -->
            <div class="grid grid-cols-2 gap-3 sm:gap-4 md:hidden">
                @foreach($officials as $official)
                    <div class="bg-slate-50/80 rounded-lg p-2.5 sm:p-3.5 border border-slate-200/90 shadow-2xs flex flex-col justify-between group">
                        <div>
                            <!-- Foto dengan rasio aspek 3:4 (persis seperti sekretaris desa) -->
                            <div class="relative rounded-md overflow-hidden aspect-[3/4] w-full bg-slate-200/60 border border-slate-200/70 mb-2.5 flex items-center justify-center shadow-2xs">
                                @if($official->photo_path)
                                    <img src="{{ asset('storage/' . $official->photo_path) }}" 
                                         alt="{{ $official->name }}" 
                                         class="w-full h-full object-cover object-top">
                                @else
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-md bg-slate-200/80 flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Tulisan Jabatan: Gaya seragam tanpa elemen berbeda -->
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                {{ $official->position }}
                            </p>

                            <!-- Nama -->
                            <h3 class="font-['Public_Sans',sans-serif] text-xs sm:text-sm font-extrabold text-slate-800 leading-snug line-clamp-2">
                                {{ $official->name }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ========================================================= -->
            <!-- B. TAMPILAN DESKTOP (Layar >= 768px):                     -->
            <!-- SEKRETARIS DESA DI ATAS (TANPA ELEMEN PEMBEDA),           -->
            <!-- DIIKUTI GRID 4 KOLOM PERANGKAT DESA LAINNYA              -->
            <!-- ========================================================= -->
            <div class="hidden md:block space-y-6 lg:space-y-8">
                <!-- 1. Kartu Sekretaris Desa di Desktop -->
                @if($headOfficial)
                    @php
                        $headPhoto = $headOfficial->photo_path ?? \App\Models\Setting::get('head_photo_path');
                        $headName = $headOfficial->name ?? \App\Models\Setting::get('head_name', 'HANANTO ADI KUSUMO, S.AP');
                        $headPosition = $headOfficial->position ?? \App\Models\Setting::get('head_title', 'SEKRETARIS DESA');
                    @endphp

                    <div class="bg-slate-50/80 rounded-lg p-5 lg:p-7 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-white shadow-2xs hover:shadow-md transition-all duration-300 flex flex-row items-center gap-6 lg:gap-8 group">
                        <!-- Foto Profil Sekretaris Desa (Rasio Aspek 3:4) -->
                        <div class="relative w-40 lg:w-48 aspect-[3/4] rounded-md overflow-hidden bg-slate-200/70 border border-slate-200/80 shrink-0 shadow-2xs">
                            @if($headPhoto)
                                <img src="{{ asset('storage/' . $headPhoto) }}" alt="{{ $headName }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-[#145C3B]/60">
                                    <svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Detail Informasi Sekretaris Desa (Gaya Teks Seragam Tanpa Badge Pembeda) -->
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-[#0A3D29] mb-1">
                                {{ $headPosition }}
                            </p>
                            <h2 class="font-['Public_Sans',sans-serif] text-2xl lg:text-3xl font-extrabold text-slate-800 leading-snug">
                                {{ $headName }}
                            </h2>
                        </div>
                    </div>
                @endif

                <!-- 2. Grid Perangkat Desa Lainnya di Desktop (4 Kolom) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($otherOfficials as $official)
                        <div class="bg-slate-50/80 rounded-lg p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-white shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <!-- Photo Container (Rasio Aspek 3:4 Persis Seperti Sekretaris Desa) -->
                                <div class="relative rounded-md overflow-hidden aspect-[3/4] w-full bg-slate-200/60 border border-slate-200/70 mb-3.5 flex items-center justify-center shadow-2xs">
                                    @if($official->photo_path)
                                        <img src="{{ asset('storage/' . $official->photo_path) }}" 
                                             alt="{{ $official->name }}" 
                                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-14 h-14 rounded-md bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] transition-colors">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Position Text -->
                                <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                                    {{ $official->position }}
                                </p>

                                <!-- Official Name -->
                                <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                    {{ $official->name }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @else
            <!-- Fallback Data jika belum ada data perangkat di database -->
            @php
                $fallbackList = [
                    ['name' => 'HANANTO ADI KUSUMO, S.AP', 'position' => 'SEKRETARIS DESA'],
                    ['name' => 'SIGIT SETIYAWAN, S.P', 'position' => 'KASI PEMERINTAHAN'],
                    ['name' => 'AHMAD SURYANTO, S.Ag', 'position' => 'KASI KESEJAHTERAAN'],
                    ['name' => 'MULYADI', 'position' => 'KASI PELAYANAN'],
                    ['name' => 'SUBAKIR', 'position' => 'KAUR KEUANGAN'],
                    ['name' => 'MURSID GUNADI, S.H', 'position' => 'KADUS II'],
                    ['name' => 'AHMAD KHOIRONI, S.M', 'position' => 'KADUS III'],
                ];
            @endphp

            <!-- Fallback Mobile (Semua Seragam) -->
            <div class="grid grid-cols-2 gap-3 sm:gap-4 md:hidden">
                @foreach($fallbackList as $item)
                    <div class="bg-slate-50/80 rounded-lg p-2.5 sm:p-3.5 border border-slate-200/90 shadow-2xs flex flex-col justify-between group">
                        <div>
                            <div class="relative rounded-md overflow-hidden aspect-[3/4] w-full bg-slate-200/60 border border-slate-200/70 mb-2.5 flex items-center justify-center shadow-2xs">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-md bg-slate-200/80 flex items-center justify-center text-[#145C3B]">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-[#0A3D29] mb-0.5 line-clamp-1">
                                {{ $item['position'] }}
                            </p>
                            <h3 class="font-['Public_Sans',sans-serif] text-xs sm:text-sm font-extrabold text-slate-800 leading-snug line-clamp-2">
                                {{ $item['name'] }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Fallback Desktop -->
            <div class="hidden md:block space-y-6 lg:space-y-8">
                <!-- Sekretaris Desa di Atas -->
                <div class="bg-slate-50/80 rounded-lg p-5 lg:p-7 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-white shadow-2xs hover:shadow-md transition-all duration-300 flex flex-row items-center gap-6 lg:gap-8 group">
                    <div class="relative w-40 lg:w-48 aspect-[3/4] rounded-md overflow-hidden bg-slate-200/70 border border-slate-200/80 shrink-0 shadow-2xs flex items-center justify-center">
                        <div class="w-12 h-12 rounded-md bg-slate-200/80 flex items-center justify-center text-[#145C3B]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-[#0A3D29] mb-1">
                            {{ $fallbackList[0]['position'] }}
                        </p>
                        <h2 class="font-['Public_Sans',sans-serif] text-2xl lg:text-3xl font-extrabold text-slate-800 leading-snug">
                            {{ $fallbackList[0]['name'] }}
                        </h2>
                    </div>
                </div>

                <!-- Grid Lainnya -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach(array_slice($fallbackList, 1) as $item)
                        <div class="bg-slate-50/80 rounded-lg p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#0A3D29]/40 hover:bg-white shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative rounded-md overflow-hidden aspect-[3/4] w-full bg-slate-200/60 border border-slate-200/70 mb-3.5 flex items-center justify-center shadow-2xs">
                                    <div class="w-14 h-14 rounded-md bg-slate-200/80 flex items-center justify-center text-[#145C3B]">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                                    {{ $item['position'] }}
                                </p>
                                <h3 class="font-['Public_Sans',sans-serif] text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                    {{ $item['name'] }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @endif

    </div>
</div>

@endsection
