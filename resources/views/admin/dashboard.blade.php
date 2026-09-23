@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan Admin')

@section('content')
    <div class="space-y-6" x-data="{ 
                 isReady: false, 
                 search: '',
                 get filteredCount() {
                     if (!this.search.trim()) return 1;
                     const term = this.search.toLowerCase().trim();
                     const titles = Array.from(document.querySelectorAll('[data-news-title]')).map(el => el.getAttribute('data-news-title').toLowerCase());
                     return titles.filter(t => t.includes(term)).length;
                 }
             }" x-init="$nextTick(() => { setTimeout(() => { isReady = true; }, 100); })">

        <!-- Page Heading Area (Standard Admin Typography & Spacing) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-1">
            <div>
                <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">
                    Dashboard Admin
                </h1>
                <p class="text-xs text-[#64748B] mt-1 flex items-center gap-2 font-medium">
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>
        </div>

        <!-- 3 Core Metric Cards (Standard Admin Styling: Radius 12-14px, #E2E8F0 Border) -->
        <div class="relative min-h-[130px]" :aria-busy="!isReady">
            <!-- Skeleton Loading State -->
            <div x-show="!isReady" x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="grid grid-cols-1 md:grid-cols-3 gap-5" aria-hidden="true">
                <x-skeleton.stat-card />
                <x-skeleton.stat-card />
                <x-skeleton.stat-card />
            </div>

            <!-- Real 3 Metric Cards -->
            <div x-show="isReady" x-cloak x-transition:enter="transition-opacity duration-200 ease-out"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- Metric 1: Informasi Publik Desa -->
                @if(Auth::user()->canAccessNews())
                    <a href="{{ route('admin.news.index') }}"
                        class="bg-white rounded-[14px] p-5 border border-[#E2E8F0] shadow-xs hover:border-[#0F4C3A]/40 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Informasi Publik Desa</span>
                                <svg class="w-4 h-4 text-[#64748B] group-hover:text-[#0F4C3A] transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="mt-2.5">
                                <span class="font-jakarta text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight tabular-nums block">
                                    {{ number_format($stats['news_count'] ?? 0, 0, ',', '.') }}
                                </span>
                                <p class="text-xs text-[#64748B] mt-1 font-medium">Artikel & Pengumuman</p>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs font-semibold text-[#0F4C3A]">
                            <span>Kelola Berita</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                        </div>
                    </a>
                @endif

                <!-- Metric 2: Layanan Dokumen -->
                @if(Auth::user()->canAccessPublicServices())
                    <a href="{{ route('admin.letter-templates.index') }}"
                        class="bg-white rounded-[14px] p-5 border border-[#E2E8F0] shadow-xs hover:border-[#0F4C3A]/40 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Layanan Dokumen</span>
                                <svg class="w-4 h-4 text-[#64748B] group-hover:text-[#0F4C3A] transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="mt-2.5">
                                <span class="font-jakarta text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight tabular-nums block">
                                    {{ number_format($stats['letter_templates_count'] ?? 0, 0, ',', '.') }}
                                </span>
                                <p class="text-xs text-[#64748B] mt-1 font-medium">Template Siap Cetak</p>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs font-semibold text-[#0F4C3A]">
                            <span>Kelola Template</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                        </div>
                    </a>
                @endif

                <!-- Metric 3: Pengaduan Baru (Contextual) -->
                @php 
                    $newComplaints = $stats['new_complaints_count'] ?? 0; 
                @endphp
                <a href="{{ route('admin.complaints.index') }}"
                    class="bg-white rounded-[14px] p-5 border {{ $newComplaints > 0 ? 'border-amber-300 bg-amber-50/10' : 'border-[#E2E8F0]' }} shadow-xs hover:border-[#0F4C3A]/40 transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Pengaduan Baru</span>
                            <svg class="w-4 h-4 {{ $newComplaints > 0 ? 'text-amber-500' : 'text-[#64748B]' }} group-hover:text-[#0F4C3A] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <div class="mt-2.5">
                            <span class="font-jakarta text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight tabular-nums block">
                                {{ number_format($newComplaints, 0, ',', '.') }}
                            </span>
                            @if($newComplaints > 0)
                                <p class="text-xs text-amber-700 font-semibold mt-1 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span>Aspirasi Masuk</span>
                                </p>
                            @else
                                <p class="text-xs text-[#64748B] font-medium mt-1 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Tidak ada laporan baru</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between text-xs font-semibold {{ $newComplaints > 0 ? 'text-amber-800' : 'text-[#0F4C3A]' }}">
                        <span>{{ $newComplaints > 0 ? 'Tanggapi Pengaduan' : 'Tanggapi' }}</span>
                        <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                    </div>
                </a>

            </div>
        </div>

        <!-- Main Operational Content: Berita Terbaru Desa (Radius 12-14px, Rectangular-soft Buttons) -->
        <div class="bg-white rounded-[14px] border border-[#E2E8F0] shadow-xs overflow-hidden">
            <!-- Table Header Control Bar -->
            <div class="p-5 border-b border-[#E2E8F0] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-jakarta font-extrabold text-lg text-slate-900 tracking-tight">Berita Terbaru Desa</h3>
                    <p class="text-xs text-[#64748B] mt-0.5">Daftar publikasi berita dan artikel resmi terbaru Desa Catur.</p>
                </div>

                <div class="flex items-center gap-2.5 shrink-0">
                    <!-- Compact Search (Rectangular-soft: radius 8px) -->
                    <div class="relative">
                        <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" x-model="search" placeholder="Cari berita..."
                            class="w-44 sm:w-56 pl-8 pr-3 py-2 text-xs rounded-lg border border-[#E2E8F0] bg-[#F8FAFC]/50 text-[#0F172A] placeholder-slate-400 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition">
                    </div>

                    <!-- Add News CTA (Rectangular-soft: radius 8px) -->
                    @if(Auth::user()->canAccessNews())
                        <a href="{{ route('admin.news.create') }}"
                            class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-xs transition shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah Berita</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                            <th class="px-5 py-3.5 font-bold">Judul Berita</th>
                            <th class="px-5 py-3.5 font-bold">Kategori</th>
                            <th class="px-5 py-3.5 font-bold">Status</th>
                            <th class="px-5 py-3.5 font-bold">Tanggal Terbit</th>
                            <th class="px-5 py-3.5 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]" :aria-busy="!isReady">
                        <!-- Skeleton Rows While Initializing -->
                        @for($i = 0; $i < 4; $i++)
                            <x-skeleton.table-row />
                        @endfor

                        <!-- Real Data Rows -->
                        @forelse($latestNews as $news)
                            <tr x-show="isReady && (!search || '{{ strtolower(addslashes($news->title)) }}'.includes(search.toLowerCase().trim()))"
                                x-cloak data-news-title="{{ $news->title }}" class="hover:bg-[#F8FAFC]/80 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="font-semibold text-[#0F172A] max-w-sm sm:max-w-md truncate">{{ $news->title }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-[#0F4C3A] border border-emerald-200/80">
                                        {{ $news->category }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
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
                                <td class="px-5 py-3.5 text-xs text-slate-500 tabular-nums font-medium">
                                    {{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.news.edit', $news->id) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-[#E2E8F0] text-xs font-semibold text-[#0F4C3A] hover:bg-[#F4F6F5] hover:border-[#0F4C3A]/30 transition shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr x-show="isReady" x-cloak>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <svg class="w-9 h-9 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <p class="text-xs font-medium">Belum ada data berita yang dipublikasikan.</p>
                                </td>
                            </tr>
                        @endforelse

                        <!-- Search Empty State -->
                        <tr x-show="isReady && search && filteredCount === 0" x-cloak>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                <p class="text-xs font-medium text-slate-500">Tidak ada berita yang sesuai dengan pencarian
                                    "<span x-text="search" class="font-semibold text-[#0F172A]"></span>"</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection