@extends('layouts.public')

@section('title', 'Laporan dan Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Daftar riwayat dan perkembangan laporan pengaduan Anda kepada Pemerintah Desa Catur.')

@section('content')
    <div class="bg-white min-h-screen py-8 sm:py-12 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Breadcrumbs & Header --}}
            <div class="space-y-3">
                <x-breadcrumbs :items="[
            ['label' => 'BERANDA', 'url' => route('home')],
            ['label' => 'Pengaduan Warga', 'url' => route('warga.complaint.index')],
            ['label' => 'Laporan Saya']
        ]" />

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-1">
                    <div>
                        <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-[#20332A] tracking-tight">
                            Riwayat Laporan Saya
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                            Selamat datang, <strong class="text-slate-800">{{ auth('pelapor')->user()->nama }}</strong>
                            ({{ auth('pelapor')->user()->email }}).
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5 shrink-0">
                        <a href="{{ route('warga.complaint.create') }}"
                            class="inline-flex items-center gap-1.5 bg-[#0A3D29] hover:bg-[#072B1D] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition active:scale-95 cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tulis Baru</span>
                        </a>

                        <form method="POST" action="{{ route('pelapor.logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition active:scale-95 cursor-pointer"
                                title="Keluar dari sesi portal privat">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Reports List --}}
            <div class="space-y-3.5">
                @forelse($laporans as $laporan)
                    @php
                        $statusConfig = match ($laporan->status) {
                            'pending_verification' => ['label' => 'Menunggu Verifikasi', 'bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200/80'],
                            'diterima' => ['label' => 'Laporan Diterima', 'bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200/80'],
                            'diproses' => ['label' => 'Sedang Ditindaklanjuti', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-800', 'border' => 'border-indigo-200/80'],
                            'selesai' => ['label' => 'Selesai', 'bg' => 'bg-[#EAF1E8]', 'text' => 'text-[#0A3D29]', 'border' => 'border-[#DCE6DA]'],
                            'ditolak' => ['label' => 'Ditolak', 'bg' => 'bg-rose-50', 'text' => 'text-rose-800', 'border' => 'border-rose-200/80'],
                            default => ['label' => str($laporan->status)->replace('_', ' ')->title(), 'bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200'],
                        };
                    @endphp

                    <a href="{{ route('pelapor.laporan.show', $laporan->id) }}"
                        class="block bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs hover:border-[#0A3D29]/40 hover:shadow-sm transition group">
                        <div
                            class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 pb-3 border-b border-slate-100">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                                    {{ $laporan->kategori }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    {{ $laporan->created_at->translatedFormat('d F Y, H:i') }} WIB
                                </span>
                            </div>

                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                <span>{{ $statusConfig['label'] }}</span>
                            </span>
                        </div>

                        <div class="pt-3 space-y-2">
                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed line-clamp-3">
                                {{ $laporan->isi_laporan }}
                            </p>

                            <div class="pt-2 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-3 text-slate-500">
                                    @if($laporan->lampiran)
                                        <span class="inline-flex items-center gap-1 text-[11px]">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            <span>Lampiran Bukti</span>
                                        </span>
                                    @endif

                                    @if($laporan->tanggapans_count ?? $laporan->tanggapans->count())
                                        <span class="inline-flex items-center gap-1 text-[11px] text-[#0A3D29] font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            <span>{{ $laporan->tanggapans->count() }} Tanggapan Resmi</span>
                                        </span>
                                    @endif
                                </div>

                                <span
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-[#0A3D29] group-hover:translate-x-0.5 transition-transform">
                                    <span>Lihat Rincian</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div
                        class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center space-y-4 shadow-xs">
                        <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 text-slate-400 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-serif font-bold text-base text-slate-800">Belum Ada Laporan Pengaduan</h3>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                Anda belum mengirimkan laporan atau pengaduan melalui alamat email ini.
                            </p>
                        </div>
                        <a href="{{ route('warga.complaint.create') }}"
                            class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-5 rounded-xl shadow-xs transition active:scale-95">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tulis Pengaduan Baru</span>
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($laporans->hasPages())
                <div class="pt-4">
                    {{ $laporans->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection