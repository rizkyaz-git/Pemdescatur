@extends('layouts.public')

@section('title', 'Layanan Cetak Surat Mandiri - Pemerintah Desa Catur')
@section('meta_description', 'Unduh resmi berkas template surat keterangan siap cetak Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali. Unduh template dokumen dan lengkapi persyaratan sebelum legalisasi ke balai desa.')

@section('content')

    @php
        $templatesData = $templates->map(function ($template) {
            return [
                'id' => $template->id,
                'name' => $template->name,
                'description' => $template->description ?: 'Format berkas surat resmi Pemerintah Desa Catur yang dapat dicetak mandiri oleh pemohon.',
                'requirements' => !empty($template->requirements)
                    ? array_values(array_filter(array_map('trim', explode("\n", $template->requirements))))
                    : [],
                'has_file' => (bool) $template->has_file,
                'file_extension' => $template->file_extension,
                'file_size' => $template->file_size_formatted,
                'download_url' => route('warga.letter.download', $template->id),
            ];
        });
    @endphp

    <!-- Main Page Container (Clean Minimalist Canvas) -->
    <div class="bg-white min-h-screen py-8 sm:py-10" x-data="{ 
                 templates: {{ Js::from($templatesData) }},
                 selectedTemplate: null,
                 mobileView: 'menu',
                 selectTemplate(item) {
                     this.selectedTemplate = item;
                     this.mobileView = 'detail';
                     if (window.innerWidth < 1024) {
                         const el = document.getElementById('katalog-surat');
                         if (el) {
                             el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                         }
                     }
                 },
                 backToMenu() {
                     this.mobileView = 'menu';
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" id="katalog-surat">

            <!-- Session Flash Notifications (Minimalist) -->
            @if(session('success'))
                <div
                    class="bg-emerald-50/80 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-xs sm:text-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="bg-rose-50/80 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg text-xs sm:text-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Minimalist Header Title & Search Bar -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6 pb-6 border-b border-slate-200/80">
                <div>
                    <h1
                        class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#20332A] leading-tight tracking-tight">
                        Layanan Cetak Surat Mandiri
                    </h1>
                </div>

                <!-- Minimalist Search Input -->
                <div class="w-full sm:w-72 md:w-80">
                    <form action="{{ route('warga.letter.index') }}#katalog-surat" method="GET" class="relative">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari surat..."
                            class="w-full pl-9 pr-16 py-2.5 rounded-lg border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder:text-slate-400 bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-1 focus:ring-[#0A3D29]/30 transition shadow-xs">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <div class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center gap-1">
                            @if(!empty($search))
                                <a href="{{ route('warga.letter.index') }}#katalog-surat"
                                    class="text-xs text-slate-400 hover:text-slate-600 px-1 py-0.5" title="Hapus pencarian">
                                    ✕
                                </a>
                            @endif
                            <button type="submit"
                                class="bg-[#0A3D29] hover:bg-[#072B1D] text-white text-xs font-semibold px-2.5 py-1.5 rounded-md transition cursor-pointer">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- KATALOG TEMPLATE SURAT: MASTER-DETAIL INTERAKTIF (RESPONSIF)              -->
            <!-- ========================================================================= -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start pt-2">

                <!-- Left Side: List Template Surat -->
                <div class="lg:col-span-5" :class="mobileView === 'detail' ? 'hidden lg:block' : 'block'">
                    <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-xs">
                        <!-- Header Daftar Template -->
                        <div
                            class="px-4 py-3 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                            <h2 class="text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Daftar Template ({{ count($templates) }})
                            </h2>
                            @if(!empty($search))
                                <a href="{{ route('warga.letter.index') }}#katalog-surat"
                                    class="text-xs text-[#0A3D29] hover:underline font-medium">
                                    Reset filter
                                </a>
                            @endif
                        </div>

                        <div class="divide-y divide-slate-100 max-h-[640px] overflow-y-auto">
                            <template x-for="item in templates" :key="item.id">
                                <button type="button" @click="selectTemplate(item)"
                                    class="w-full text-left p-4 transition-all flex items-center justify-between gap-4 group cursor-pointer"
                                    :class="selectedTemplate && selectedTemplate.id === item.id 
                                            ? 'bg-slate-100/90' 
                                            : 'hover:bg-slate-50/80'">
                                    <div class="space-y-1 flex-1 min-w-0">
                                        <h3 class="font-serif text-sm font-bold text-slate-900 group-hover:text-slate-950 transition-colors truncate"
                                            x-text="item.name"></h3>
                                        <p class="text-xs text-slate-500 line-clamp-1" x-text="item.description"></p>
                                        <div class="pt-0.5">
                                            <span class="text-[11px] text-slate-400 font-medium"
                                                x-text="item.has_file ? (item.file_extension + (item.file_size !== '-' ? ' • ' + item.file_size : '')) : 'Menunggu File'"></span>
                                        </div>
                                    </div>
                                    <div class="shrink-0 text-slate-300 group-hover:text-slate-500 transition-colors"
                                        :class="selectedTemplate && selectedTemplate.id === item.id ? 'text-slate-600' : ''">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </button>
                            </template>

                            @if(count($templates) === 0)
                                <div class="p-8 text-center text-slate-500">
                                    <p class="text-sm font-medium text-slate-700">Tidak ada template surat yang cocok</p>
                                    @if(!empty($search))
                                        <p class="text-xs text-slate-400 mt-1">Kata kunci penelusuran "{{ $search }}" tidak
                                            ditemukan.</p>
                                        <a href="{{ route('warga.letter.index') }}#katalog-surat"
                                            class="inline-block mt-3 text-xs font-semibold text-[#0A3D29] hover:underline">
                                            Tampilkan Semua Template
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Side: Rincian Template Surat (Sticky Detail Panel) -->
                <div class="lg:col-span-7 lg:sticky lg:top-24" :class="mobileView === 'menu' ? 'hidden lg:block' : 'block'">

                    <!-- Mobile Back Navigation -->
                    <button type="button" @click="backToMenu()"
                        class="lg:hidden inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 pb-2 mb-4 border-b border-slate-100 w-full transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Kembali ke Daftar Surat</span>
                    </button>

                    <!-- Empty State: Ketika belum ada template yang dipilih -->
                    <div x-show="!selectedTemplate"
                        class="bg-white rounded-xl border border-dashed border-slate-300/80 p-12 text-center flex flex-col items-center justify-center min-h-[380px] shadow-xs space-y-3">
                        <div
                            class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-700">Pilih template untuk rincian</h3>
                    </div>

                    <!-- Active State: Rincian Lengkap Template Terpilih -->
                    <div x-show="selectedTemplate" x-cloak
                        class="bg-white rounded-xl border border-slate-200/90 p-6 sm:p-7 shadow-xs space-y-6">

                        <!-- Detail Header -->
                        <div class="pb-5 border-b border-slate-100 space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-600"
                                    x-text="selectedTemplate ? (selectedTemplate.has_file ? (selectedTemplate.file_extension + (selectedTemplate.file_size !== '-' ? ' • ' + selectedTemplate.file_size : '')) : 'Berkas Belum Tersedia') : ''"></span>
                            </div>
                            <h3 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 leading-tight"
                                x-text="selectedTemplate ? selectedTemplate.name : ''"></h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed"
                                x-text="selectedTemplate ? selectedTemplate.description : ''"></p>
                        </div>

                        <!-- Persyaratan Berkas -->
                        <div class="space-y-3">
                            <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider block">
                                Persyaratan Berkas Pemohon:
                            </span>

                            <template
                                x-if="selectedTemplate && selectedTemplate.requirements && selectedTemplate.requirements.length > 0">
                                <ul class="space-y-2">
                                    <template x-for="(req, idx) in selectedTemplate.requirements" :key="idx">
                                        <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700 leading-snug">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-2 shrink-0"></span>
                                            <span x-text="req"></span>
                                        </li>
                                    </template>
                                </ul>
                            </template>

                            <template
                                x-if="selectedTemplate && (!selectedTemplate.requirements || selectedTemplate.requirements.length === 0)">
                                <p class="text-xs text-slate-400 italic">
                                    Tidak ada persyaratan berkas khusus yang dicantumkan untuk template ini.
                                </p>
                            </template>
                        </div>

                        <!-- Tombol Unduh & Catatan -->
                        <div class="pt-5 border-t border-slate-100 space-y-3">
                            <template x-if="selectedTemplate && selectedTemplate.has_file">
                                <a :href="selectedTemplate.download_url"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs sm:text-sm py-2.5 px-4 rounded-lg transition-colors text-center cursor-pointer shadow-xs">
                                    <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span x-text="'Unduh Berkas (' + selectedTemplate.file_extension + ')'"></span>
                                </a>
                            </template>

                            <template x-if="selectedTemplate && !selectedTemplate.has_file">
                                <button type="button" disabled
                                    class="w-full inline-flex items-center justify-center gap-2 bg-slate-100 text-slate-400 font-medium text-xs sm:text-sm py-2.5 px-4 rounded-lg cursor-not-allowed">
                                    <span>Berkas Template Belum Tersedia untuk Diunduh</span>
                                </button>
                            </template>

                            <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                                Cetak mandiri berkas ini di atas kertas F4/A4, lengkapi data pemohon, lalu bawa ke Balai
                                Desa Catur beserta berkas persyaratan untuk legalisasi.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. ALUR PENGURUSAN MANDIRI (MINIMALIS)                                    -->
    <!-- ========================================================================= -->
    <section class="w-full bg-slate-50/70 py-10 sm:py-12 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="text-center max-w-xl mx-auto space-y-1">
                <h2 class="font-serif text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                    Alur Pengurusan Surat Mandiri
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">

                {{-- Step 1 --}}
                <div class="p-5 rounded-xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                    <div
                        class="w-7 h-7 rounded-full border border-[#0A3D29]/20 bg-emerald-50 text-[#0A3D29] font-bold text-xs flex items-center justify-center">
                        1
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-sm text-slate-900">Unduh Template Berkas</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pilih template surat yang Anda butuhkan pada katalog di atas, lalu klik <strong>Unduh
                                Berkas</strong>.
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="p-5 rounded-xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                    <div
                        class="w-7 h-7 rounded-full border border-[#0A3D29]/20 bg-emerald-50 text-[#0A3D29] font-bold text-xs flex items-center justify-center">
                        2
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-sm text-slate-900">Isi Data &amp; Cetak Mandiri</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Buka berkas di komputer atau ponsel, isi formulir pemohon dengan benar, lalu cetak (print) di
                            kertas F4 / A4.
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="p-5 rounded-xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                    <div
                        class="w-7 h-7 rounded-full border border-[#0A3D29]/20 bg-emerald-50 text-[#0A3D29] font-bold text-xs flex items-center justify-center">
                        3
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-sm text-slate-900">Legalisasi di Balai Desa</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Bawa berkas cetak beserta dokumen persyaratan (KTP, KK, dsb.) ke Balai Desa Catur untuk tanda
                            tangan dan stempel resmi.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection