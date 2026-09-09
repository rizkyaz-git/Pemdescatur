@extends('layouts.public')

@section('title', 'Template Surat Siap Cetak - Pemerintah Desa Catur')
@section('meta_description', 'Unduh resmi berkas template surat keterangan siap cetak Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali. Download template Word (.doc) dan lengkapi persyaratan sebelum legalisasi ke balai desa.')

@section('content')

    <!-- ========================================================================= -->
    <!-- 1. HERO HEADER: Template Surat Siap Cetak                                 -->
    <!-- ========================================================================= -->
    <!-- Session Flash Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-emerald-50 border-l-4 border-[#0A3D29] p-3.5 rounded-lg shadow-2xs flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-emerald-900">
                    <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-rose-50 border-l-4 border-rose-600 p-3.5 rounded-lg shadow-2xs flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-rose-900">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif


    <!-- ========================================================================= -->
    <!-- 2. MAIN SECTION: KATALOG TEMPLATE SURAT SIAP CETAK (GRID)                 -->
    <!-- ========================================================================= -->
    <section id="katalog-surat" class="w-full bg-white py-8 sm:py-12 border-b border-slate-200"
             x-data="{ 
                 selectedTemplate: null, 
                 modalOpen: false,
                 searchKeyword: '{{ $search ?? '' }}'
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Top Filter & Search Bar (Minimalist Dark Green) --}}
            <div class="bg-[#0A3D29] text-white rounded-xl p-5 sm:p-6 border border-[#072B1D] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-serif text-lg sm:text-xl font-bold text-white tracking-tight">
                        Pilih Berkas Template Surat
                    </h2>
                </div>

                {{-- Search Form --}}
                <div class="w-full md:w-80">
                    <form action="{{ route('warga.letter.index') }}#katalog-surat" method="GET" class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}" 
                               placeholder="Cari surat..." 
                               class="w-full pl-9 pr-20 py-2.5 rounded-lg border border-transparent focus:ring-2 focus:ring-emerald-400 focus:outline-none text-xs sm:text-sm bg-white text-slate-900 placeholder:text-slate-400 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <div class="absolute right-1.5 top-1.5 flex items-center gap-1">
                            @if(!empty($search))
                                <a href="{{ route('warga.letter.index') }}#katalog-surat" 
                                   class="text-xs text-slate-400 hover:text-slate-700 px-1.5 py-1">
                                    ✕
                                </a>
                            @endif
                            <button type="submit" 
                                    class="bg-[#0A3D29] hover:bg-[#072B1D] text-white text-xs font-semibold px-3 py-1 rounded-md transition">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Template Cards Grid (Clickable Cards, No Code Badge) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($templates as $template)
                    <div @click="selectedTemplate = {{ json_encode([
                             'id' => $template->id,
                             'name' => $template->name,
                             'description' => $template->description,
                             'requirements' => $template->requirements,
                             'has_file' => $template->has_file,
                             'file_extension' => $template->file_extension,
                             'file_size' => $template->file_size_formatted,
                             'download_url' => route('warga.letter.download', $template->id)
                         ]) }}; modalOpen = true;"
                         class="bg-white rounded-xl p-5 sm:p-6 border border-slate-200/90 hover:border-emerald-700/60 shadow-2xs hover:shadow-xs transition-colors flex flex-col justify-between cursor-pointer group">
                        
                        <div class="space-y-3.5">
                            
                            {{-- Header: File Format Info --}}
                            <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-slate-100">
                                @if($template->has_file)
                                    <span class="text-xs text-slate-500 font-medium inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-semibold text-slate-700">Berkas {{ $template->file_extension }}</span>
                                        @if($template->file_size_formatted)
                                            <span class="text-slate-400 font-normal">({{ $template->file_size_formatted }})</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                        Menunggu File
                                    </span>
                                @endif

                                <span class="text-[11px] text-emerald-700 group-hover:text-emerald-900 font-medium inline-flex items-center gap-0.5 transition-colors">
                                    <span>Lihat Syarat</span>
                                    <span>→</span>
                                </span>
                            </div>

                            {{-- Title & Description --}}
                            <div class="space-y-1.5">
                                <h3 class="font-serif text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0A3D29] transition-colors leading-snug">
                                    {{ $template->name }}
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                                    {{ $template->description ?: 'Format berkas surat resmi Pemerintah Desa Catur yang dapat dicetak mandiri oleh warga.' }}
                                </p>
                            </div>

                            {{-- Requirements Checklist (Clean & Minimalist) --}}
                            @if(!empty($template->requirements))
                                <div class="pt-2.5 border-t border-slate-100 space-y-1.5">
                                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">
                                        Persyaratan Berkas:
                                    </span>
                                    <ul class="text-xs text-slate-600 space-y-1 leading-snug">
                                        @foreach(array_slice(explode("\n", trim($template->requirements)), 0, 3) as $reqItem)
                                            @if(trim($reqItem))
                                                <li class="flex items-start gap-1.5">
                                                    <span class="text-[#0A3D29] font-bold mt-0.5">•</span>
                                                    <span class="line-clamp-1">{{ ltrim(trim($reqItem), '-*• ') }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if(count(explode("\n", trim($template->requirements))) > 3)
                                            <li class="text-[11px] text-emerald-800 font-medium pt-0.5">
                                                + {{ count(explode("\n", trim($template->requirements))) - 3 }} persyaratan lainnya
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif

                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-4 mt-4 border-t border-slate-100">
                            @if($template->has_file)
                                <a href="{{ route('warga.letter.download', $template->id) }}" 
                                   @click.stop
                                   class="w-full inline-flex items-center justify-center gap-1.5 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-3 rounded-lg transition-colors text-center shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span>Unduh Berkas</span>
                                </a>
                            @else
                                <button type="button" 
                                        disabled 
                                        @click.stop
                                        class="w-full inline-flex items-center justify-center gap-1.5 bg-slate-100 text-slate-400 font-medium text-xs py-2.5 px-3 rounded-lg cursor-not-allowed">
                                    <span>File Belum Siap</span>
                                </button>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500 bg-white rounded-xl border border-slate-200 p-6">
                        <h4 class="text-base font-bold text-slate-800">Tidak ada template surat yang cocok</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            Kata kunci penelusuran "{{ $search }}" tidak ditemukan.
                        </p>
                        <div class="pt-4">
                            <a href="{{ route('warga.letter.index') }}" 
                               class="inline-flex items-center gap-1.5 bg-[#0A3D29] text-white font-medium text-xs px-4 py-2 rounded-lg hover:bg-[#072B1D] transition">
                                <span>Tampilkan Semua Template</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Modal: Detail Persyaratan Berkas Template (Minimalist) --}}
            <div x-show="modalOpen" 
                 x-cloak
                 class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/50"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div class="bg-white rounded-xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-slate-200 space-y-4 relative text-left"
                     @click.away="modalOpen = false">
                    
                    {{-- Modal Header --}}
                    <div class="flex items-start justify-between border-b border-slate-100 pb-3">
                        <div class="space-y-1">
                            <h3 class="font-serif text-lg font-bold text-slate-900" 
                                x-text="selectedTemplate ? selectedTemplate.name : ''"></h3>
                            <span class="text-[11px] font-medium text-slate-500 block" 
                                  x-text="selectedTemplate ? (selectedTemplate.has_file ? 'Berkas ' + selectedTemplate.file_extension + ' • Siap Cetak' : 'Template Desa') : ''"></span>
                        </div>
                        <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-md transition text-lg font-bold">
                            ✕
                        </button>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-1">
                        <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Keterangan:</span>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed" x-text="selectedTemplate ? selectedTemplate.description : ''"></p>
                    </div>

                    {{-- Requirements Checklist in Modal --}}
                    <div class="space-y-1.5" x-show="selectedTemplate && selectedTemplate.requirements">
                        <span class="text-[11px] font-semibold text-[#0A3D29] uppercase tracking-wider block">Persyaratan Berkas Warga:</span>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-xs text-slate-700 font-medium whitespace-pre-line leading-relaxed"
                             x-text="selectedTemplate ? selectedTemplate.requirements : ''">
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                        <button type="button" @click="modalOpen = false" 
                                class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 text-xs font-medium hover:bg-slate-50 transition">
                            Tutup
                        </button>
                        <template x-if="selectedTemplate && selectedTemplate.has_file">
                            <a :href="selectedTemplate.download_url" 
                               class="inline-flex items-center justify-center gap-1.5 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-medium text-xs px-4 py-2 rounded-lg transition">
                                <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Unduh Template</span>
                            </a>
                        </template>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 3. ALUR PENGURUSAN MANDIRI (3 LANGKAH)                                    -->
    <!-- ========================================================================= -->
    <section class="w-full bg-white py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Alur Pengurusan Surat Cetak Mandiri
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                {{-- Step 1 --}}
                <div class="p-5 sm:p-6 rounded-xl bg-[#0A3D29] text-white border border-[#072B1D] shadow-xs space-y-3">
                    <div class="w-8 h-8 rounded-lg bg-white text-[#0A3D29] font-black text-xs flex items-center justify-center shadow-xs">
                        1
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-base text-white">Unduh Template Berkas</h3>
                        <p class="text-xs text-white/80 leading-relaxed">
                            Cari jenis surat yang Anda perlukan pada katalog di atas, lalu klik <strong class="text-white font-semibold">Unduh Berkas</strong> untuk mengunduh template resmi Word (.doc) atau PDF.
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="p-5 sm:p-6 rounded-xl bg-[#0A3D29] text-white border border-[#072B1D] shadow-xs space-y-3">
                    <div class="w-8 h-8 rounded-lg bg-white text-[#0A3D29] font-black text-xs flex items-center justify-center shadow-xs">
                        2
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-base text-white">Isi Data &amp; Cetak Mandiri</h3>
                        <p class="text-xs text-white/80 leading-relaxed">
                            Buka berkas di komputer atau ponsel. Isi data pemohon dengan benar, lalu cetak (print) di atas kertas ukuran F4 / A4.
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="p-5 sm:p-6 rounded-xl bg-[#0A3D29] text-white border border-[#072B1D] shadow-xs space-y-3">
                    <div class="w-8 h-8 rounded-lg bg-white text-[#0A3D29] font-black text-xs flex items-center justify-center shadow-xs">
                        3
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-base text-white">Legalisasi di Balai Desa</h3>
                        <p class="text-xs text-white/80 leading-relaxed">
                            Bawa berkas hasil cetak bersama dokumen persyaratan (Fotokopi KTP, KK, Pengantar RT/RW) ke Balai Desa Catur untuk ditandatangani dan distempel resmi.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
