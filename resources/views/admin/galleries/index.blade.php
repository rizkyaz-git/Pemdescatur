@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Galeri Foto Kegiatan Desa</h1>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Upload Foto Baru</span>
        </a>
    </div>

    <!-- Gallery Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse($galleries as $gal)
            <div class="bg-white rounded-[20px] overflow-hidden border border-[#E2E8F0] shadow-xs flex flex-col justify-between hover:shadow-md hover:border-[#0F4C3A]/30 transition-all group">
                <div>
                    <div class="h-44 bg-slate-100 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $gal->image_path) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4 space-y-1">
                        <h4 class="font-jakarta font-bold text-sm text-[#0F172A] line-clamp-1">{{ $gal->title }}</h4>
                        @if($gal->description)
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $gal->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="p-4 pt-3 border-t border-[#F1F5F9] flex justify-between items-center text-xs">
                    <span class="text-slate-400 tabular-nums">{{ $gal->published_at ? $gal->published_at->format('d/m/Y') : '' }}</span>
                    <div class="space-x-1.5">
                        <a href="{{ route('admin.galleries.edit', $gal->id) }}" class="inline-flex items-center gap-1 text-slate-700 hover:text-[#0F4C3A] font-semibold text-xs px-2 py-1 rounded-md hover:bg-slate-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $gal->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto galeri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 text-rose-600 hover:text-rose-800 font-semibold text-xs px-2 py-1 rounded-md hover:bg-rose-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 bg-white rounded-[20px] text-center text-slate-400 border border-[#E2E8F0]">
                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-xs font-medium">Belum ada foto galeri dokumentasi kegiatan.</p>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="pt-4">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection
