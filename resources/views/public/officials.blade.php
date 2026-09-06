@extends('layouts.public')

@section('title', 'Struktur Organisasi Perangkat Desa - Web Profile Desa Catur')

@section('content')

{{-- =========================================================== --}}
{{-- HERO HEADER (MINIMALIST & BALANCED LIKE PROFILE/STATS)       --}}
{{-- =========================================================== --}}
<section class="bg-[#F7F8F2] pt-6 pb-3 sm:pt-8 sm:pb-4">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-slate-200/70 pb-4">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[#20332A] tracking-tight">
                    Struktur Organisasi Perangkat Desa
                </h1>
            </div>
            <div class="text-xs text-[#6C7B72] shrink-0 font-medium">
                <span>Diperbarui pada <span class="font-bold text-[#20332A]">{{ \Illuminate\Support\Carbon::now()->translatedFormat('d F Y') }}</span> oleh Admin</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Area -->
<div class="bg-[#F7F8F2] pt-4 pb-12 sm:pt-6 sm:pb-16">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- ========================================================= -->
        <!-- 1. KARTU KEPALA DESA (MINIMALIST & MEMANJANG DI ATAS)     -->
        <!-- ========================================================= -->
        <div>
            @php
                $headPhoto = $headOfficial?->photo_path ?? \App\Models\Setting::get('head_photo_path');
                $headName = $headOfficial?->name ?? \App\Models\Setting::get('head_name', 'Dra. NUNIK S RAHAYU, M.Pd');
                $headPosition = $headOfficial?->position ?? \App\Models\Setting::get('head_title', 'Kepala Desa Catur');
                $headPhone = $headOfficial?->phone;
                $headEmail = $headOfficial?->email;
            @endphp

            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#DCE6DA]/80 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col md:flex-row items-center gap-6 md:gap-8 group">
                <!-- Foto Profil Kepala Desa (Proporsional & Clean) -->
                <div class="relative w-44 sm:w-52 aspect-[3/4] rounded-2xl overflow-hidden bg-gradient-to-br from-[#F0F5EE] via-[#EAF1E8] to-[#E2EBDD] border border-[#DCE6DA]/60 shadow-inner shrink-0">
                    @if($headPhoto)
                        <img src="{{ asset('storage/' . $headPhoto) }}" alt="{{ $headName }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-[#145C3B]/60">
                            <svg class="w-16 h-16 mb-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-xs font-semibold text-[#145C3B]/70">Foto Kepala Desa</span>
                        </div>
                    @endif
                </div>

                <!-- Detail Informasi Kepala Desa (Ultra Minimalist) -->
                <div class="flex-1 text-center md:text-left space-y-1">
                    <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-[#0A3D29]">
                        {{ $headPosition }}
                    </p>
                    <h2 class="font-['Public_Sans',sans-serif] text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $headName }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- 2. KARTU PERANGKAT DESA (4 TAMPILAN BERJAJAR GRID)       -->
        <!-- ========================================================= -->
        <div class="space-y-6">
            <!-- 4 Column Grid (Minimalist & Compact) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @if(isset($otherOfficials) && $otherOfficials->count() > 0)
                    @foreach($otherOfficials as $official)
                        <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-200/80 hover:border-[#0A3D29]/30 shadow-xs hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between group">
                            <div>
                                <!-- Photo Container (Ringkas & Proporsional) -->
                                <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3.5 flex items-center justify-center shadow-2xs">
                                    @if($official->photo_path)
                                        <img src="{{ asset('storage/' . $official->photo_path) }}" 
                                             alt="{{ $official->name }}" 
                                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] transition-colors">
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
                @else
                    <!-- Fallback Card 1: Sekretaris Desa -->
                    <div class="bg-white rounded-2xl p-4 border border-[#DCE6DA]/80 shadow-2xs hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between group">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[4/5] w-full bg-gradient-to-br from-[#F0F5EE] via-[#EAF1E8] to-[#E2EBDD] border border-[#DCE6DA]/60 mb-3 flex items-center justify-center shadow-inner">
                                <div class="w-14 h-14 rounded-full bg-white/90 shadow-xs flex items-center justify-center text-[#145C3B]">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-1.5">
                                <span class="inline-block bg-[#EAF1E8] text-[#0A3D29] font-bold text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-md border border-[#DCE6DA]">
                                    SEKRETARIS DESA
                                </span>
                            </div>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-[#20332A] leading-snug">
                                Bambang Sugeng, S.Sos.
                            </h3>
                        </div>
                    </div>

                    <!-- Fallback Card 2: Kaur Keuangan -->
                    <div class="bg-white rounded-2xl p-4 border border-[#DCE6DA]/80 shadow-2xs hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between group">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[4/5] w-full bg-gradient-to-br from-[#F0F5EE] via-[#EAF1E8] to-[#E2EBDD] border border-[#DCE6DA]/60 mb-3 flex items-center justify-center shadow-inner">
                                <div class="w-14 h-14 rounded-full bg-white/90 shadow-xs flex items-center justify-center text-[#145C3B]">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-1.5">
                                <span class="inline-block bg-[#EAF1E8] text-[#0A3D29] font-bold text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-md border border-[#DCE6DA]">
                                    KAUR KEUANGAN
                                </span>
                            </div>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-[#20332A] leading-snug">
                                Siti Rahmawati, A.Md.
                            </h3>
                        </div>
                    </div>

                    <!-- Fallback Card 3: Kaur Perencanaan & Umum -->
                    <div class="bg-white rounded-2xl p-4 border border-[#DCE6DA]/80 shadow-2xs hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between group">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[4/5] w-full bg-gradient-to-br from-[#F0F5EE] via-[#EAF1E8] to-[#E2EBDD] border border-[#DCE6DA]/60 mb-3 flex items-center justify-center shadow-inner">
                                <div class="w-14 h-14 rounded-full bg-white/90 shadow-xs flex items-center justify-center text-[#145C3B]">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-1.5">
                                <span class="inline-block bg-[#EAF1E8] text-[#0A3D29] font-bold text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-md border border-[#DCE6DA]">
                                    KAUR PERENCANAAN & UMUM
                                </span>
                            </div>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-[#20332A] leading-snug">
                                Tri Santoso, S.T.
                            </h3>
                        </div>
                    </div>

                    <!-- Fallback Card 4: Kasi Pemerintahan -->
                    <div class="bg-white rounded-2xl p-4 border border-[#DCE6DA]/80 shadow-2xs hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between group">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[4/5] w-full bg-gradient-to-br from-[#F0F5EE] via-[#EAF1E8] to-[#E2EBDD] border border-[#DCE6DA]/60 mb-3 flex items-center justify-center shadow-inner">
                                <div class="w-14 h-14 rounded-full bg-white/90 shadow-xs flex items-center justify-center text-[#145C3B]">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-1.5">
                                <span class="inline-block bg-[#EAF1E8] text-[#0A3D29] font-bold text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-md border border-[#DCE6DA]">
                                    KASI PEMERINTAHAN
                                </span>
                            </div>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-[#20332A] leading-snug">
                                Wayan Suardana, S.IP.
                            </h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
