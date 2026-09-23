@extends('layouts.public')

@section('title', 'Status Permohonan Surat - Pemerintah Desa Catur')
@section('meta_description', 'Lacak status permohonan surat Anda di Pemerintah Desa Catur menggunakan nomor tiket resmi.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="text-left space-y-2">
                <x-breadcrumbs :items="[
                    ['label' => 'Beranda', 'url' => route('home')],
                    ['label' => 'Pengajuan Surat', 'url' => route('warga.letter.index')],
                    ['label' => 'Status Permohonan']
                ]" />
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Status Permohonan Surat</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Nomor Tiket: <strong class="font-mono text-[#0A3D29] text-sm sm:text-base font-bold">{{ $letterRequest->ticket_number }}</strong>
                        </p>
                    </div>
                    <a href="{{ route('warga.letter.templates') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0A3D29] hover:text-[#072B1D] underline underline-offset-4 shrink-0 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span>Template Cetak Mandiri</span>
                    </a>
                </div>
            </div>

            {{-- Flash Success Alert --}}
            @if(session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-emerald-900 font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8 space-y-6">

                {{-- Progress Tracker Stepper --}}
                <div class="border-b border-slate-100 pb-6">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-5">Progres Verifikasi Surat</p>
                    
                    <div class="flex items-center justify-between text-xs">
                        {{-- Step 1: Diajukan --}}
                        <div class="flex flex-col items-center text-center w-24">
                            <div class="w-10 h-10 rounded-full bg-[#0A3D29] text-white flex items-center justify-center font-bold text-sm mb-1.5 shadow-xs">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold text-slate-800">Diajukan</span>
                        </div>

                        {{-- Line 1 --}}
                        <div class="flex-1 h-1 mx-2 rounded-full transition-colors {{ $letterRequest->status !== 'pending' ? 'bg-[#0A3D29]' : 'bg-slate-200' }}"></div>

                        {{-- Step 2: Verifikasi Petugas --}}
                        <div class="flex flex-col items-center text-center w-28">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mb-1.5 transition-colors {{ $letterRequest->status !== 'pending' ? 'bg-[#0A3D29] text-white shadow-xs' : 'bg-slate-100 text-slate-400' }}">
                                @if($letterRequest->status === 'approved')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif($letterRequest->status === 'rejected')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @else
                                    2
                                @endif
                            </div>
                            <span class="font-semibold text-slate-800">Verifikasi Admin</span>
                        </div>

                        {{-- Line 2 --}}
                        <div class="flex-1 h-1 mx-2 rounded-full transition-colors {{ $letterRequest->status === 'approved' ? 'bg-[#0A3D29]' : 'bg-slate-200' }}"></div>

                        {{-- Step 3: Selesai / Terbit --}}
                        <div class="flex flex-col items-center text-center w-24">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mb-1.5 transition-colors {{ $letterRequest->status === 'approved' ? 'bg-[#0A3D29] text-white shadow-xs' : 'bg-slate-100 text-slate-400' }}">
                                @if($letterRequest->status === 'approved')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    3
                                @endif
                            </div>
                            <span class="font-semibold text-slate-800">Selesai / Terbit</span>
                        </div>
                    </div>
                </div>

                {{-- Detail Information --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jenis Surat</p>
                        <p class="font-semibold text-slate-900 mt-1">
                            @if(data_get($letterRequest->form_data, 'jenis_surat_lainnya'))
                                {{ data_get($letterRequest->form_data, 'jenis_surat_lainnya') }}
                                <span class="text-xs font-normal text-slate-500">(Lainnya)</span>
                            @else
                                {{ $letterRequest->template ? ($letterRequest->template->title ?? $letterRequest->template->name) : '-' }}
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Tiket</p>
                        <div class="mt-1">
                            @if($letterRequest->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-800 border border-amber-200/70">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Verifikasi Admin
                                </span>
                            @elseif($letterRequest->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Surat Disetujui &amp; Diterbitkan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    @if(data_get($letterRequest->form_data, 'nama'))
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Pemohon</p>
                            <p class="font-semibold text-slate-900 mt-1">{{ data_get($letterRequest->form_data, 'nama') }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Pengajuan</p>
                        <p class="font-semibold text-slate-900 mt-1 tabular-nums">{{ $letterRequest->created_at ? $letterRequest->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>

                    @if(data_get($letterRequest->form_data, 'keperluan'))
                        <div class="sm:col-span-2">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Keperluan</p>
                            <p class="text-slate-700 mt-1 leading-relaxed">{{ data_get($letterRequest->form_data, 'keperluan') }}</p>
                        </div>
                    @endif
                </div>

                {{-- Catatan Petugas Desa --}}
                @if($letterRequest->admin_notes)
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-xs">
                        <p class="font-bold text-slate-700 mb-1">Catatan Petugas Desa:</p>
                        <p class="text-slate-600 leading-relaxed">{{ $letterRequest->admin_notes }}</p>
                    </div>
                @endif

                {{-- Download Button --}}
                @if($letterRequest->result_file_path)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#0A3D29]"></span>
                                <p class="text-sm font-bold text-slate-900">Surat Anda Sudah Selesai Diterbitkan!</p>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Silakan unduh dokumen PDF resmi berikut ini.</p>
                        </div>
                        <a href="{{ asset('storage/' . $letterRequest->result_file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs px-5 py-2.5 rounded-lg shadow-xs transition shrink-0 cursor-pointer">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Surat PDF</span>
                        </a>
                    </div>
                @endif

                {{-- Tombol Navigasi --}}
                <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-slate-100">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold text-center transition">
                        Kembali ke Beranda
                    </a>

                    <a href="{{ route('warga.letter.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-5 rounded-lg shadow-xs transition active:scale-95 text-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Ajukan Surat Baru</span>
                    </a>
                </div>

            </div>

        </div>
    </div>
@endsection
