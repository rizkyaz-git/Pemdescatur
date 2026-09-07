@extends('layouts.public')

@section('title', 'PPKO Catur Cerdas UMS 2026 – Program Pemberdayaan Desa Catur')

@section('meta_description', 'Halaman resmi Program Penguatan Kapasitas Organisasi Kemahasiswaan (PPK Ormawa) Catur Cerdas Universitas Muhammadiyah Surakarta di Desa Catur, Sambi, Boyolali.')

@section('content')

<!-- Header Breadcrumb & Hero Banner -->
<section class="relative w-full bg-[#0A3D29] text-white overflow-hidden pt-12 pb-16 lg:pt-16 lg:pb-24 border-b border-emerald-900/40">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px]"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-medium text-emerald-200/80 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-white font-semibold">PPKO Catur Cerdas UMS 2026</span>
        </nav>

        <div class="max-w-3xl space-y-4">
            <!-- Pill Badges -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#D9B85C] text-[#061C12] shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    PPK Ormawa 2026
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-emerald-100 border border-white/20">
                    Universitas Muhammadiyah Surakarta
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-emerald-100 border border-white/20">
                    Desa Catur, Boyolali
                </span>
            </div>

            <!-- Page Title -->
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white drop-shadow-sm">
                PPKO Catur Cerdas UMS 2026
            </h1>

            <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed max-w-2xl font-normal">
                Program Penguatan Kapasitas Organisasi Kemahasiswaan (PPK Ormawa) Universitas Muhammadiyah Surakarta berkolaborasi bersama Pemerintah Desa dan masyarakat Desa Catur untuk mewujudkan desa yang mandiri, cerdas, berdaya, dan berdaya saing.
            </p>
        </div>

        <!-- Quick Highlight Numbers -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mt-8 pt-8 border-t border-white/15">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-center">
                <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#D9B85C]">5</span>
                <span class="block text-xs font-medium text-emerald-100 mt-0.5">Pojok Pemberdayaan</span>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-center">
                <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#D9B85C]">100%</span>
                <span class="block text-xs font-medium text-emerald-100 mt-0.5">Pelayanan Digital</span>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-center">
                <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#D9B85C]">1</span>
                <span class="block text-xs font-medium text-emerald-100 mt-0.5">Perpustakaan Digital</span>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-center">
                <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#D9B85C]">2026</span>
                <span class="block text-xs font-medium text-emerald-100 mt-0.5">Tahun Pengabdian</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Container -->
