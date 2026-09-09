@extends('layouts.public')

@section('title', 'Laporan & Pengaduan Warga - Pemerintah Desa Catur')
@section('meta_description', 'Layanan aspirasi, keluhan fasilitas umum, dan laporan pengaduan warga secara terbuka kepada Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali.')

@section('content')

    {{-- Session Flash Notifications --}}
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
    <!-- 1. MAIN SECTION: KATALOG LAPORAN & PENGADUAN WARGA                        -->
    <!-- ========================================================================= -->
    <section id="katalog-pengaduan" class="w-full bg-white py-8 sm:py-12 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Top Filter & Search Bar (Minimalist Dark Green) --}}
            <div class="bg-[#0A3D29] text-white rounded-xl p-5 sm:p-6 border border-[#072B1D] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="font-serif text-lg sm:text-xl font-bold text-white tracking-tight">
                        Laporan &amp; Pengaduan Warga
                    </h2>
                    <p class="text-xs text-white/80 leading-relaxed max-w-xl">
                        Sampaikan aspirasi atau keluhan fasilitas umum secara terbuka kepada Pemerintah Desa Catur.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 shrink-0">
                    <a href="{{ route('warga.complaint.create') }}" 
                       class="inline-flex items-center justify-center gap-1.5 bg-white hover:bg-emerald-50 text-[#0A3D29] text-xs font-bold px-3.5 py-2.5 rounded-lg transition shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tulis Laporan Baru</span>
                    </a>

                    {{-- Search Form --}}
                    <div class="w-full sm:w-72">
                        <form action="{{ route('warga.complaint.index') }}#katalog-pengaduan" method="GET" class="relative">
                            @if(!empty($selectedCategory))
                                <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                            @endif
                            @if(!empty($selectedStatus))
                                <input type="hidden" name="status" value="{{ $selectedStatus }}">
                            @endif
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search ?? '' }}" 
                                   placeholder="Cari judul atau nomor tiket..." 
                                   class="w-full pl-8 pr-16 py-2.5 rounded-lg border border-transparent focus:ring-2 focus:ring-emerald-400 focus:outline-hidden text-xs sm:text-sm bg-white text-slate-900 placeholder:text-slate-400 transition">
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <div class="absolute right-1.5 top-1.5 flex items-center gap-1">
                                @if(!empty($search))
                                    <a href="{{ route('warga.complaint.index', array_filter(['kategori' => $selectedCategory, 'status' => $selectedStatus])) }}#katalog-pengaduan" 
                                       class="text-xs text-slate-400 hover:text-slate-700 px-1 py-1"
                                       title="Hapus pencarian">
                                        ✕
                                    </a>
                                @endif
                                <button type="submit" 
                                        class="bg-[#0A3D29] hover:bg-[#072B1D] text-white text-xs font-semibold px-2.5 py-1 rounded-md transition">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Category & Status Filter Tabs (Minimalist) --}}
            <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                {{-- Category Filters --}}
                <div class="flex flex-wrap items-center gap-1.5 text-xs">
                    <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'status' => $selectedStatus])) }}#katalog-pengaduan"
                       class="px-3 py-1.5 rounded-lg font-medium transition {{ empty($selectedCategory) ? 'bg-[#0A3D29] text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('warga.complaint.index', array_filter(['kategori' => $cat->id, 'search' => $search, 'status' => $selectedStatus])) }}#katalog-pengaduan"
                           class="px-3 py-1.5 rounded-lg font-medium transition {{ $selectedCategory == $cat->id ? 'bg-[#0A3D29] text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                {{-- Status Filter --}}
                <div class="flex items-center gap-1 text-xs">
                    <span class="text-slate-400 font-medium mr-1">Status:</span>
                    <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'kategori' => $selectedCategory])) }}#katalog-pengaduan"
                       class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition {{ empty($selectedStatus) ? 'bg-slate-800 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                        Semua
                    </a>
                    <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'kategori' => $selectedCategory, 'status' => 'new'])) }}#katalog-pengaduan"
                       class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition {{ $selectedStatus === 'new' ? 'bg-rose-100 text-rose-800 font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Menunggu
                    </a>
                    <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'kategori' => $selectedCategory, 'status' => 'processing'])) }}#katalog-pengaduan"
                       class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition {{ $selectedStatus === 'processing' ? 'bg-amber-100 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Diproses
                    </a>
                    <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'kategori' => $selectedCategory, 'status' => 'resolved'])) }}#katalog-pengaduan"
                       class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition {{ $selectedStatus === 'resolved' ? 'bg-emerald-100 text-emerald-800 font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Selesai
                    </a>
                </div>
            </div>

            {{-- Complaints Cards Grid (Minimalist, Clickable) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($complaints as $cmp)
                    <a href="{{ route('warga.complaint.show', $cmp->id) }}"
                       class="bg-white rounded-xl p-5 sm:p-6 border border-slate-200/90 hover:border-emerald-700/60 shadow-2xs hover:shadow-xs transition-colors flex flex-col justify-between cursor-pointer group">
                        
                        <div class="space-y-3.5">
                            
                            {{-- Header: Ticket Number & Status Badge --}}
                            <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-slate-100">
                                <span class="font-mono text-xs font-semibold text-slate-500 inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span>{{ $cmp->ticket_number }}</span>
                                </span>

                                @if($cmp->status === 'new')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Menunggu</span>
                                    </span>
                                @elseif($cmp->status === 'processing')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Diproses</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>Selesai</span>
                                    </span>
                                @endif
                            </div>

                            {{-- Category & Date --}}
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-[11px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                    {{ $cmp->category ? $cmp->category->name : 'Umum' }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    {{ $cmp->created_at ? $cmp->created_at->translatedFormat('d M Y') : '-' }}
                                </span>
                            </div>

                            {{-- Title & Description --}}
                            <div class="space-y-1.5">
                                <h3 class="font-serif text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                    {{ $cmp->title }}
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                                    {{ $cmp->description }}
                                </p>
                            </div>

                            {{-- Response Preview Pill if available --}}
                            @if(!empty($cmp->admin_response))
                                <div class="bg-emerald-50/70 border border-emerald-200/60 rounded-lg p-2.5 text-xs text-emerald-900 space-y-1">
                                    <div class="flex items-center gap-1.5 font-semibold text-[11px] text-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Tanggapan Resmi Pemdes:</span>
                                    </div>
                                    <p class="line-clamp-2 text-[11px] text-emerald-950/80 leading-snug">
                                        {{ $cmp->admin_response }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        {{-- Action Footer --}}
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400 text-[11px]">
                                @if($cmp->attachment_path)
                                    <span class="inline-flex items-center gap-1 text-slate-500">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Ada Foto</span>
                                    </span>
                                @else
                                    <span>Laporan Warga</span>
                                @endif
                            </span>

                            <span class="text-[#0A3D29] group-hover:text-[#072B1D] font-semibold inline-flex items-center gap-0.5 transition-colors">
                                <span>Lihat Detail</span>
                                <span>→</span>
                            </span>
                        </div>

                    </a>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500 bg-white rounded-xl border border-slate-200 p-6">
                        <h4 class="text-base font-bold text-slate-800">Tidak ada laporan pengaduan</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            @if(!empty($search) || !empty($selectedCategory) || !empty($selectedStatus))
                                Tidak ada pengaduan yang sesuai dengan filter atau kata kunci penelusuran.
                            @else
                                Belum ada laporan aspirasi warga yang dipublikasikan.
                            @endif
                        </p>
                        <div class="pt-4 flex items-center justify-center gap-2">
                            @if(!empty($search) || !empty($selectedCategory) || !empty($selectedStatus))
                                <a href="{{ route('warga.complaint.index') }}#katalog-pengaduan" 
                                   class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 font-medium text-xs px-4 py-2 rounded-lg hover:bg-slate-200 transition">
                                    <span>Reset Filter</span>
                                </a>
                            @endif
                            <a href="{{ route('warga.complaint.create') }}" 
                               class="inline-flex items-center gap-1.5 bg-[#0A3D29] text-white font-medium text-xs px-4 py-2 rounded-lg hover:bg-[#072B1D] transition">
                                <span>Buat Laporan Baru</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($complaints->hasPages())
                <div class="pt-4">
                    {{ $complaints->links() }}
                </div>
            @endif

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 2. ALUR PENANGANAN ASPIRASI & PENGADUAN (3 LANGKAH)                       -->
    <!-- ========================================================================= -->
    <section class="w-full bg-white py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Alur Penanganan Aspirasi &amp; Pengaduan
                </h2>
                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                    Tahapan transparan penanganan laporan dan masukan warga oleh Pemerintah Desa Catur.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                {{-- Step 1 --}}
                <div class="p-5 sm:p-6 rounded-xl bg-[#0A3D29] text-white border border-[#072B1D] shadow-xs space-y-3">
                    <div class="w-8 h-8 rounded-lg bg-white text-[#0A3D29] font-black text-xs flex items-center justify-center shadow-xs">
                        1
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-base text-white">Sampaikan Laporan</h3>
                        <p class="text-xs text-white/80 leading-relaxed">
                            Isi formulir secara lengkap, tentukan kategori persoalan, serta lampirkan foto dokumentasi pendukung bila ada. Anda akan mendapatkan Nomor Tiket resmi.
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="p-5 sm:p-6 rounded-xl bg-[#0A3D29] text-white border border-[#072B1D] shadow-xs space-y-3">
                    <div class="w-8 h-8 rounded-lg bg-white text-[#0A3D29] font-black text-xs flex items-center justify-center shadow-xs">
                        2
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-base text-white">Verifikasi &amp; Tindak Lanjut</h3>
                        <p class="text-xs text-white/80 leading-relaxed">
                            Pemerintah Desa Catur memverifikasi rincian laporan dan berkoordinasi langsung dengan pihak terkait maupun pengurus wilayah untuk langkah penanganan.
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="p-5 sm:p-6 rounded-xl bg-[#0A3D29] text-white border border-[#072B1D] shadow-xs space-y-3">
                    <div class="w-8 h-8 rounded-lg bg-white text-[#0A3D29] font-black text-xs flex items-center justify-center shadow-xs">
                        3
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-base text-white">Tanggapan Resmi &amp; Solusi</h3>
                        <p class="text-xs text-white/80 leading-relaxed">
                            Hasil tindak lanjut dan tanggapan resmi dipublikasikan secara terbuka pada portal ini. Warga dapat memantau status laporan secara berkala.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
