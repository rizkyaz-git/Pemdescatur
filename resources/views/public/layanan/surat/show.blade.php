@extends('layouts.public')

@section('title', 'Status Permohonan Surat - Pemerintah Desa Catur')
@section('meta_description', 'Lacak status permohonan surat Anda di Pemerintah Desa Catur menggunakan nomor tiket.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="text-left space-y-2">
                <x-breadcrumbs :items="[
                    ['label' => 'Layanan', 'url' => '/'],
                    ['label' => 'Pengajuan Surat', 'url' => route('warga.letter.index')],
                    ['label' => 'Status Permohonan']
                ]" />
                <div>
                    <h1 class="font-serif text-2xl font-bold text-slate-900 tracking-tight">Status Permohonan Surat</h1>
                    <p class="text-xs text-slate-500 mt-1">Tiket: <strong class="font-mono text-[#0A3D29]">{{ $letterRequest->ticket_number }}</strong></p>
                </div>
            </div>

            {{-- Flash Success --}}
            @if(session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-green-800 font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8 space-y-6">

                {{-- Progress Tracker --}}
                <div class="border-b border-slate-100 pb-6">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4">Proses Verifikasi Tiket</p>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-10 h-10 rounded-full bg-[#0A3D29] text-white flex items-center justify-center font-bold text-sm mb-1">
                                1
                            </div>
                            <span class="font-semibold text-slate-700">Diajukan</span>
                        </div>

                        <div class="flex-1 h-1 mx-2 {{ $letterRequest->status !== 'pending' ? 'bg-[#0A3D29]' : 'bg-slate-200' }}"></div>

                        <div class="flex flex-col items-center text-center">
                            <div class="w-10 h-10 rounded-full {{ $letterRequest->status !== 'pending' ? 'bg-[#0A3D29] text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center font-bold text-sm mb-1">
                                2
                            </div>
                            <span class="font-semibold text-slate-700">Verifikasi Admin</span>
                        </div>

                        <div class="flex-1 h-1 mx-2 {{ $letterRequest->status === 'approved' ? 'bg-[#0A3D29]' : 'bg-slate-200' }}"></div>

                        <div class="flex flex-col items-center text-center">
                            <div class="w-10 h-10 rounded-full {{ $letterRequest->status === 'approved' ? 'bg-[#0A3D29] text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center font-bold text-sm mb-1">
                                3
                            </div>
                            <span class="font-semibold text-slate-700">Selesai / Terbit</span>
                        </div>
                    </div>
                </div>

                {{-- Detail Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jenis Surat</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $letterRequest->template ? ($letterRequest->template->title ?? $letterRequest->template->name) : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Tiket</p>
                        <div class="mt-1">
                            @if($letterRequest->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-800 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Verifikasi Admin
                                </span>
                            @elseif($letterRequest->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-[#DCFCE7] text-[#15803D]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                                    Surat Disetujui &amp; Diterbitkan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(data_get($letterRequest->form_data, 'nama'))
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Pemohon</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ data_get($letterRequest->form_data, 'nama') }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Pengajuan</p>
                        <p class="font-semibold text-slate-800 mt-1 tabular-nums">{{ $letterRequest->created_at ? $letterRequest->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                </div>

                @if($letterRequest->admin_notes)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs">
                        <p class="font-bold text-slate-700 mb-1">Catatan Petugas Desa:</p>
                        <p class="text-slate-600 leading-relaxed">{{ $letterRequest->admin_notes }}</p>
                    </div>
                @endif

                {{-- Download Button --}}
                @if($letterRequest->result_file_path)
                    <div class="bg-green-50/60 border border-green-200 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#16A34A]"></span>
                                <p class="text-sm font-bold text-green-900">Surat Anda Sudah Selesai Diterbitkan!</p>
                            </div>
                            <p class="text-xs text-green-700 mt-1">Silakan unduh dokumen PDF resmi berikut ini.</p>
                        </div>
                        <a href="{{ asset('storage/' . $letterRequest->result_file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs px-5 py-2.5 rounded-lg shadow-xs transition shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Surat PDF</span>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
