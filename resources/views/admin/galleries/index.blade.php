@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto')

@section('content')
<div class="space-y-5">
    {{-- 1. Page Header & Primary Action --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Galeri Foto Kegiatan Desa</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola album dokumentasi visual dan arsip foto kegiatan resmi Desa Catur.</p>
        </div>
        <div class="shrink-0 self-start sm:self-auto">
            <a href="{{ route('admin.galleries.create') }}" 
               class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Upload Foto Baru</span>
            </a>
        </div>
    </div>

    {{-- 2. Gallery Bento Grid (Harmonisasi dengan Desain Card Bersih) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($galleries as $gal)
            <div class="bg-white rounded-xl overflow-hidden border border-slate-200/90 shadow-xs flex flex-col justify-between hover:shadow-md hover:border-[#0F4C3A]/30 transition-all group">
                <div>
                    <div class="h-44 bg-slate-100 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $gal->image_path) }}" 
                             alt="{{ $gal->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100%25\' height=\'100%25\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23CBD5E1\' stroke-width=\'1.5\'><rect width=\'100%25\' height=\'100%25\' fill=\'%23F1F5F9\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg>'">
                    </div>
                    <div class="p-4 space-y-1">
                        <h4 class="font-jakarta font-semibold text-xs sm:text-sm text-slate-900 group-hover:text-[#0F4C3A] transition-colors line-clamp-1">
                            {{ $gal->title }}
                        </h4>
                        @if($gal->description)
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $gal->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="p-3.5 pt-2.5 border-t border-slate-100 flex justify-between items-center text-xs">
                    <span class="text-slate-400 tabular-nums text-[11px]">{{ $gal->published_at ? $gal->published_at->format('d/m/Y') : '' }}</span>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.galleries.edit', $gal->id) }}" 
                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-[#0F4C3A] hover:border-[#0F4C3A]/30 hover:bg-slate-50 transition shadow-2xs"
                           title="Edit Foto">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $gal->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto galeri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition shadow-2xs cursor-pointer"
                                    title="Hapus Foto">
                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 bg-white rounded-xl text-center text-slate-400 border border-slate-200/90 shadow-xs">
                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-xs font-semibold text-slate-800">Belum ada foto galeri kegiatan</p>
                <p class="text-xs text-slate-400 mt-0.5">Unggah dokumentasi foto kegiatan desa pertama melalui tombol di atas.</p>
            </div>
        @endforelse
    </div>

    {{-- Footer Pagination --}}
    @if($galleries->hasPages())
        <div class="pt-2">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection
