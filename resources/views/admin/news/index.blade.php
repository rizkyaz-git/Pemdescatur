@extends('layouts.admin')

@section('title', 'Berita & Pengumuman')

@section('content')
    <div class="space-y-6" x-data="{ categoryModalOpen: false }">
        <!-- 1. Page Header (Standard Admin Typography: font-jakarta text-2xl font-bold text-[#0F172A]) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-1">
            <div>
                <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Kelola Berita & Pengumuman</h1>
                <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola publikasi informasi resmi Desa Catur.</p>
            </div>
            <a href="{{ route('admin.news.create') }}"
                class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-xs transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Berita</span>
            </a>
        </div>

        <!-- 2. Category Tabs Strip (Dense, Standard Admin Tokens: border-[#E2E8F0], #0F4C3A) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-[#E2E8F0]">
            <!-- Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto custom-scrollbar py-0.5">
                <a href="{{ route('admin.news.index', request()->except('page', 'category')) }}"
                    class="px-3.5 py-1.5 text-xs whitespace-nowrap transition-colors rounded-lg {{ !request('category') ? 'bg-[#0F4C3A] text-white font-semibold shadow-xs' : 'text-[#64748B] hover:bg-emerald-50 hover:text-[#0F4C3A] font-medium' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('admin.news.index', array_merge(request()->except('page', 'category'), ['category' => $cat->name])) }}"
                        class="px-3.5 py-1.5 text-xs whitespace-nowrap transition-colors rounded-lg {{ request('category') === $cat->name ? 'bg-[#0F4C3A] text-white font-semibold shadow-xs' : 'text-[#64748B] hover:bg-emerald-50 hover:text-[#0F4C3A] font-medium' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Secondary Action: Kelola Kategori -->
            <div class="shrink-0 flex items-center">
                <button type="button" @click="categoryModalOpen = true"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-[#E2E8F0] bg-white text-slate-700 hover:text-[#0F4C3A] hover:border-[#0F4C3A]/40 text-xs font-semibold shadow-2xs transition cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-[#64748B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Kelola Kategori</span>
                </button>
            </div>
        </div>

        <!-- 3. Toolbar (Search & Filters: Standard Admin Inputs with #E2E8F0 & #0F4C3A) -->
        <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-wrap items-center gap-2.5">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <!-- Search Input -->
            <div class="relative w-full sm:w-80">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari judul berita..." 
                       class="w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm rounded-lg border border-[#E2E8F0] bg-white text-[#0F172A] placeholder-slate-400 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition">
            </div>

            <!-- Status Filter Dropdown -->
            <select name="status" onchange="this.form.submit()"
                class="px-3.5 py-2 text-xs sm:text-sm rounded-lg border border-[#E2E8F0] bg-white text-slate-700 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition cursor-pointer">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Tayang</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-[#0F4C3A] hover:bg-[#072C21] rounded-lg shadow-xs transition cursor-pointer">
                Cari
            </button>

            @if(request('search') || request('status') || request('category'))
                <a href="{{ route('admin.news.index') }}" 
                   class="text-xs text-[#64748B] hover:text-[#0F172A] font-medium px-2 py-1.5 transition">
                    Reset Filter
                </a>
            @endif
        </form>

        <!-- 4. Data Table Container (Standard Admin Table Tokens) -->
        <div class="bg-white rounded-[14px] border border-[#E2E8F0] shadow-xs overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                            <th scope="col" class="w-20 px-4 py-3.5 text-center align-middle whitespace-nowrap font-bold">Sampul</th>
                            <th scope="col" class="px-4 py-3.5 align-middle min-w-[240px] font-bold">Judul Berita</th>
                            <th scope="col" class="w-32 px-4 py-3.5 align-middle whitespace-nowrap font-bold">Kategori</th>
                            <th scope="col" class="w-28 px-4 py-3.5 align-middle whitespace-nowrap font-bold">Status</th>
                            <th scope="col" class="w-36 px-4 py-3.5 align-middle whitespace-nowrap font-bold">Tanggal Terbit</th>
                            <th scope="col" class="w-36 px-4 py-3.5 text-center align-middle whitespace-nowrap font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9] bg-white">
                        @forelse($newsList as $news)
                            <tr class="hover:bg-[#F8FAFC]/80 transition-colors">
                                <!-- Thumbnail -->
                                <td class="px-4 py-3.5 align-middle text-center">
                                    <div class="w-14 h-14 mx-auto rounded-lg overflow-hidden border border-[#E2E8F0] bg-[#F8FAFC] flex items-center justify-center shrink-0 shadow-2xs">
                                        @if($news->image_path)
                                            <img src="{{ asset('storage/' . $news->image_path) }}"
                                                alt="{{ $news->title }}"
                                                class="w-full h-full object-cover"
                                                onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                            <div class="hidden w-full h-full flex items-center justify-center bg-slate-100 text-slate-400" title="Gambar tidak dapat dimuat">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400" title="Tidak ada gambar">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Judul Berita & Author -->
                                <td class="px-4 py-3.5 align-middle">
                                    <a href="{{ route('public.news.show', $news->slug) }}" target="_blank"
                                        title="{{ $news->title }}"
                                        class="font-semibold text-[#0F172A] hover:text-[#0F4C3A] transition-colors text-xs leading-snug line-clamp-2 block">
                                        {{ $news->title }}
                                    </a>
                                    <div class="text-[11px] text-[#64748B] mt-1 flex items-center gap-1 font-normal">
                                        <span>{{ $news->author ?: 'Admin Pemdes Catur' }}</span>
                                    </div>
                                </td>

                                <!-- Kategori Badge -->
                                <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-[#0F4C3A] border border-emerald-200/80">
                                        {{ $news->category }}
                                    </span>
                                </td>

                                <!-- Status Badge (Tayang / Draft) -->
                                <td class="px-4 py-3.5 align-middle whitespace-nowrap">
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

                                <!-- Tanggal Terbit -->
                                <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                    @if($news->published_at)
                                        <span class="text-xs font-semibold text-slate-800 tabular-nums">{{ $news->published_at->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">-</span>
                                    @endif
                                </td>

                                <!-- Aksi Edit & Hapus -->
                                <td class="px-4 py-3.5 align-middle text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.news.edit', $news->id) }}"
                                            class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-[#E2E8F0] text-xs font-semibold text-[#0F4C3A] hover:bg-[#F4F6F5] hover:border-[#0F4C3A]/30 transition shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-rose-200 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition shadow-2xs cursor-pointer">
                                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
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
                                    <p class="text-xs font-semibold text-[#0F172A]">Tidak ada berita</p>
                                    <p class="text-xs text-[#64748B] mt-0.5">Belum ada publikasi pada kriteria ini.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.news.create') }}" 
                                           class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-xs transition">
                                            <span>+ Tambah Berita</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($newsList->hasPages())
                <div class="p-4 border-t border-[#E2E8F0] bg-[#F8FAFC]">
                    {{ $newsList->links() }}
                </div>
            @endif
        </div>

        <!-- 5. Modal Kelola Kategori (Standard Admin Modal Styling) -->
        <div x-show="categoryModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.away="categoryModalOpen = false"
                class="bg-white rounded-xl border border-[#E2E8F0] shadow-xl max-w-md w-full p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#F1F5F9]">
                    <h3 class="font-jakarta font-extrabold text-base text-slate-900 tracking-tight">Kategori Berita</h3>
                    <button type="button" @click="categoryModalOpen = false"
                        class="text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Tambah Kategori -->
                <form action="{{ route('admin.news-categories.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label for="new_category_name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Nama Kategori Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="name" id="new_category_name" required
                                placeholder="Contoh: Pengumuman Desa"
                                class="flex-1 px-3 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900">
                            <button type="submit"
                                class="px-3.5 py-2 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-xs transition cursor-pointer shrink-0">
                                Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Daftar Kategori yang Ada -->
                <div class="pt-2 border-t border-[#F1F5F9] space-y-2">
                    <p class="text-xs font-bold text-slate-600 uppercase tracking-wider">Kategori Saat Ini</p>
                    <div class="max-h-48 overflow-y-auto space-y-1.5 custom-scrollbar pr-1">
                        @foreach($categories as $cat)
                            <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-[#E2E8F0]">
                                <span class="text-xs font-semibold text-slate-700">{{ $cat->name }}</span>
                                <form action="{{ route('admin.news-categories.destroy', $cat->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-slate-400 hover:text-rose-600 transition p-1 cursor-pointer" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection