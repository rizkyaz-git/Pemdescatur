@extends('layouts.admin')

@section('title', 'Berita & Pengumuman')

@section('content')
    <div class="space-y-5" x-data="{ categoryModalOpen: false }">

        {{-- Zona 1: Page Heading & Primary Action --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Kelola Berita &amp; Pengumuman</h1>
                <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola publikasi informasi, agenda, dan berita resmi Desa Catur.</p>
            </div>
            
            {{-- Satu-satunya Primary Action di kanan pada desktop --}}
            <div class="shrink-0 self-start sm:self-auto">
                <a href="{{ route('admin.news.create') }}"
                    class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Berita</span>
                </a>
            </div>
        </div>

        {{-- Zona 2: Navigasi Kategori (Aksen Garis Bawah pada Kategori Aktif) & Aksi Kelola Kategori --}}
        <div class="flex items-center justify-between gap-3">
            <!-- Scrollable Category Navigation tanpa scrollbar dengan aksen garis bawah pada kategori aktif -->
            <nav class="flex items-center gap-1.5 sm:gap-2.5 overflow-x-auto min-w-0 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden" aria-label="Filter Kategori Berita" style="-webkit-overflow-scrolling: touch;">
                <a href="{{ route('admin.news.index', request()->except('page', 'category')) }}"
                    class="px-2.5 py-1.5 text-xs whitespace-nowrap transition-colors {{ !request('category') ? 'text-[#0F4C3A] font-bold border-b-2 border-[#0F4C3A]' : 'text-slate-500 hover:text-slate-800 font-medium border-b-2 border-transparent' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('admin.news.index', array_merge(request()->except('page', 'category'), ['category' => $cat->name])) }}"
                        class="px-2.5 py-1.5 text-xs whitespace-nowrap transition-colors {{ request('category') === $cat->name ? 'text-[#0F4C3A] font-bold border-b-2 border-[#0F4C3A]' : 'text-slate-500 hover:text-slate-800 font-medium border-b-2 border-transparent' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </nav>

            <!-- Garis tipis pembatas di sebelah kiri Kelola Kategori + Tombol Kelola Kategori Nyata -->
            <div class="border-l border-slate-200 pl-3 shrink-0">
                <button type="button" @click="categoryModalOpen = true"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer"
                    title="Kelola Daftar Kategori">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>Kelola Kategori</span>
                </button>
            </div>
        </div>

        {{-- Zona 3: Control Group Pencarian & Status Filter (Enter untuk Cari) --}}
        <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <!-- Control Group: [Cari judul berita...] [Dropdown Status Gaya Navbar] -->
            <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:max-w-md">
                <!-- Search Input (Submit via Enter) -->
                <div class="relative flex-1">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari judul berita..." 
                           class="w-full h-9 pl-9 pr-3 text-xs sm:text-sm rounded-lg border border-slate-200 bg-white text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition">
                </div>

                <!-- Dropdown Status Gaya Navbar -->
                <div class="relative shrink-0" x-data="{ statusOpen: false }" @click.away="statusOpen = false">
                    <input type="hidden" name="status" x-ref="statusInput" value="{{ request('status') }}">
                    
                    <!-- Trigger Button Dropdown -->
                    <button type="button" @click="statusOpen = !statusOpen"
                        class="w-full sm:w-auto h-9 px-3.5 inline-flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer shadow-2xs">
                        <span>
                            @if(request('status') === 'published')
                                Tayang
                            @elseif(request('status') === 'draft')
                                Draft
                            @else
                                Semua Status
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200"
                            :class="statusOpen ? 'rotate-180 text-[#0F4C3A]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Menu Panel Dropdown Gaya Navbar -->
                    <div x-show="statusOpen" x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute left-0 mt-1.5 w-36 rounded-xl bg-white border border-slate-200 shadow-xl py-1 z-30 overflow-hidden text-xs">
                        
                        <button type="button" 
                            @click="$refs.statusInput.value = ''; statusOpen = false; $el.closest('form').submit()"
                            class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ !request('status') ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>Semua Status</span>
                            @if(!request('status'))
                                <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </button>

                        <button type="button" 
                            @click="$refs.statusInput.value = 'published'; statusOpen = false; $el.closest('form').submit()"
                            class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'published' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>Tayang</span>
                            @if(request('status') === 'published')
                                <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </button>

                        <button type="button" 
                            @click="$refs.statusInput.value = 'draft'; statusOpen = false; $el.closest('form').submit()"
                            class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'draft' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>Draft</span>
                            @if(request('status') === 'draft')
                                <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </button>
                    </div>
                </div>
            </div>

            @if(request('search') || request('status') || request('category'))
                <div class="flex items-center shrink-0">
                    <a href="{{ route('admin.news.index') }}" 
                       class="h-9 inline-flex items-center justify-center px-2.5 text-xs text-slate-500 hover:text-slate-800 font-medium transition">
                        Reset
                    </a>
                </div>
            @endif
        </form>

        {{-- 4. Tabel Data Berita (Orientasi Scanning, Emphasis pada Judul, Overflow Menu) --}}
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200/80">
                            <th scope="col" class="w-20 px-4 py-3 text-center align-middle whitespace-nowrap">Sampul</th>
                            <th scope="col" class="px-4 py-3 align-middle min-w-[280px]">Judul Berita</th>
                            <th scope="col" class="w-32 px-4 py-3 align-middle whitespace-nowrap">Kategori</th>
                            <th scope="col" class="w-28 px-4 py-3 align-middle whitespace-nowrap">Status</th>
                            <th scope="col" class="w-32 px-4 py-3 align-middle whitespace-nowrap">Tanggal Terbit</th>
                            <th scope="col" class="w-32 px-4 py-3 text-right align-middle whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($newsList as $news)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                
                                {{-- Thumbnail Sampul (Consistent Aspect Ratio & Neutral Placeholder) --}}
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="w-14 h-11 sm:w-16 sm:h-12 mx-auto rounded-lg overflow-hidden border border-slate-200/80 bg-slate-100 flex items-center justify-center shrink-0">
                                        @if($news->image_path)
                                            <img src="{{ asset('storage/' . $news->image_path) }}"
                                                alt="{{ $news->title }}"
                                                class="w-full h-full object-cover"
                                                onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                            <div class="hidden w-full h-full flex items-center justify-center bg-slate-100 text-slate-400" title="Gambar tidak dapat dimuat">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400" title="Tidak ada gambar">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Judul Berita (Primary Visual Emphasis for Quick Scanning) --}}
                                <td class="px-4 py-3 align-middle">
                                    <div class="flex items-start gap-1.5">
                                        @if((string) $featuredNewsId === (string) $news->id)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200/80 px-1.5 py-0.5 rounded-sm shrink-0 mt-0.5" title="Berita Utama">
                                                ★ Utama
                                            </span>
                                        @endif
                                        <a href="{{ route('admin.news.edit', $news->id) }}"
                                            class="font-semibold text-slate-900 hover:text-[#0F4C3A] text-xs sm:text-sm leading-snug line-clamp-2 block transition-colors">
                                            {{ $news->title }}
                                        </a>
                                    </div>
                                </td>

                                {{-- Kategori (Subtle Neutral Badge) --}}
                                <td class="px-4 py-3 align-middle whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                        {{ $news->category }}
                                    </span>
                                </td>

                                {{-- Status (Subtle Badge) --}}
                                <td class="px-4 py-3 align-middle whitespace-nowrap">
                                    @if($news->status === 'published')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Tayang</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600 border border-slate-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            <span>Draft</span>
                                        </span>
                                    @endif
                                </td>

                                {{-- Tanggal Terbit --}}
                                <td class="px-4 py-3 align-middle whitespace-nowrap text-xs text-slate-600 tabular-nums">
                                    {{ $news->published_at ? $news->published_at->format('d/m/Y') : '-' }}
                                </td>

                                {{-- Kolom Aksi (Primary 'Edit' + Secondary '⋯' Overflow Menu) --}}
                                <td class="px-4 py-3 align-middle text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5" x-data="{ menuOpen: false }">
                                        
                                        <!-- Primary Action: Edit -->
                                        <a href="{{ route('admin.news.edit', $news->id) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-[#0F4C3A] hover:border-[#0F4C3A]/30 hover:bg-slate-50 transition shadow-2xs"
                                            title="Edit Berita">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        <!-- Secondary Actions Overflow Menu (⋯) -->
                                        <div class="relative" @click.away="menuOpen = false">
                                            <button type="button" @click="menuOpen = !menuOpen"
                                                class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center justify-center transition shadow-2xs cursor-pointer"
                                                title="Opsi Lainnya" aria-label="Menu Opsi Berita">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                </svg>
                                            </button>

                                            <!-- Overflow Dropdown Menu -->
                                            <div x-show="menuOpen" x-cloak
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute right-0 mt-1 w-48 rounded-lg bg-white border border-slate-200 shadow-lg py-1 z-30 text-left text-xs text-slate-700">
                                                
                                                <!-- Lihat Halaman Publik -->
                                                <a href="{{ route('public.news.show', $news->slug) }}" target="_blank"
                                                    class="flex items-center gap-2 px-3 py-2 hover:bg-slate-50 text-slate-700 transition">
                                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    <span>Lihat di Portal</span>
                                                </a>

                                                <!-- Set / Batal Berita Utama -->
                                                <form action="{{ route('admin.news.set-featured', $news->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-2 px-3 py-2 hover:bg-slate-50 text-slate-700 transition text-left cursor-pointer">
                                                        <svg class="w-3.5 h-3.5 {{ (string) $featuredNewsId === (string) $news->id ? 'text-amber-500 fill-amber-500' : 'text-slate-400' }}" fill="{{ (string) $featuredNewsId === (string) $news->id ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                        </svg>
                                                        <span>{{ (string) $featuredNewsId === (string) $news->id ? 'Batal Berita Utama' : 'Jadikan Berita Utama' }}</span>
                                                    </button>
                                                </form>

                                                <div class="my-1 border-t border-slate-100"></div>

                                                <!-- Hapus Berita (Destructive Action - Subtle Red) -->
                                                <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-2 px-3 py-2 text-rose-600 hover:bg-rose-50 transition text-left cursor-pointer">
                                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span>Hapus Berita</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <p class="text-xs font-semibold text-slate-800">Tidak ada berita ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Belum ada publikasi berita pada kriteria pencarian ini.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.news.create') }}" 
                                           class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-3.5 py-1.5 rounded-lg shadow-xs transition">
                                            <span>+ Tambah Berita</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 5. Footer Tabel: Status Jumlah Data & Pagination Subtle --}}
            @if($newsList->hasPages() || $newsList->total() > 0)
                <div class="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                    <p>
                        Menampilkan <span class="font-medium text-slate-700">{{ $newsList->firstItem() ?? 0 }}</span> - <span class="font-medium text-slate-700">{{ $newsList->lastItem() ?? 0 }}</span> dari <span class="font-medium text-slate-700">{{ $newsList->total() }}</span> berita
                    </p>
                    @if($newsList->hasPages())
                        <div class="shrink-0">
                            {{ $newsList->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- 6. Modal Kelola Kategori (Clean, Standard Admin Modal) --}}
        <div x-show="categoryModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.away="categoryModalOpen = false"
                class="bg-white rounded-xl border border-slate-200 shadow-xl max-w-md w-full p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-jakarta font-bold text-base text-slate-900 tracking-tight">Kelola Kategori Berita</h3>
                    <button type="button" @click="categoryModalOpen = false"
                        class="text-slate-400 hover:text-slate-600 transition cursor-pointer" aria-label="Tutup Modal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Tambah Kategori -->
                <form action="{{ route('admin.news-categories.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label for="new_category_name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Kategori Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="name" id="new_category_name" required
                                placeholder="Contoh: Pengumuman Desa"
                                class="flex-1 h-9 px-3 rounded-lg border border-slate-200 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-xs bg-white text-slate-900">
                            <button type="submit"
                                class="h-9 px-3.5 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-xs transition cursor-pointer shrink-0">
                                Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Daftar Kategori yang Ada -->
                <div class="pt-2 border-t border-slate-100 space-y-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kategori Tersedia</p>
                    <div class="max-h-48 overflow-y-auto space-y-1.5 custom-scrollbar pr-1">
                        @forelse($categories as $cat)
                            <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-200/80">
                                <span class="text-xs font-medium text-slate-700">{{ $cat->name }}</span>
                                <form action="{{ route('admin.news-categories.destroy', $cat->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-slate-400 hover:text-rose-600 transition p-1 cursor-pointer" title="Hapus Kategori">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2 text-center">Belum ada kategori terdaftar.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection