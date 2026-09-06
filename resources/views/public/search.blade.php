@extends('layouts.public')

@section('title', 'Hasil Pencarian - Web Profile Desa Catur Sambi Boyolali')

@section('content')

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- Search Page Hero Header -->
    <div class="bg-gradient-to-r from-[#0A3D29] via-[#145C3B] to-[#0A3D29] text-white rounded-[32px] p-8 sm:p-12 shadow-xl relative overflow-hidden">
        <div class="relative z-10 max-w-3xl space-y-4">
            <span class="text-xs font-bold text-[#D9B85C] uppercase tracking-widest bg-white/10 px-3.5 py-1 rounded-full border border-white/20 inline-block">
                Pusat Pencarian Informasi Desa
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-extrabold tracking-tight">
                Pencarian Website Desa Catur
            </h1>
            <p class="text-[#EAF1E8] text-xs sm:text-sm font-light leading-relaxed">
                Temukan informasi profil 13 pedukuhan, berita, potensi pertanian padi organik Waduk Wonotoro, perangkat desa, galeri, dan layanan Pojok Literasi.
            </p>

            <!-- Big Search Form -->
            <form action="{{ route('public.search') }}" method="GET" class="relative max-w-2xl pt-2">
                <div class="relative flex items-center">
                    <input type="text" 
                           name="q" 
                           value="{{ $query }}" 
                           placeholder="Ketik kata kunci (misal: padi, wonotoro, perangkat, umkm)..." 
                           class="w-full pl-12 pr-28 py-3.5 rounded-xl bg-white text-[#20332A] text-sm font-medium shadow-md border border-[#DCE6DA] placeholder-[#6C7B72] focus:outline-none focus:ring-2 focus:ring-[#D9B85C]">
                    <svg class="w-5 h-5 text-[#6C7B72] absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    
                    <button type="submit" class="absolute right-2 bg-[#0A3D29] hover:bg-[#145C3B] text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-xs">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results Section -->
    <div class="space-y-6">
        @if(!empty($query))
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-[#DCE6DA]">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#20332A]">
                    Hasil Pencarian untuk "<span class="text-[#0A3D29]">{{ $query }}</span>"
                </h2>
                <span class="text-xs text-[#6C7B72] font-semibold bg-[#EAF1E8] px-3 py-1 rounded-xl border border-[#DCE6DA]">
                    Menampilkan {{ $total }} hasil
                </span>
            </div>
        @endif

        @if(!empty($query) && count($results) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($results as $item)
                    <div class="bg-white p-6 rounded-2xl border border-[#DCE6DA] shadow-xs hover:shadow-md transition flex flex-col justify-between space-y-4 group">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold text-[#0A3D29] bg-[#EAF1E8] px-3 py-1 rounded-xl border border-[#DCE6DA]">
                                    {{ $item['badge'] ?? $item['category'] }}
                                </span>
                                <span class="text-[10px] text-[#6C7B72] font-medium uppercase tracking-wider">
                                    {{ $item['type'] }}
                                </span>
                            </div>

                            <h3 class="font-serif font-bold text-lg text-[#20332A] group-hover:text-[#0A3D29] transition leading-snug">
                                <a href="{{ $item['url'] }}">
                                    {{ $item['title'] }}
                                </a>
                            </h3>

                            <p class="text-xs text-[#6C7B72] leading-relaxed font-light line-clamp-3">
                                {{ $item['snippet'] }}
                            </p>
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-[#145C3B] font-medium">{{ $item['category'] }}</span>
                            <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1 font-bold text-[#0A3D29] hover:text-[#145C3B]">
                                <span>Buka Informasi</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!empty($query))
            <!-- Empty State No Results -->
            <div class="bg-white rounded-3xl p-12 text-center border border-[#DCE6DA] shadow-xs max-w-xl mx-auto space-y-4">
                <div class="w-16 h-16 bg-[#F2E7BF]/50 text-[#D9B85C] rounded-full flex items-center justify-center text-2xl mx-auto border border-[#D9B85C]/30">
                    🔍
                </div>
                <div class="space-y-1">
                    <h3 class="font-serif text-xl font-bold text-[#20332A]">Tidak Ada Hasil Ditemukan</h3>
                    <p class="text-xs text-[#6C7B72] font-light leading-relaxed">
                        Maaf, tidak ada informasi yang sesuai dengan kata kunci "<span class="font-semibold text-[#20332A]">{{ $query }}</span>". Coba gunakan kata kunci lain seperti <span class="text-[#0A3D29] font-semibold">padi, wonotoro, perangkat, umkm, atau berita</span>.
                    </p>
                </div>
                <a href="{{ route('home') }}" class="inline-block bg-[#0A3D29] hover:bg-[#145C3B] text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-xs">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <!-- Default State Before Searching -->
            <div class="bg-[#EAF1E8] rounded-3xl p-8 border border-[#DCE6DA] text-center space-y-4">
                <h3 class="font-serif text-lg font-bold text-[#0A3D29]">Saran Kata Kunci Populer</h3>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <a href="{{ route('public.search', ['q' => 'padi']) }}" class="bg-white hover:bg-[#0A3D29] hover:text-white transition px-4 py-2 rounded-xl text-xs font-semibold text-[#20332A] border border-[#DCE6DA] shadow-xs">
                        🌾 Padi Organik
                    </a>
                    <a href="{{ route('public.search', ['q' => 'wonotoro']) }}" class="bg-white hover:bg-[#0A3D29] hover:text-white transition px-4 py-2 rounded-xl text-xs font-semibold text-[#20332A] border border-[#DCE6DA] shadow-xs">
                        💧 Waduk Wonotoro
                    </a>
                    <a href="{{ route('public.search', ['q' => 'perangkat']) }}" class="bg-white hover:bg-[#0A3D29] hover:text-white transition px-4 py-2 rounded-xl text-xs font-semibold text-[#20332A] border border-[#DCE6DA] shadow-xs">
                        🏛️ Perangkat Desa
                    </a>
                    <a href="{{ route('public.search', ['q' => 'umkm']) }}" class="bg-white hover:bg-[#0A3D29] hover:text-white transition px-4 py-2 rounded-xl text-xs font-semibold text-[#20332A] border border-[#DCE6DA] shadow-xs">
                        🛍️ Produk UMKM
                    </a>
                    <a href="{{ route('public.search', ['q' => 'wisata']) }}" class="bg-white hover:bg-[#0A3D29] hover:text-white transition px-4 py-2 rounded-xl text-xs font-semibold text-[#20332A] border border-[#DCE6DA] shadow-xs">
                        🏞️ Desa Wisata
                    </a>
                </div>
            </div>
        @endif
    </div>

</div>

@endsection
