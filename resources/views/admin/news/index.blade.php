@extends('layouts.admin')

@section('title', 'Kelola Berita & Pengumuman')

@section('content')
    <div class="space-y-5" x-data="{ categoryModalOpen: false }">
        <!-- Header Page (Tanpa Pembungkus) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="font-jakarta text-2xl font-bold text-slate-900">Kelola Berita & Pengumuman</h1>
            </div>
            <a href="{{ route('admin.news.create') }}"
                class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-2xs transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Berita</span>
            </a>
        </div>

        <!-- Modal Tambah & Kelola Kategori -->
        <div x-show="categoryModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.away="categoryModalOpen = false"
                class="bg-white rounded-xl border border-[#E2E8F0] shadow-xl max-w-md w-full p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#F1F5F9]">
                    <h3 class="font-jakarta font-bold text-base text-[#0F172A]">Kategori Berita</h3>
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
                                class="px-3.5 py-2 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-2xs transition cursor-pointer shrink-0">
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

        <!-- Data Table Card dengan Tabs Kategori -->
        <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-2xs overflow-hidden">
            <!-- Tabs Kategori Bar (Latar Hijau Tua Tema & Tab Kapsul) -->
            <div class="bg-[#0F4C3A] px-4 py-3 sm:px-5 sm:py-3 border-b border-[#072C21] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <!-- Tabs Kategori (Kapsul) -->
                <div class="flex items-center gap-1.5 overflow-x-auto custom-scrollbar">
                    <a href="{{ route('admin.news.index') }}"
                        class="px-3.5 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 flex items-center gap-1.5 {{ !request('category') ? 'bg-white text-[#0F4C3A] font-bold shadow-xs' : 'text-white/80 hover:text-white hover:bg-white/10 font-medium' }}">
                        <span>Semua</span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('admin.news.index', ['category' => $cat->name]) }}"
                            class="px-3.5 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 flex items-center gap-1.5 {{ request('category') === $cat->name ? 'bg-white text-[#0F4C3A] font-bold shadow-xs' : 'text-white/80 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Tombol Tambah Kategori di Sisi Kanan Tab -->
                <div class="shrink-0 flex items-center">
                    <button type="button" @click="categoryModalOpen = true"
                        class="inline-flex items-center gap-1.5 bg-white hover:bg-emerald-50 text-[#0F4C3A] text-xs font-bold px-3 py-1.5 rounded-lg shadow-xs transition cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Kategori</span>
                    </button>
                </div>
            </div>

            <!-- Tabel Data Berita -->
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                            <th scope="col" class="w-20 px-4 py-3 text-center align-middle whitespace-nowrap">Sampul</th>
                            <th scope="col" class="px-4 py-3 align-middle min-w-[220px]">Judul Berita</th>
                            <th scope="col" class="w-32 px-4 py-3 align-middle whitespace-nowrap">Kategori</th>
                            <th scope="col" class="w-28 px-4 py-3 align-middle whitespace-nowrap">Status</th>
                            <th scope="col" class="w-36 px-4 py-3 align-middle whitespace-nowrap">Tanggal Terbit</th>
                            <th scope="col" class="w-36 px-4 py-3 text-center align-middle whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($newsList as $news)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <!-- Kolom Sampul dengan Fallback Gambar Rusak -->
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="w-14 h-14 mx-auto rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center shrink-0 shadow-2xs">
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

                                <!-- Kolom Judul Berita -->
                                <td class="px-4 py-3 align-middle">
                                    <a href="{{ route('public.news.show', $news->slug) }}" target="_blank"
                                        title="{{ $news->title }}"
                                        class="font-semibold text-slate-900 hover:text-[#0F4C3A] transition-colors text-xs leading-snug line-clamp-2 block">
                                        {{ $news->title }}
                                    </a>
                                </td>

                                <!-- Kolom Kategori -->
                                <td class="px-4 py-3 align-middle whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                        {{ $news->category }}
                                    </span>
                                </td>

                                <!-- Kolom Status -->
                                <td class="px-4 py-3 align-middle whitespace-nowrap">
                                    @if($news->status === 'published')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Tayang</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold rounded-md bg-slate-100 text-slate-600 border border-slate-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            <span>Draft</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Kolom Tanggal Terbit (Hanya Tanggal) -->
                                <td class="px-4 py-3 align-middle whitespace-nowrap">
                                    @if($news->published_at)
                                        <span class="text-xs font-semibold text-slate-800 tabular-nums">{{ $news->published_at->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">-</span>
                                    @endif
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="px-4 py-3 align-middle text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.news.edit', $news->id) }}"
                                            class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg bg-white hover:bg-slate-50 border border-slate-200 hover:border-[#0F4C3A]/40 text-slate-700 hover:text-[#0F4C3A] text-xs font-semibold transition shadow-2xs">
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
                                                class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg bg-white hover:bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold transition shadow-2xs cursor-pointer">
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
                                    <p class="text-xs font-medium">Belum ada berita yang dipublikasikan.</p>
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
    </div>
@endsection