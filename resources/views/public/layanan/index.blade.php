@extends('layouts.public')

@section('title', 'Pusat Layanan Publik Digital - Desa Catur Sambi Boyolali')
@section('meta_description', 'Pusat integrasi pelayanan publik Desa Catur: Layanan Surat Online Mandiri (SKU, SKD, SKTM), Pengaduan & Aspirasi Warga, Program Bantuan Desa, dan Bantuan Pelayanan.')

@section('content')

<!-- ========================================================================= -->
<!-- 1. HERO SECTION: Serving Citizens with Transparency and Trust -->
<!-- ========================================================================= -->
<section class="bg-white border-b border-[#DCE6DA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-5">
                <span class="inline-block px-3 py-1 rounded-sm bg-[#EAF1E8] border border-[#DCE6DA] text-[#0A3D29] text-[11px] font-bold uppercase tracking-widest">
                    OVERVIEW • LAYANAN PUBLIK
                </span>

                <h1 class="font-serif text-3xl sm:text-4xl lg:text-[42px] font-bold text-[#20332A] tracking-tight leading-[1.15]">
                    Melayani Warga dengan Transparansi dan Kepercayaan
                </h1>

                <p class="text-sm sm:text-base text-[#4B5851] font-sans leading-relaxed max-w-2xl">
                    Portal resmi integrasi pelayanan Pemerintah Desa Catur, Kecamatan Sambi, Kabupaten Boyolali. Akses pengajuan surat mandiri digital, saluran pengaduan keluhan, serta transparansi program bantuan warga.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('warga.letter.create') }}" 
                       class="px-5 py-3 rounded-sm bg-[#0A3D29] hover:bg-[#145C3B] text-white text-xs sm:text-sm font-bold shadow-xs transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#D9B85C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Akses Layanan Surat</span>
                    </a>

                    <a href="{{ route('warga.complaint.create') }}" 
                       class="px-5 py-3 rounded-sm bg-white hover:bg-[#EAF1E8] text-[#0A3D29] border border-[#0A3D29] text-xs sm:text-sm font-bold transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.684A1.76 1.76 0 013 12c0-.97.784-1.76 1.75-1.76l6.25 1.05M18 13l2.25 3.5"/></svg>
                        <span>Sampaikan Pengaduan</span>
                    </a>
                </div>
            </div>

            <!-- Right Hero Image: Civic Office Building -->
            <div class="lg:col-span-5">
                <div class="w-full aspect-[16/10] overflow-hidden bg-slate-100 border border-[#DCE6DA] rounded-sm shadow-xs relative">
                    <img src="{{ $coverImage }}" 
                         alt="Kantor Pelayanan Pemerintah Desa Catur" 
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-3 text-white">
                        <span class="text-[11px] font-medium tracking-wide">Balai Desa Catur • Sambi, Boyolali</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========================================================================= -->
<!-- 2. MODULAR DASHBOARD GRID: 2 Main Columns on Desktop -->
<!-- ========================================================================= -->
<section class="bg-[#F8FAF7] py-10 lg:py-14 border-b border-[#DCE6DA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">

            <!-- ================= LEFT COLUMN ================= -->
            <div class="space-y-6">

                <!-- 1. PUBLIC SERVICES (Layanan Publik Utama) -->
                <div class="bg-white border border-[#DCE6DA] rounded-sm p-6 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-[#DCE6DA] pb-3">
                        <h2 class="font-serif font-bold text-base sm:text-lg text-[#20332A] tracking-tight">
                            Public Services • Layanan Administrasi
                        </h2>
                        <span class="text-[11px] font-semibold text-[#6C7B72]">3 Layanan Inti</span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 pt-1">
                        <!-- Tile 1: Licenses / Surat Keterangan -->
                        <a href="{{ route('warga.letter.index') }}" 
                           class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] hover:bg-[#EAF1E8] hover:border-[#0A3D29] transition-all text-center group flex flex-col items-center justify-center gap-2.5">
                            <div class="w-10 h-10 rounded-sm bg-white border border-[#DCE6DA] text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-[#20332A] group-hover:text-[#0A3D29] leading-tight">
                                Surat Keterangan
                            </span>
                        </a>

                        <!-- Tile 2: Pajak / PBB Desa -->
                        <div class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] hover:bg-[#EAF1E8] hover:border-[#0A3D29] transition-all text-center group flex flex-col items-center justify-center gap-2.5 cursor-pointer"
                             onclick="alert('Informasi Pajak Bumi & Bangunan (PBB-P2) Desa Catur dapat dikoordinasikan langsung melalui perangkat desa di kantor balai desa.')">
                            <div class="w-10 h-10 rounded-sm bg-white border border-[#DCE6DA] text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-[#20332A] group-hover:text-[#0A3D29] leading-tight">
                                Pajak & PBB
                            </span>
                        </div>

                        <!-- Tile 3: Aspirasi & Pengaduan Warga -->
                        <a href="{{ route('warga.complaint.index') }}" 
                           class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] hover:bg-[#EAF1E8] hover:border-[#0A3D29] transition-all text-center group flex flex-col items-center justify-center gap-2.5">
                            <div class="w-10 h-10 rounded-sm bg-white border border-[#DCE6DA] text-[#0A3D29] flex items-center justify-center group-hover:scale-105 transition-transform shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.684A1.76 1.76 0 013 12c0-.97.784-1.76 1.75-1.76l6.25 1.05M18 13l2.25 3.5"/></svg>
                            </div>
                            <span class="text-xs font-bold text-[#20332A] group-hover:text-[#0A3D29] leading-tight">
                                Pengaduan
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 2. SUB-SERVICES GRID (Katalog 6 Layanan Surat & Dokumen) -->
                <div class="bg-white border border-[#DCE6DA] rounded-sm p-6 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-[#DCE6DA] pb-3">
                        <h2 class="font-serif font-bold text-base sm:text-lg text-[#20332A] tracking-tight">
                            Katalog Formulir Surat Mandiri
                        </h2>
                        <a href="{{ route('warga.letter.create') }}" class="text-xs font-bold text-[#0A3D29] hover:underline flex items-center gap-1">
                            <span>Ajukan Baru</span>
                            <span>→</span>
                        </a>
                    </div>

                    <!-- 2x3 Grid of 6 Specific Service Boxes -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-1">
                        
                        <!-- Box 1: SKU -->
                        <a href="{{ route('warga.letter.create') }}" class="p-3.5 rounded-sm border border-[#DCE6DA] bg-white hover:bg-[#EAF1E8]/40 hover:border-[#0A3D29] transition group space-y-2 block">
                            <div class="w-8 h-8 rounded-sm bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center text-xs font-bold">
                                SKU
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-xs text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1">Ket. Usaha</h3>
                                <p class="text-[10px] text-[#6C7B72] line-clamp-2 mt-0.5">Izin usaha mikro & pertanian</p>
                            </div>
                        </a>

                        <!-- Box 2: SKD -->
                        <a href="{{ route('warga.letter.create') }}" class="p-3.5 rounded-sm border border-[#DCE6DA] bg-white hover:bg-[#EAF1E8]/40 hover:border-[#0A3D29] transition group space-y-2 block">
                            <div class="w-8 h-8 rounded-sm bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center text-xs font-bold">
                                SKD
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-xs text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1">Ket. Domisili</h3>
                                <p class="text-[10px] text-[#6C7B72] line-clamp-2 mt-0.5">Keterangan domisili 13 pedukuhan</p>
                            </div>
                        </a>

                        <!-- Box 3: SKTM -->
                        <a href="{{ route('warga.letter.create') }}" class="p-3.5 rounded-sm border border-[#DCE6DA] bg-white hover:bg-[#EAF1E8]/40 hover:border-[#0A3D29] transition group space-y-2 block">
                            <div class="w-8 h-8 rounded-sm bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center text-xs font-bold">
                                SKTM
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-xs text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1">Tidak Mampu</h3>
                                <p class="text-[10px] text-[#6C7B72] line-clamp-2 mt-0.5">Pengantar beasiswa & bansos</p>
                            </div>
                        </a>

                        <!-- Box 4: Pengantar Nikah -->
                        <a href="{{ route('warga.letter.create') }}" class="p-3.5 rounded-sm border border-[#DCE6DA] bg-white hover:bg-[#EAF1E8]/40 hover:border-[#0A3D29] transition group space-y-2 block">
                            <div class="w-8 h-8 rounded-sm bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center text-xs font-bold">
                                NA
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-xs text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1">Pengantar Nikah</h3>
                                <p class="text-[10px] text-[#6C7B72] line-clamp-2 mt-0.5">Surat pengantar KUA / Capil</p>
                            </div>
                        </a>

                        <!-- Box 5: Kelahiran / Kematian -->
                        <a href="{{ route('warga.letter.create') }}" class="p-3.5 rounded-sm border border-[#DCE6DA] bg-white hover:bg-[#EAF1E8]/40 hover:border-[#0A3D29] transition group space-y-2 block">
                            <div class="w-8 h-8 rounded-sm bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center text-xs font-bold">
                                SKK
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-xs text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1">Kelahiran / Kematian</h3>
                                <p class="text-[10px] text-[#6C7B72] line-clamp-2 mt-0.5">Pencatatan data kependudukan</p>
                            </div>
                        </a>

                        <!-- Box 6: Pengaduan Masalah Warga -->
                        <a href="{{ route('warga.complaint.create') }}" class="p-3.5 rounded-sm border border-[#DCE6DA] bg-white hover:bg-[#EAF1E8]/40 hover:border-[#0A3D29] transition group space-y-2 block">
                            <div class="w-8 h-8 rounded-sm bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center text-xs font-bold">
                                LPR
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-xs text-[#20332A] group-hover:text-[#0A3D29] line-clamp-1">Lapor Fasilitas</h3>
                                <p class="text-[10px] text-[#6C7B72] line-clamp-2 mt-0.5">Aspirasi jalan, irigasi, umum</p>
                            </div>
                        </a>

                    </div>
                </div>

                <!-- 3. CITIZEN SUPPORT (Bantuan & Kontak Pelayanan) -->
                <div class="bg-white border border-[#DCE6DA] rounded-sm p-6 shadow-2xs space-y-4">
                    <div class="border-b border-[#DCE6DA] pb-3">
                        <h2 class="font-serif font-bold text-base sm:text-lg text-[#20332A] tracking-tight">
                            Citizen Support • Bantuan Layanan Warga
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1 text-xs">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6C7B72] block">Hotline & WhatsApp</span>
                            <p class="font-bold text-sm text-[#0A3D29] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ $contactPhone ?? '0812-3456-7890' }}</span>
                            </p>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6C7B72] block">Jam Kerja Balai Desa</span>
                            <p class="font-medium text-xs text-[#20332A] leading-relaxed">
                                {{ $officeHours ?? 'Senin - Jumat: 08:00 - 15:30 WIB' }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-[#DCE6DA] space-y-2">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#0A3D29] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <span class="font-bold text-xs text-[#20332A] block">Saluran Pengaduan Online (Grievance Redressal)</span>
                                <a href="{{ route('warga.complaint.create') }}" class="text-[11px] text-[#0A3D29] font-semibold hover:underline">
                                    Laporkan keluhan atau masukan pelayanan di sini →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- ================= RIGHT COLUMN ================= -->
            <div class="space-y-6">

                <!-- 4. LATEST ANNOUNCEMENTS & NOTICES (Pengumuman & Maklumat) -->
                <div class="bg-white border border-[#DCE6DA] rounded-sm p-6 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-[#DCE6DA] pb-3">
                        <h2 class="font-serif font-bold text-base sm:text-lg text-[#20332A] tracking-tight">
                            Pengumuman & Maklumat Pelayanan
                        </h2>
                        <span class="text-[11px] font-semibold text-[#0A3D29]">Pembaruan</span>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Notice 1: Maklumat Pelayanan Bebas Pungli -->
                        <div class="flex items-start gap-3.5 pb-4 border-b border-[#DCE6DA]/70 last:border-0 last:pb-0">
                            <div class="w-9 h-9 rounded-sm bg-[#EAF1E8] border border-[#DCE6DA] text-[#0A3D29] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-serif font-bold text-xs sm:text-sm text-[#20332A] leading-snug">
                                    Maklumat Standar Pelayanan Publik Pemdes Catur
                                </h3>
                                <p class="text-xs text-[#6C7B72] leading-relaxed">
                                    Seluruh penerbitan surat keterangan tidak dipungut biaya retribusi (gratis). Warga wajib melampirkan pengantar RT/RW atau identitas sah.
                                </p>
                                <span class="text-[10px] text-[#0A3D29] font-bold block pt-0.5">Standar Pelayanan 2026</span>
                            </div>
                        </div>

                        <!-- Notice 2: Pelayanan Digital Aktif Mandiri -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-sm bg-[#EAF1E8] border border-[#DCE6DA] text-[#0A3D29] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-serif font-bold text-xs sm:text-sm text-[#20332A] leading-snug">
                                    Sistem Pengajuan Surat Online Mandiri Aktif 24 Jam
                                </h3>
                                <p class="text-xs text-[#6C7B72] leading-relaxed">
                                    Warga dapat mengajukan permohonan kapan saja melalui gawai ponsel. Verifikasi tanda tangan digital diproses di jam kerja kantor.
                                </p>
                                <span class="text-[10px] text-[#0A3D29] font-bold block pt-0.5">Desa Cerdas Kemendes</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. GOVERNMENT SCHEMES & PROGRAMS (Program Bantuan & Skema Desa) -->
                <div class="bg-white border border-[#DCE6DA] rounded-sm p-6 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-[#DCE6DA] pb-3">
                        <h2 class="font-serif font-bold text-base sm:text-lg text-[#20332A] tracking-tight">
                            Program & Bantuan Pemerintah Desa
                        </h2>
                        <span class="text-[11px] font-semibold text-[#D9B85C] bg-[#20332A] px-2 py-0.5 rounded-sm">2026 Aktif</span>
                    </div>

                    <div class="space-y-3.5 pt-1">
                        
                        <!-- Program 1: BLT Dana Desa -->
                        <div class="p-3.5 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-[#20332A] flex items-center gap-1.5">
                                    <span>🏛️</span>
                                    <span>Bantuan Langsung Tunai (BLT-DD)</span>
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-sm bg-[#EAF1E8] text-[#0A3D29]">
                                    Penyaluran Rutin
                                </span>
                            </div>
                            <p class="text-[11px] text-[#6C7B72] leading-relaxed">
                                Penyaluran bantuan bagi keluarga prasejahtera dan lansia rentan di seluruh 13 pedukuhan Desa Catur.
                            </p>
                        </div>

                        <!-- Program 2: Bibit Padi Organik & Irigasi Wonotoro -->
                        <div class="p-3.5 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-[#20332A] flex items-center gap-1.5">
                                    <span>🌾</span>
                                    <span>Subsidi Benih Padi & Irigasi Waduk</span>
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-sm bg-[#EAF1E8] text-[#0A3D29]">
                                    Kelompok Tani
                                </span>
                            </div>
                            <p class="text-[11px] text-[#6C7B72] leading-relaxed">
                                Alokasi ketahanan pangan terpadu untuk optimalisasi panen padi organik 3 kali setahun dari irigasi Wonotoro.
                            </p>
                        </div>

                        <!-- Program 3: Bansos PKH & BPNT -->
                        <div class="p-3.5 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-[#20332A] flex items-center gap-1.5">
                                    <span>👨‍👩‍👧‍👦</span>
                                    <span>Fasilitasi Bansos PKH & BPNT Catur</span>
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-sm bg-[#EAF1E8] text-[#0A3D29]">
                                    DTKS Kemensos
                                </span>
                            </div>
                            <p class="text-[11px] text-[#6C7B72] leading-relaxed">
                                Pendampingan verifikasi data penerima manfaat program perlindungan sosial Kemensos bagi warga.
                            </p>
                        </div>

                    </div>
                </div>

                <!-- 6. STATISTICS (Statistik Kinerja Pelayanan) -->
                <div class="bg-white border border-[#DCE6DA] rounded-sm p-6 shadow-2xs space-y-4">
                    <div class="border-b border-[#DCE6DA] pb-3">
                        <h2 class="font-serif font-bold text-base sm:text-lg text-[#20332A] tracking-tight">
                            Statistik Kinerja Pelayanan Warga
                        </h2>
                    </div>

                    <!-- 2x2 Clean Metric Grid Matching Mockup -->
                    <div class="grid grid-cols-2 gap-4 pt-1">
                        
                        <!-- Metric 1: Surat Terbit -->
                        <div class="p-3.5 rounded-sm bg-[#F8FAF7] border border-[#DCE6DA] space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6C7B72] block">Permohonan Surat</span>
                            <div class="font-serif font-bold text-2xl sm:text-3xl text-[#0A3D29]">
                                {{ number_format($totalLetters, 0, ',', '.') }}+
                            </div>
                            <span class="text-[10px] text-[#6C7B72] block">Surat Terbit Resmi</span>
                        </div>

                        <!-- Metric 2: Warga Terlayani -->
                        <div class="p-3.5 rounded-sm bg-[#F8FAF7] border border-[#DCE6DA] space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6C7B72] block">Kepuasan Warga</span>
                            <div class="font-serif font-bold text-2xl sm:text-3xl text-[#0A3D29]">
                                98.6%
                            </div>
                            <span class="text-[10px] text-[#6C7B72] block">Indeks Kepuasan (IKM)</span>
                        </div>

                        <!-- Metric 3: Pengaduan Tertangani -->
                        <div class="p-3.5 rounded-sm bg-[#F8FAF7] border border-[#DCE6DA] space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6C7B72] block">Aspirasi Warga</span>
                            <div class="font-serif font-bold text-2xl sm:text-3xl text-[#20332A]">
                                {{ $totalComplaints }}+
                            </div>
                            <span class="text-[10px] text-[#6C7B72] block">Laporan Ditindaklanjuti</span>
                        </div>

                        <!-- Metric 4: Wilayah Pedukuhan -->
                        <div class="p-3.5 rounded-sm bg-[#F8FAF7] border border-[#DCE6DA] space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6C7B72] block">Cakupan Wilayah</span>
                            <div class="font-serif font-bold text-2xl sm:text-3xl text-[#20332A]">
                                13
                            </div>
                            <span class="text-[10px] text-[#6C7B72] block">Pedukuhan Terjangkau</span>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</section>


<!-- ========================================================================= -->
<!-- 3. STEP-BY-STEP SERVICE FLOW (Cara Pengajuan Surat & Laporan) -->
<!-- ========================================================================= -->
<section class="bg-white py-10 lg:py-12 border-b border-[#DCE6DA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-[11px] font-bold text-[#0A3D29] uppercase tracking-widest block">ALUR PELAYANAN CEPAT</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#20332A]">Cara Pengajuan Surat & Pengaduan Mandiri</h2>
            <p class="text-xs sm:text-sm text-[#6C7B72]">Proses ringkas 4 langkah untuk pengurusan administrasi warga Desa Catur secara praktis.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Step 1 -->
            <div class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] text-left space-y-2">
                <div class="w-8 h-8 rounded-sm bg-[#0A3D29] text-[#D9B85C] font-bold text-xs flex items-center justify-center shadow-2xs">
                    01
                </div>
                <h3 class="font-serif font-bold text-sm text-[#20332A]">Pilih Layanan Surat</h3>
                <p class="text-xs text-[#6C7B72] leading-relaxed">Tentukan jenis surat keterangan (SKU, SKD, SKTM, dll.) atau buat laporan pengaduan.</p>
            </div>

            <!-- Step 2 -->
            <div class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] text-left space-y-2">
                <div class="w-8 h-8 rounded-sm bg-[#0A3D29] text-[#D9B85C] font-bold text-xs flex items-center justify-center shadow-2xs">
                    02
                </div>
                <h3 class="font-serif font-bold text-sm text-[#20332A]">Isi Data Diri & NIK</h3>
                <p class="text-xs text-[#6C7B72] leading-relaxed">Lengkapi formulir online dengan data KTP/KK yang valid serta tujuan pembuatan surat.</p>
            </div>

            <!-- Step 3 -->
            <div class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] text-left space-y-2">
                <div class="w-8 h-8 rounded-sm bg-[#0A3D29] text-[#D9B85C] font-bold text-xs flex items-center justify-center shadow-2xs">
                    03
                </div>
                <h3 class="font-serif font-bold text-sm text-[#20332A]">Verifikasi Perangkat</h3>
                <p class="text-xs text-[#6C7B72] leading-relaxed">Perangkat Balai Desa Catur memverifikasi data dan memproses pengesahan surat.</p>
            </div>

            <!-- Step 4 -->
            <div class="p-4 rounded-sm border border-[#DCE6DA] bg-[#F8FAF7] text-left space-y-2">
                <div class="w-8 h-8 rounded-sm bg-[#0A3D29] text-[#D9B85C] font-bold text-xs flex items-center justify-center shadow-2xs">
                    04
                </div>
                <h3 class="font-serif font-bold text-sm text-[#20332A]">Surat Terbit & Selesai</h3>
                <p class="text-xs text-[#6C7B72] leading-relaxed">Unduh surat digital bertanda tangan resmi atau ambil cetakan di kantor balai desa.</p>
            </div>
        </div>
    </div>
</section>

@endsection
