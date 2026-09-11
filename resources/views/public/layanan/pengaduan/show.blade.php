@extends('layouts.public')

@section('title', 'Detail Tanggapan Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Pantau detail tindak lanjut dan respon resmi Pemerintah Desa Catur terhadap laporan pengaduan warga.')

@section('content')
<div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        {{-- Navigation Header --}}
        <div class="text-left space-y-2">
            <x-breadcrumbs :items="[
                ['label' => 'PENGADUAN', 'url' => route('warga.complaint.index')],
                ['label' => 'Detail Laporan']
            ]" />
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <a href="{{ route('warga.complaint.index') }}" 
                       class="w-10 h-10 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
                       title="Kembali ke Daftar Pengaduan"
                       aria-label="Kembali">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Detail Laporan &amp; Tanggapan</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Informasi rincian dan tindak lanjut laporan pengaduan warga.</p>
                    </div>
                </div>

                <a href="{{ route('warga.complaint.create') }}" 
                   class="inline-flex items-center gap-1.5 bg-[#0A3D29] hover:bg-[#072B1D] text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition shadow-xs shrink-0">
                    <svg class="w-3.5 h-3.5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden sm:inline">Tulis Laporan Baru</span>
                    <span class="sm:hidden">Baru</span>
                </a>
            </div>
        </div>

        {{-- Main Detail Card --}}
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8 space-y-6">
            
            {{-- Category, Date, Status Info Bar --}}
            <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-slate-100 text-slate-700">
                        {{ $complaint->category ? $complaint->category->name : 'Kategori Umum' }}
                    </span>
                    <span class="text-xs text-slate-400">
                        {{ $complaint->created_at ? $complaint->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB
                    </span>
                </div>

                <div>
                    @if($complaint->status === 'new')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full bg-slate-50 text-slate-700 border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            <span>Menunggu Respon</span>
                        </span>
                    @elseif($complaint->status === 'processing')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full bg-amber-50/50 text-amber-800 border border-amber-200/70">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>Sedang Ditindaklanjuti</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-50/50 text-[#0A3D29] border border-emerald-200/70">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0A3D29]"></span>
                            <span>Selesai Ditanggapi</span>
                        </span>
                    @endif
                </div>
            </div>

            {{-- Title & Body --}}
            <div class="space-y-3">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-slate-900 leading-snug">
                    {{ $complaint->title }}
                </h2>
                <div class="space-y-1.5 pt-1">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                        Rincian Laporan
                    </span>
                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $complaint->description }}
                    </p>
                </div>
            </div>

            {{-- Attachment Photo if available --}}
            @if($complaint->attachment_path)
                <div class="space-y-2 pt-2">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                        Lampiran Foto Bukti
                    </span>
                    <div class="inline-block">
                        <a href="{{ asset('storage/' . $complaint->attachment_path) }}" target="_blank" class="group block">
                            <img src="{{ asset('storage/' . $complaint->attachment_path) }}" 
                                 alt="Lampiran Bukti Pengaduan" 
                                 class="max-h-72 rounded-lg border border-slate-200 shadow-xs group-hover:opacity-95 transition">
                            <span class="text-[11px] text-slate-400 group-hover:text-[#0A3D29] mt-1 block">
                                Klik untuk melihat ukuran penuh ↗
                            </span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Official Village Response Box --}}
            <div class="pt-4 border-t border-slate-100">
                @if(!empty($complaint->admin_response))
                    <div class="bg-slate-50/80 border border-slate-200 rounded-xl p-5 sm:p-6 space-y-2.5">
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#0A3D29]"></span>
                                <h3 class="font-serif font-bold text-xs sm:text-sm text-slate-900">
                                    Tanggapan Resmi Pemerintah Desa Catur
                                </h3>
                            </div>
                            <span class="text-[11px] text-slate-500">
                                {{ $complaint->responded_at ? \Carbon\Carbon::parse($complaint->responded_at)->translatedFormat('d F Y, H:i') : '' }} WIB
                            </span>
                        </div>
                        <p class="text-sm text-slate-800 whitespace-pre-line leading-relaxed pt-1">
                            {{ $complaint->admin_response }}
                        </p>
                    </div>
                @else
                    <div class="bg-slate-50/60 border border-slate-200/70 rounded-xl p-5 text-center space-y-1">
                        <p class="text-xs font-semibold text-slate-700">Laporan Telah Diterima Sistem</p>
                        <p class="text-xs text-slate-500">
                            Pengaduan Anda sedang dalam antrean verifikasi dan akan segera ditanggapi oleh Pemerintah Desa Catur.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
