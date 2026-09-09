@extends('layouts.admin')

@section('title', 'Kelola Berita & Pengumuman')

@section('content')
    <div class="space-y-6">
        <!-- Header Page -->
        <div
            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
            <div>
                <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Kelola Berita & Pengumuman</h1>
            </div>
            <a href="{{ route('admin.news.create') }}"
                class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Berita</span>
            </a>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr
                            class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                            <th class="px-5 py-3.5">Sampul</th>
                            <th class="px-5 py-3.5">Judul Berita</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Tanggal Terbit</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($newsList as $news)
                            <tr class="hover:bg-[#F8FAFC]/80 transition-colors">
                                <td class="px-5 py-4">
                                    @if($news->image_path)
                                        <img src="{{ asset('storage/' . $news->image_path) }}"
                                            class="w-12 h-12 rounded-xl object-cover border border-[#E2E8F0]">
                                    @else
                                        <div
                                            class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs font-medium border border-[#E2E8F0]">
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 max-w-sm">
                                    <a href="{{ route('public.news.show', $news->slug) }}" target="_blank"
                                        class="font-medium text-[#0F172A] hover:text-[#0F4C3A] transition-colors line-clamp-2">
                                        {{ $news->title }}
                                    </a>
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $news->category }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if($news->status === 'published')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-[#DCFCE7] text-[#15803D]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                                            <span>Tayang</span>
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            <span>Draft</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-xs text-slate-500 tabular-nums">
                                    {{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-5 py-4 text-right space-x-1.5">
                                    <a href="{{ route('admin.news.edit', $news->id) }}"
                                        class="inline-flex items-center gap-1 bg-white hover:bg-slate-50 text-slate-700 border border-[#E2E8F0] hover:border-[#0F4C3A]/30 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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
                                            class="inline-flex items-center gap-1 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200/80 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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