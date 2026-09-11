@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan Admin')

@section('content')
<div class="space-y-8" x-data="{ isReady: false }" x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 120); })">
    
    <!-- Top Executive Greeting Banner -->
    <div class="relative overflow-hidden rounded-[22px] bg-gradient-to-br from-[#072C21] via-[#0F4C3A] to-[#08382A] text-white p-7 sm:p-9 shadow-sm border border-[#0F4C3A]/70">
        <!-- Ambient Decorative Glows -->
        <div class="absolute -right-12 -top-12 w-72 h-72 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-16 w-56 h-56 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs border border-white/15 text-[11px] font-semibold text-emerald-200 uppercase tracking-wider mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    <span class="text-white/40">•</span>
                    <span>Pusat Kendali Operasional</span>
                </div>
                <h2 class="font-jakarta text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-emerald-100/90 text-sm mt-2 leading-relaxed font-normal">
                    Kelola profil desa, sediakan template surat resmi siap cetak bagi warga, tanggapi pengaduan, dan pantau publikasi Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                @if(Auth::user()->canAccessPublicServices())
                <a href="{{ route('admin.letter-templates.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-xs text-white text-xs font-semibold border border-white/20 transition-all duration-150">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span>Template Surat</span>
                    <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-400 text-slate-900">{{ $stats['letter_templates_count'] ?? 0 }}</span>
                </a>
                @endif
                @if(Auth::user()->canAccessPpko() && !Auth::user()->canAccessPublicServices())
                <a href="{{ route('admin.ppko.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-xs text-white text-xs font-semibold border border-white/20 transition-all duration-150">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Kelola PPK Ormawa</span>
                </a>
                @endif
                @if(Auth::user()->canAccessNews())
                <a href="{{ route('admin.news.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-[#072C21] hover:bg-emerald-50 text-xs font-bold shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tulis Berita Desa</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Bento Grid KPI Architecture -->
    <div class="relative min-h-[160px]" :aria-busy="!isReady">
        <!-- Skeleton Bento Grid (Initial Loading State) -->
        <div x-show="!isReady" 
             x-transition:leave="transition-opacity duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5"
             aria-hidden="true">
            <x-skeleton.stat-card class="lg:col-span-2" />
            <x-skeleton.stat-card />
            <x-skeleton.stat-card />
            <x-skeleton.stat-card />
        </div>

        <!-- Real Bento Grid (Fades in smoothly) -->
        <div x-show="isReady" 
             x-cloak
             x-transition:enter="transition-opacity duration-300 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Bento 1: Primary Highlight Card (Publikasi Berita) -->
        @if(Auth::user()->canAccessNews())
        <a href="{{ route('admin.news.index') }}" class="lg:col-span-2 bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-[#0F4C3A]/40 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-[#0F4C3A] border border-emerald-100/80 mb-3">
                        <svg class="w-3 h-3 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Publik Desa
                    </div>
                    <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Total Publikasi Berita</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h3 class="font-jakarta text-3xl sm:text-4xl font-extrabold text-[#0F172A] tabular-nums tracking-tight">
                            {{ number_format($stats['news_count'] ?? 0, 0, ',', '.') }}
                        </h3>
                        <span class="text-sm font-semibold text-slate-500">Artikel & Pengumuman</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-[#0F4C3A]/10 text-[#0F4C3A] flex items-center justify-center group-hover:scale-105 group-hover:bg-[#0F4C3A] group-hover:text-white transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
            
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Berita & Kabar Resmi Desa Catur</span>
                <span class="text-[#0F4C3A] font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Kelola Berita
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </div>
        </a>
        @endif

        <!-- Bento 2: Template Surat Siap Cetak -->
        @if(Auth::user()->canAccessPublicServices())
        <a href="{{ route('admin.letter-templates.index') }}" class="bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-[#0F4C3A]/40 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Layanan Dokumen</p>
                    <h3 class="font-jakarta text-2xl sm:text-3xl font-extrabold text-[#0F172A] tabular-nums tracking-tight mt-1.5">
                        {{ $stats['letter_templates_count'] ?? 0 }}
                    </h3>
                    <span class="text-xs font-semibold text-slate-500">
                        Template Siap Cetak
                    </span>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-[#0F4C3A] flex items-center justify-center group-hover:scale-105 group-hover:bg-[#0F4C3A] group-hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Pelayanan Mandiri</span>
                <span class="text-[#0F4C3A] font-semibold group-hover:translate-x-1 transition-transform">Kelola Berkas →</span>
            </div>
        </a>

        <!-- Bento 3: Pengaduan Baru (Attention Card) -->
        <a href="{{ route('admin.complaints.index') }}" class="bg-white rounded-[20px] p-6 border {{ ($stats['new_complaints_count'] ?? 0) > 0 ? 'border-rose-200 bg-gradient-to-b from-rose-50/20 to-white' : 'border-[#E2E8F0]' }} shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-rose-400 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-1.5">
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Pengaduan Baru</p>
                        @if(($stats['new_complaints_count'] ?? 0) > 0)
                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        @endif
                    </div>
                    <h3 class="font-jakarta text-2xl sm:text-3xl font-extrabold text-[#0F172A] tabular-nums tracking-tight mt-1.5">
                        {{ $stats['new_complaints_count'] ?? 0 }}
                    </h3>
                    <span class="text-xs font-semibold {{ ($stats['new_complaints_count'] ?? 0) > 0 ? 'text-rose-700' : 'text-slate-400' }}">
                        {{ ($stats['new_complaints_count'] ?? 0) > 0 ? 'Aspirasi Warga Masuk' : 'Tidak Ada Laporan Baru' }}
                    </span>
                </div>
                <div class="w-11 h-11 rounded-2xl {{ ($stats['new_complaints_count'] ?? 0) > 0 ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center group-hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Kritik & Aspirasi</span>
                <span class="text-rose-700 font-semibold group-hover:translate-x-1 transition-transform">Tanggapi →</span>
            </div>
        </a>
        @endif

        <!-- Bento 4: Perangkat Desa -->
        @if(Auth::user()->canAccessOfficials())
        <a href="{{ route('admin.officials.index') }}" class="bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-[#0F4C3A]/40 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Pemerintahan</p>
                    <h3 class="font-jakarta text-2xl sm:text-3xl font-extrabold text-[#0F172A] tabular-nums tracking-tight mt-1.5">
                        {{ $stats['officials_count'] ?? 0 }}
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Aparatur & Perangkat</span>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-800 flex items-center justify-center group-hover:scale-105 group-hover:bg-amber-600 group-hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Struktur Organisasi</span>
                <span class="text-[#0F4C3A] font-semibold group-hover:translate-x-1 transition-transform">Struktur Desa →</span>
            </div>
        </a>
        @endif

        <!-- Bento 5: Foto Galeri -->
        @if(Auth::user()->canAccessGalleries())
        <a href="{{ route('admin.galleries.index') }}" class="bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-[#0F4C3A]/40 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Galeri Foto</p>
                    <h3 class="font-jakarta text-2xl sm:text-3xl font-extrabold text-[#0F172A] tabular-nums tracking-tight mt-1.5">
                        {{ $stats['galleries_count'] ?? 0 }}
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Dokumentasi Kegiatan</span>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Album Dokumentasi</span>
                <span class="text-[#0F4C3A] font-semibold group-hover:translate-x-1 transition-transform">Lihat Galeri →</span>
            </div>
        </a>
        @endif

        <!-- Bento 6: PPK Ormawa -->
        @if(Auth::user()->canAccessPpko())
        <a href="{{ route('admin.ppko.index') }}" class="bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-[#0F4C3A]/40 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">PPK Ormawa</p>
                    <h3 class="font-jakarta text-2xl sm:text-3xl font-extrabold text-[#0F172A] tabular-nums tracking-tight mt-1.5">
                        {{ $stats['pojoks_count'] ?? 4 }}
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Pojok Cerdas Catur</span>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-[#D9B85C]/20 text-[#7A5A00] flex items-center justify-center group-hover:scale-105 group-hover:bg-[#0F4C3A] group-hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Modul & Program PPKO</span>
                <span class="text-[#0F4C3A] font-semibold group-hover:translate-x-1 transition-transform">Kelola PPKO →</span>
            </div>
        </a>
        @endif

        <!-- Bento 7: Kelola Pengguna (Super Admin Only) -->
        @if(Auth::user()->canManageUsers())
        <a href="{{ route('admin.users.index') }}" class="bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:shadow-md hover:border-purple-400 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Pengguna Sistem</p>
                    <h3 class="font-jakarta text-2xl sm:text-3xl font-extrabold text-[#0F172A] tabular-nums tracking-tight mt-1.5">
                        {{ $stats['users_count'] ?? 0 }}
                    </h3>
                    <span class="text-xs font-semibold text-purple-700">Administrator & Operator</span>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center group-hover:scale-105 group-hover:bg-purple-600 group-hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Hak Akses & Role</span>
                <span class="text-purple-700 font-semibold group-hover:translate-x-1 transition-transform">Kelola Akun →</span>
            </div>
        </a>
        @endif

        </div>
    </div>

    <!-- Bento Data Table: Berita Terbaru yang Diterbitkan -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-[0_1px_3px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="p-6 border-b border-[#E2E8F0] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-jakarta text-lg font-bold text-[#0F172A]">Berita Terbaru Desa</h3>
                <p class="text-xs text-[#64748B] mt-0.5">Daftar publikasi kabar, agenda, dan artikel resmi yang tayang pada portal publik Desa Catur.</p>
            </div>
            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Berita Baru</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                        <th class="px-6 py-3.5">Judul Berita</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Status Publikasi</th>
                        <th class="px-6 py-3.5">Tanggal Terbit</th>
                        <th class="px-6 py-3.5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9]" :aria-busy="!isReady">
                    <!-- Skeleton Rows While Initializing -->
                    @for($i = 0; $i < 4; $i++)
                        <x-skeleton.table-row />
                    @endfor

                    <!-- Real Data Rows -->
                    @forelse($latestNews as $news)
                        <tr x-show="isReady" x-cloak class="hover:bg-[#F8FAFC]/80 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-[#0F172A] max-w-md truncate">{{ $news->title }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $news->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($news->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#DCFCE7] text-[#15803D]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                                        <span>Tayang</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Draft</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 tabular-nums">
                                {{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.news.edit', $news->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-[#E2E8F0] text-xs font-semibold text-[#0F4C3A] hover:bg-[#F4F6F5] hover:border-[#0F4C3A]/30 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr x-show="isReady" x-cloak>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <p class="text-xs font-medium">Belum ada data berita yang dipublikasikan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