<div class="bg-white min-h-screen py-10 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 lg:space-y-20">

        <!-- SECTION 1: TENTANG PROGRAM & SINERGI -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="lg:col-span-7 space-y-4 text-left">
                <div class="inline-flex items-center gap-2 text-xs font-bold text-[#0A3D29] uppercase tracking-wider bg-[#EAF1E8] px-3 py-1 rounded-full">
                    <span>Tentang Inisiatif</span>
                </div>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                    Sinergi Inovasi Akademik & Kemajuan Desa Catur
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                    Program Penguatan Kapasitas Organisasi Kemahasiswaan (PPK Ormawa) merupakan program pengabdian dan pemberdayaan masyarakat yang diinisiasi oleh mahasiswa Universitas Muhammadiyah Surakarta (UMS). Di Desa Catur, program <strong>Catur Cerdas</strong> hadir sebagai akselerator transformasi desa melalui pendekatan partisipatif, digitalisasi informasi, dan penguatan potensi lokal.
                </p>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                    Melalui integrasi teknologi dan kolaborasi lintas generasi, program ini memfasilitasi pembangunan sistem website profil resmi desa, portal surat online mandiri warga, integrasi perpustakaan digital daerah, hingga pemberdayaan pertanian dan UMKM desa.
                </p>

                <!-- Value Checklist -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs sm:text-sm text-slate-700 font-medium">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Transparansi Pelayanan Publik</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Literasi Digital Generasi Muda</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Penguatan Potensi Tani & UMKM</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Pelestarian Budaya & Kearifan Lokal</span>
                    </div>
                </div>
            </div>

            <!-- Side Card Information -->
            <div class="lg:col-span-5 bg-slate-50 rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/70 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#0A3D29] text-white flex items-center justify-center font-serif text-xl font-bold shadow-xs">
                        UMS
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm sm:text-base leading-tight">Universitas Muhammadiyah Surakarta</h4>
                        <p class="text-xs text-slate-500">Tim Pelaksana PPK Ormawa 2026</p>
                    </div>
                </div>

                <div class="space-y-3 text-xs sm:text-sm text-slate-600">
                    <div class="flex justify-between py-1.5 border-b border-slate-200/50">
                        <span class="text-slate-500">Lokasi Pengabdian:</span>
                        <span class="font-semibold text-slate-800 text-right">Desa Catur, Sambi, Boyolali</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-200/50">
                        <span class="text-slate-500">Kemitraan Utama:</span>
                        <span class="font-semibold text-slate-800 text-right">Pemerintah Desa Catur</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-200/50">
                        <span class="text-slate-500">Fokus Program:</span>
                        <span class="font-semibold text-slate-800 text-right">Desa Cerdas & Literasi Warga</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-slate-500">Perpustakaan Desa:</span>
                        <a href="https://desacaturbyl.perpustakaan.co.id/home.ks" target="_blank" rel="noopener noreferrer" class="font-bold text-[#0A3D29] hover:underline flex items-center gap-1">
                            <span>Katalog Online</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

                <a href="{{ route('public.services.index') }}" class="block w-full py-2.5 px-4 rounded-xl bg-[#0A3D29] hover:bg-[#145C3B] text-white text-xs font-bold text-center transition">
                    Lihat Layanan Digital Desa →
                </a>
            </div>
        </section>

        <!-- SECTION 2: 5 POJOK CATUR CERDAS (PEMBERDAYAAN KOMPREHENSIF) -->
        <section class="space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <div class="inline-flex items-center gap-2 text-xs font-bold text-[#0A3D29] uppercase tracking-wider bg-[#EAF1E8] px-3 py-1 rounded-full">
                    <span>5 Pilar Pemberdayaan</span>
                </div>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                    Pojok Catur Cerdas
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    Lima pilar inisiatif pemberdayaan yang dirancang untuk menjawab kebutuhan masyarakat di bidang sosial, pertanian, edukasi anak, ekonomi mikro, dan kebudayaan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- 1. Pojok Harmoni -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-[#0A3D29]/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-slate-900 leading-snug">Pojok Harmoni</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Penguatan kerukunan sosial, tata kelola kelembagaan warga, serta forum rembuk pemuda dan masyarakat guna menjaga iklim guyub rukun warga Desa Catur.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#0A3D29]">
                        <span>Pemberdayaan Sosial</span>
                        <span>01</span>
                    </div>
                </div>

                <!-- 2. Pojok Tani -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-[#0A3D29]/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-slate-900 leading-snug">Pojok Tani</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Modernisasi wawasan pertanian ramah lingkungan, optimasi rantai pasok hasil panen padi dan palawija, serta pendampingan kelompok tani (Gapoktan) desa.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#0A3D29]">
                        <span>Pertanian Cerdas</span>
                        <span>02</span>
                    </div>
                </div>

                <!-- 3. Pojok Ceria -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-[#0A3D29]/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-slate-900 leading-snug">Pojok Ceria</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Ruang bermain dan belajar edukatif anak-anak desa, penguatan minat baca (literasi), bimbingan belajar kreatif, dan kegiatan positif generasi penerus desa.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#0A3D29]">
                        <span>Edukasi & Literasi Anak</span>
                        <span>03</span>
                    </div>
                </div>

                <!-- 4. Pojok UMKM -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-[#0A3D29]/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-slate-900 leading-snug">Pojok UMKM</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Pendampingan pelaku usaha mikro dan kerajinan rumah tangga dalam digital marketing, pengemasan produk, dan perluasan jangkauan pasar lokal hingga nasional.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#0A3D29]">
                        <span>Ekonomi Kreatif</span>
                        <span>04</span>
                    </div>
                </div>

                <!-- 5. Pojok Budaya -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-[#0A3D29]/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-slate-900 leading-snug">Pojok Budaya</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Dokumentasi dan pelestarian adat istiadat, kesenian tradisional, kearifan lokal, serta sejarah leluhur Desa Catur agar tetap lestari bagi generasi mendatang.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#0A3D29]">
                        <span>Warisan & Tradisi</span>
                        <span>05</span>
                    </div>
                </div>

                <!-- 6. Perpustakaan Digital (Featured Link) -->
                <div class="bg-gradient-to-br from-[#0A3D29] to-[#145C3B] text-white rounded-2xl p-6 shadow-md flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 text-[#D9B85C] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-white leading-snug">Perpustakaan Digital Desa</h3>
                        <p class="text-xs text-emerald-100 leading-relaxed font-normal">
                            Akses katalog buku digital, literatur edukatif, dan referensi bacaan daerah secara daring kapan saja dan di mana saja.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-white/20">
                        <a href="https://desacaturbyl.perpustakaan.co.id/home.ks" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#D9B85C] hover:text-white transition">
                            <span>Buka Portal Perpustakaan</span>
                            <span>↗</span>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION 3: HASIL KARYA & INOVASI PROGRAM UNGGULAN -->
        <section class="bg-slate-50 rounded-3xl p-6 sm:p-10 border border-slate-200/80 space-y-6">
            <div class="text-left space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-[#0A3D29]">Output & Kontribusi</span>
                <h3 class="font-serif text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900">
                    Karya Nyata Program Catur Cerdas
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 pt-2">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-2xs space-y-2">
                    <div class="text-2xl font-bold text-[#0A3D29]">01.</div>
                    <h4 class="font-serif text-base font-bold text-slate-900">Website Profil Resmi Desa</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Sistem informasi dan warta berbasis digital terintegrasi yang memudahkan publik mengenal potensi dan profil Desa Catur.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-2xs space-y-2">
                    <div class="text-2xl font-bold text-[#0A3D29]">02.</div>
                    <h4 class="font-serif text-base font-bold text-slate-900">Layanan Mandiri Warga</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pengajuan surat online dan penyampaian pengaduan aspirasi warga secara transparan dan responsif.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-2xs space-y-2">
                    <div class="text-2xl font-bold text-[#0A3D29]">03.</div>
                    <h4 class="font-serif text-base font-bold text-slate-900">Integrasi Literasi Digital</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Koneksi langsung dengan jaringan perpustakaan digital daerah untuk memajukan minat baca seluruh warga.
                    </p>
                </div>
            </div>
        </section>

        <!-- SECTION 4: CALL TO ACTION -->
        <section class="text-center py-6 border-t border-slate-200">
            <div class="max-w-xl mx-auto space-y-4">
                <h3 class="font-serif text-xl sm:text-2xl font-bold text-slate-900">
                    Mari Bersinergi Membangun Desa Catur
                </h3>
                <p class="text-xs sm:text-sm text-slate-600">
                    Punya ide kolaborasi atau ingin tahu lebih lanjut mengenai program PPKO Catur Cerdas UMS 2026? Hubungi kami atau kunjungi kantor Pemerintah Desa Catur.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                    <a href="{{ route('public.services.index') }}" class="px-5 py-2.5 rounded-xl bg-[#0A3D29] hover:bg-[#145C3B] text-white text-xs font-bold transition shadow-sm">
                        Pusat Layanan Warga
                    </a>
                    <a href="{{ route('public.news.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-700 text-xs font-bold transition">
                        Warta Berita Terkini
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection
