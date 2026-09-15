@extends('layouts.public')

@section('title', 'Layanan Laporan & Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Portal resmi penyampaian aspirasi dan pengaduan warga Desa Catur secara aman, tertib, dan privat.')

@section('content')
    <div class="bg-white min-h-[85vh] py-8 sm:py-14 border-b border-slate-200 flex flex-col justify-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10 w-full">

            {{-- ========================================================================= --}}
            {{-- 1. BREADCRUMBS & INTRO TITLE (CLEAN & MINIMALIST) --}}
            {{-- ========================================================================= --}}
            <div class="text-left space-y-4">
                <x-breadcrumbs :items="[
            ['label' => 'BERANDA', 'url' => route('home')],
            ['label' => 'Pengaduan Warga']
        ]" />

                <div class="max-w-2xl space-y-2.5">

                    <h1
                        class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#20332A] tracking-tight leading-tight">
                        Layanan Laporan &amp; Pengaduan
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                        Sampaikan laporan fasilitas umum, saran pembangunan, dan aspirasi secara aman,
                        cepat, dan terjaga kerahasiaannya.
                    </p>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 2. DUA PILIHAN UTAMA (CARD ACTION INTI) --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                {{-- Pilihan 1: Tulis Pengaduan Baru --}}
                <div
                    class="bg-white rounded-2xl border-2 border-[#0A3D29]/20 p-6 sm:p-7 shadow-xs hover:border-[#0A3D29] hover:shadow-md transition-all flex flex-col justify-between space-y-5 group">
                    <div class="space-y-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-serif font-bold text-lg sm:text-xl text-slate-900">
                                Tulis Pengaduan Baru
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Sampaikan keluhan fasilitas jalan, lingkungan, pelayanan, atau aspirasi pembangunan desa
                                langsung ke Pemerintah Desa Catur.
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('warga.complaint.create') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-sm py-3 px-5 rounded-xl shadow-xs transition active:scale-[0.98] cursor-pointer">
                            <span>Kirim Pengaduan</span>
                            <svg class="w-4 h-4 text-emerald-200 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Pilihan 2: Cek Status Laporan --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-7 shadow-xs hover:border-slate-300 hover:shadow-md transition-all flex flex-col justify-between space-y-5 group">
                    <div class="space-y-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h2 class="font-serif font-bold text-lg sm:text-xl text-slate-900">
                                Cek Status Laporan Saya
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Sudah pernah mengirim laporan? Pantau perkembangan proses dan baca tanggapan resmi dari
                                balai desa via email Anda.
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('pelapor.login.request') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-semibold text-sm py-3 px-5 rounded-xl shadow-xs transition active:scale-[0.98] cursor-pointer">
                            <span>Cek Status Laporan</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 3. ALUR RINGKAS 3 LANGKAH (MINIMALIS) --}}
            {{-- ========================================================================= --}}
            <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-5 sm:p-7 space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 text-center sm:text-left">
                    Alur Singkat Pengaduan:
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="flex items-start gap-3">
                        <span
                            class="w-7 h-7 rounded-full bg-[#0A3D29] text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">1</span>
                        <div class="space-y-0.5">
                            <h4 class="font-semibold text-xs sm:text-sm text-slate-900">Isi Formulir</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Lengkapi identitas, uraian laporan, dan
                                lampiran foto.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="w-7 h-7 rounded-full bg-[#0A3D29] text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">2</span>
                        <div class="space-y-0.5">
                            <h4 class="font-semibold text-xs sm:text-sm text-slate-900">Verifikasi Email</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Klik tautan konfirmasi yang dikirimkan ke
                                email Anda.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="w-7 h-7 rounded-full bg-[#0A3D29] text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">3</span>
                        <div class="space-y-0.5">
                            <h4 class="font-semibold text-xs sm:text-sm text-slate-900">Tindak Lanjut &amp; Solusi</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Pemerintah desa menindaklanjuti dan memberi
                                respon resmi.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 4. JAMINAN PRIVASI RINGKAS --}}
            {{-- ========================================================================= --}}
            <div class="text-center pt-1">
                <p class="text-xs text-slate-500 flex items-center justify-center gap-1.5 flex-wrap">
                    <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span><strong>Privasi Terjamin:</strong> Data NIK dienkripsi secara aman dan laporan Anda bersifat
                        privat.</span>
                </p>
            </div>

        </div>
    </div>
@endsection