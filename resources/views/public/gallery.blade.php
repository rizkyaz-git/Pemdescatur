@extends('layouts.public')

@section('title', 'Galeri Kegiatan - Web Profile Desa Catur')

@section('content')

<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#0d631b] to-[#0a4f15] text-white py-12 px-4 border-b-4 border-[#fea619]">
    <div class="max-w-7xl mx-auto">
        <span class="text-xs font-semibold text-amber-300 uppercase tracking-wider">Dokumentasi Visual</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold mt-1">Galeri Foto Kegiatan Desa</h1>
        <p class="text-emerald-100 text-sm sm:text-base mt-2 max-w-2xl">
            Kumpulan dokumentasi kegiatan pertanian, kebudayaan, kemasyarakatan, dan pembangunan Desa Catur.
        </p>
    </div>
</div>

<div class="py-12 bg-[#f8f9ff]" x-data="{ activeImage: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        @if(isset($galleries) && $galleries->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($galleries as $gal)
                    <div class="bg-white rounded-xl overflow-hidden border border-[#bfcaba] shadow-sm hover:shadow-md transition group cursor-pointer"
                         @click="activeImage = '{{ asset('storage/' . $gal->image_path) }}'">
                        <div class="h-56 bg-slate-200 relative overflow-hidden">
                            <img src="{{ asset('storage/' . $gal->image_path) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-3xl">
                                🔍
                            </div>
                        </div>
                        <div class="p-4 space-y-1">
                            <h3 class="font-serif font-bold text-base text-[#0d1c2f] group-hover:text-[#0d631b] transition leading-snug">
                                {{ $gal->title }}
                            </h3>
                            @if($gal->description)
                                <p class="text-xs text-slate-600 line-clamp-2">{{ $gal->description }}</p>
                            @endif
                            <p class="text-[11px] text-slate-400 pt-1">
                                📅 {{ $gal->published_at ? $gal->published_at->format('d M Y') : $gal->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Lightbox Modal -->
            <div x-show="activeImage" x-cloak class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" @click="activeImage = null">
                <div class="relative max-w-4xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl" @click.stop>
                    <button @click="activeImage = null" class="absolute top-4 right-4 bg-black/60 hover:bg-black text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">
                        ✕
                    </button>
                    <img :src="activeImage" class="w-full max-h-[80vh] object-contain bg-black">
                </div>
            </div>

            <!-- Pagination -->
            <div class="pt-6">
                {{ $galleries->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <span class="text-4xl block mb-3">🖼️</span>
                <h3 class="font-serif text-lg font-bold text-slate-700">Belum Ada Foto Galeri</h3>
                <p class="text-xs text-slate-500 mt-1">Dokumentasi foto kegiatan desa akan segera ditambahkan.</p>
            </div>
        @endif

    </div>
</div>

@endsection
