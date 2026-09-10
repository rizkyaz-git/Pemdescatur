@extends('layouts.public')

@section('title', 'Laporan & Pengaduan Warga - Pemerintah Desa Catur')
@section('meta_description', 'Layanan aspirasi, keluhan fasilitas umum, dan laporan pengaduan warga secara terbuka kepada Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali.')

@section('content')

    @php
        $complaintsData = $complaints->map(function ($cmp) {
            return [
                'id' => $cmp->id,
                'title' => $cmp->title,
                'category' => $cmp->category ? $cmp->category->name : 'Umum',
                'description' => $cmp->description,
                'status' => $cmp->status,
                'date' => $cmp->created_at ? $cmp->created_at->translatedFormat('d M Y') : '-',
                'full_date' => $cmp->created_at ? $cmp->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-',
                'attachment_url' => $cmp->attachment_path ? asset('storage/' . $cmp->attachment_path) : null,
                'admin_response' => $cmp->admin_response,
                'responded_at' => $cmp->responded_at ? \Carbon\Carbon::parse($cmp->responded_at)->translatedFormat('d F Y, H:i') . ' WIB' : null,
            ];
        });
    @endphp

    <!-- Main Page Container (Clean Minimalist Canvas) -->
    <div class="bg-white min-h-screen py-8 sm:py-10" x-data="{ 
             complaints: {{ Js::from($complaintsData) }},
             selectedComplaint: null,
             mobileView: 'menu',
             selectComplaint(item) {
                 this.selectedComplaint = item;
                 this.mobileView = 'detail';
                 if (window.innerWidth < 1024) {
                     const el = document.getElementById('katalog-pengaduan');
                     if (el) {
                         el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                     }
                 }
             },
             backToMenu() {
                 this.mobileView = 'menu';
             }
         }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" id="katalog-pengaduan">

            <!-- Session Flash Notifications (Minimalist) -->
            @if(session('success'))
                <div
                    class="bg-emerald-50/80 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-xs sm:text-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Minimalist Header Title & Search / Action -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6 pb-6 border-b border-slate-200/80">
                <div>
                    <h1
                        class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#20332A] leading-tight tracking-tight">
                        Laporan &amp; Pengaduan Warga
                    </h1>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 shrink-0">
                    <a href="{{ route('warga.complaint.create') }}" 
                       class="inline-flex items-center justify-center gap-1.5 bg-[#0A3D29] hover:bg-[#072B1D] text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition shadow-xs">
                        <svg class="w-3.5 h-3.5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tulis Laporan Baru</span>
                    </a>

                    {{-- Search Form --}}
                    <div class="w-full sm:w-72 md:w-80">
                        <form action="{{ route('warga.complaint.index') }}#katalog-pengaduan" method="GET" class="relative">
                            @if(!empty($selectedStatus))
                                <input type="hidden" name="status" value="{{ $selectedStatus }}">
                            @endif
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search ?? '' }}" 
                                   placeholder="Cari laporan pengaduan..." 
                                   class="w-full pl-9 pr-16 py-2.5 rounded-lg border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder:text-slate-400 bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-1 focus:ring-[#0A3D29]/30 transition shadow-xs">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <div class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center gap-1">
                                @if(!empty($search))
                                    <a href="{{ route('warga.complaint.index', array_filter(['status' => $selectedStatus])) }}#katalog-pengaduan" 
                                       class="text-xs text-slate-400 hover:text-slate-600 px-1 py-0.5"
                                       title="Hapus pencarian">
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
            </div>

            {{-- Status Filter Tabs (Minimalist) --}}
            <div class="flex items-center gap-1.5 overflow-x-auto text-xs py-1">
                <span class="text-slate-400 font-medium mr-1 text-[11px]">Status:</span>
                <a href="{{ route('warga.complaint.index', array_filter(['search' => $search])) }}#katalog-pengaduan"
                   class="px-3 py-1 rounded-full text-xs transition {{ empty($selectedStatus) ? 'bg-[#0A3D29] text-white font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    Semua
                </a>
                <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'status' => 'new'])) }}#katalog-pengaduan"
                   class="px-3 py-1 rounded-full text-xs transition {{ $selectedStatus === 'new' ? 'bg-[#0A3D29] text-white font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    Menunggu
                </a>
                <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'status' => 'processing'])) }}#katalog-pengaduan"
                   class="px-3 py-1 rounded-full text-xs transition {{ $selectedStatus === 'processing' ? 'bg-[#0A3D29] text-white font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    Diproses
                </a>
                <a href="{{ route('warga.complaint.index', array_filter(['search' => $search, 'status' => 'resolved'])) }}#katalog-pengaduan"
                   class="px-3 py-1 rounded-full text-xs transition {{ $selectedStatus === 'resolved' ? 'bg-[#0A3D29] text-white font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    Selesai
                </a>
            </div>

            <!-- ========================================================================= -->
            <!-- KATALOG PENGADUAN: MASTER-DETAIL INTERAKTIF (RESPONSIF KIRI-KANAN)         -->
            <!-- ========================================================================= -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start pt-2">

                <!-- Left Side: List Laporan Pengaduan -->
                <div class="lg:col-span-5" :class="mobileView === 'detail' ? 'hidden lg:block' : 'block'">
                    <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-xs">
                        <!-- Header Daftar Laporan -->
                        <div class="px-4 py-3 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                            <h2 class="text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Daftar Laporan ({{ $complaints->total() }})
                            </h2>
                            @if(!empty($search) || !empty($selectedStatus))
                                <a href="{{ route('warga.complaint.index') }}#katalog-pengaduan"
                                    class="text-xs text-[#0A3D29] hover:underline font-medium">
                                    Reset filter
                                </a>
                            @endif
                        </div>

                        <div class="divide-y divide-slate-100 max-h-[640px] overflow-y-auto">
                            <template x-for="item in complaints" :key="item.id">
                                <button type="button" @click="selectComplaint(item)"
                                    class="w-full text-left p-4 transition-all flex items-start justify-between gap-3 group cursor-pointer"
                                    :class="selectedComplaint && selectedComplaint.id === item.id 
                                            ? 'bg-slate-100/90' 
                                            : 'hover:bg-slate-50/80'">
                                    <div class="space-y-1.5 flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5 text-[11px]">
                                            <span class="font-medium text-slate-500" x-text="item.category"></span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-slate-400" x-text="item.date"></span>
                                        </div>
                                        <h3 class="font-serif text-sm font-bold text-slate-900 group-hover:text-slate-950 transition-colors line-clamp-1"
                                            x-text="item.title"></h3>
                                        <p class="text-xs text-slate-500 line-clamp-2" x-text="item.description"></p>
                                        
                                        <div class="pt-0.5 flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                                            <span class="w-1.5 h-1.5 rounded-full"
                                                :class="{
                                                    'bg-slate-400': item.status === 'new',
                                                    'bg-amber-500': item.status === 'processing',
                                                    'bg-[#0A3D29]': item.status === 'resolved'
                                                }"></span>
                                            <span x-text="item.status === 'new' ? 'Menunggu' : (item.status === 'processing' ? 'Diproses' : 'Selesai')"></span>
                                            
                                            <template x-if="item.admin_response">
                                                <span class="text-slate-400 text-[10px]"> • Ditanggapi</span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="shrink-0 text-slate-300 group-hover:text-slate-500 transition-colors mt-1"
                                        :class="selectedComplaint && selectedComplaint.id === item.id ? 'text-slate-600' : ''">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </button>
                            </template>

                            @if(count($complaints) === 0)
                                <div class="p-8 text-center text-slate-500">
                                    <p class="text-sm font-medium text-slate-700">Tidak ada laporan pengaduan yang cocok</p>
                                    @if(!empty($search) || !empty($selectedStatus))
                                        <p class="text-xs text-slate-400 mt-1">Tidak ada pengaduan yang sesuai dengan filter atau kata kunci penelusuran.</p>
                                        <a href="{{ route('warga.complaint.index') }}#katalog-pengaduan"
                                            class="inline-block mt-3 text-xs font-semibold text-[#0A3D29] hover:underline">
                                            Reset Filter
                                        </a>
                                    @else
                                        <p class="text-xs text-slate-400 mt-1">Belum ada laporan aspirasi warga yang dipublikasikan.</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if($complaints->hasPages())
                            <div class="px-4 py-3 bg-slate-50/70 border-t border-slate-100">
                                {{ $complaints->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Rincian Laporan Pengaduan (Sticky Detail Panel) -->
                <div class="lg:col-span-7 lg:sticky lg:top-24" :class="mobileView === 'menu' ? 'hidden lg:block' : 'block'">

                    <!-- Mobile Back Navigation -->
                    <button type="button" @click="backToMenu()"
                        class="lg:hidden inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 pb-2 mb-4 border-b border-slate-100 w-full transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Kembali ke Daftar Laporan</span>
                    </button>

                    <!-- Empty State: Ketika belum ada laporan yang dipilih -->
                    <div x-show="!selectedComplaint"
                        class="bg-white rounded-xl border border-dashed border-slate-300/80 p-12 text-center flex flex-col items-center justify-center min-h-[380px] shadow-xs space-y-3">
                        <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-700">Pilih laporan untuk rincian</h3>
                    </div>

                    <!-- Active State: Rincian Lengkap Laporan Terpilih -->
                    <div x-show="selectedComplaint" x-cloak
                        class="bg-white rounded-xl border border-slate-200/90 p-6 sm:p-7 shadow-xs space-y-6">

                        <!-- Detail Header -->
                        <div class="pb-5 border-b border-slate-100 space-y-3">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-600"
                                        x-text="selectedComplaint ? selectedComplaint.category : ''"></span>
                                    <span class="text-xs text-slate-400"
                                        x-text="selectedComplaint ? selectedComplaint.full_date : ''"></span>
                                </div>

                                <div>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border"
                                        :class="{
                                            'border-slate-200 bg-slate-50 text-slate-700': selectedComplaint && selectedComplaint.status === 'new',
                                            'border-amber-200/70 bg-amber-50/50 text-amber-800': selectedComplaint && selectedComplaint.status === 'processing',
                                            'border-emerald-200/70 bg-emerald-50/50 text-[#0A3D29]': selectedComplaint && selectedComplaint.status === 'resolved'
                                        }">
                                        <span class="w-1.5 h-1.5 rounded-full"
                                            :class="{
                                                'bg-slate-400': selectedComplaint && selectedComplaint.status === 'new',
                                                'bg-amber-500': selectedComplaint && selectedComplaint.status === 'processing',
                                                'bg-[#0A3D29]': selectedComplaint && selectedComplaint.status === 'resolved'
                                            }"></span>
                                        <span x-text="selectedComplaint ? (selectedComplaint.status === 'new' ? 'Menunggu Respon' : (selectedComplaint.status === 'processing' ? 'Sedang Ditindaklanjuti' : 'Selesai Ditanggapi')) : ''"></span>
                                    </span>
                                </div>
                            </div>

                            <h3 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 leading-tight"
                                x-text="selectedComplaint ? selectedComplaint.title : ''"></h3>
                        </div>

                        <!-- Detail Description -->
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                                Rincian Laporan
                            </span>
                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line"
                                x-text="selectedComplaint ? selectedComplaint.description : ''"></p>
                        </div>

                        <!-- Attachment Photo if available -->
                        <template x-if="selectedComplaint && selectedComplaint.attachment_url">
                            <div class="space-y-2 pt-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                                    Lampiran Foto Bukti
                                </span>
                                <a :href="selectedComplaint.attachment_url" target="_blank" class="inline-block group">
                                    <img :src="selectedComplaint.attachment_url" 
                                         alt="Lampiran Bukti Pengaduan" 
                                         class="max-h-64 rounded-lg border border-slate-200 shadow-xs group-hover:opacity-95 transition">
                                    <span class="text-[11px] text-slate-400 group-hover:text-[#0A3D29] mt-1 block">
                                        Klik untuk melihat ukuran penuh ↗
                                    </span>
                                </a>
                            </div>
                        </template>

                        <!-- Official Village Response -->
                        <div class="pt-4 border-t border-slate-100">
                            <template x-if="selectedComplaint && selectedComplaint.admin_response">
                                <div class="bg-slate-50/80 border border-slate-200 rounded-xl p-5 space-y-2">
                                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-[#0A3D29]"></span>
                                            <h4 class="font-serif font-bold text-xs sm:text-sm text-slate-900">
                                                Tanggapan Resmi Pemerintah Desa Catur
                                            </h4>
                                        </div>
                                        <span class="text-[11px] text-slate-500" x-text="selectedComplaint.responded_at || ''"></span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-800 whitespace-pre-line leading-relaxed pt-1"
                                        x-text="selectedComplaint.admin_response"></p>
                                </div>
                            </template>

                            <template x-if="selectedComplaint && !selectedComplaint.admin_response">
                                <div class="bg-slate-50/60 border border-slate-200/70 rounded-xl p-4 text-center space-y-1">
                                    <p class="text-xs font-semibold text-slate-700">Laporan Telah Diterima Sistem</p>
                                    <p class="text-xs text-slate-500">
                                        Pengaduan ini sedang dalam antrean verifikasi dan akan segera ditanggapi oleh Pemerintah Desa Catur.
                                    </p>
                                </div>
                            </template>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 2. ALUR PENANGANAN ASPIRASI & PENGADUAN (MINIMALIS)                       -->
    <!-- ========================================================================= -->
    <section class="w-full bg-slate-50/70 py-10 sm:py-12 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="text-center max-w-xl mx-auto space-y-1">
                <h2 class="font-serif text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                    Alur Penanganan Aspirasi &amp; Pengaduan
                </h2>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Tahapan transparan penanganan laporan dan masukan warga oleh Pemerintah Desa Catur.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                
                {{-- Step 1 --}}
                <div class="p-5 rounded-xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-7 h-7 rounded-full border border-[#0A3D29]/20 bg-emerald-50 text-[#0A3D29] font-bold text-xs flex items-center justify-center">
                        1
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-sm text-slate-900">Sampaikan Laporan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Isi formulir secara lengkap, tentukan kategori persoalan, serta lampirkan foto dokumentasi pendukung bila ada. Laporan Anda akan tercatat secara resmi.
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="p-5 rounded-xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-7 h-7 rounded-full border border-[#0A3D29]/20 bg-emerald-50 text-[#0A3D29] font-bold text-xs flex items-center justify-center">
                        2
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-sm text-slate-900">Verifikasi &amp; Tindak Lanjut</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pemerintah Desa Catur memverifikasi rincian laporan dan berkoordinasi langsung dengan pihak terkait maupun pengurus wilayah untuk langkah penanganan.
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="p-5 rounded-xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-7 h-7 rounded-full border border-[#0A3D29]/20 bg-emerald-50 text-[#0A3D29] font-bold text-xs flex items-center justify-center">
                        3
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif font-bold text-sm text-slate-900">Tanggapan Resmi &amp; Solusi</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Hasil tindak lanjut dan tanggapan resmi dipublikasikan secara terbuka pada portal ini. Warga dapat memantau status laporan secara berkala.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
