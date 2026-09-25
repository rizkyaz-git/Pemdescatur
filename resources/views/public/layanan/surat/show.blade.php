@extends('layouts.public')

@section('title', 'Status Permohonan Surat - Pemerintah Desa Catur')
@section('meta_description', 'Lihat informasi pengajuan surat yang telah dikirim melalui layanan Pemerintah Desa Catur.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="space-y-2">
                <x-breadcrumbs :items="[
                    ['label' => 'Beranda', 'url' => route('home')],
                    ['label' => 'Pengajuan Surat', 'url' => route('warga.letter.index')],
                    ['label' => 'Status Permohonan']
                ]" />
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Status Permohonan Surat</h1>
            </div>

            {{-- Main Card --}}
            <div class="rounded-xl border border-slate-200/90 bg-white shadow-xs p-5 sm:p-8 space-y-6">
                <div class="border-b border-slate-100 pb-6">
                    <h2 class="text-sm font-bold text-slate-900">Informasi Pengajuan</h2>

                    <dl class="mt-5 grid grid-cols-1 gap-x-8 gap-y-5 text-sm sm:grid-cols-2">
                        <div class="min-w-0">
                            <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Jenis Surat</dt>
                            <dd class="mt-1 break-words font-semibold text-slate-900">
                                @if(data_get($letterRequest->form_data, 'jenis_surat_lainnya'))
                                    {{ data_get($letterRequest->form_data, 'jenis_surat_lainnya') }}
                                    <span class="text-xs font-normal text-slate-500">(Lainnya)</span>
                                @else
                                    {{ $letterRequest->template ? ($letterRequest->template->title ?? $letterRequest->template->name) : '-' }}
                                @endif
                            </dd>
                        </div>

                        @if(data_get($letterRequest->form_data, 'nama'))
                            <div class="min-w-0">
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nama Pemohon</dt>
                                <dd class="mt-1 break-words font-semibold text-slate-900">{{ data_get($letterRequest->form_data, 'nama') }}</dd>
                            </div>
                        @endif

                        <div class="min-w-0">
                            <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pengajuan</dt>
                            <dd class="mt-1 font-semibold tabular-nums text-slate-900">{{ $letterRequest->created_at ? $letterRequest->created_at->format('d/m/Y H:i') : '-' }}</dd>
                        </div>

                        @if(data_get($letterRequest->form_data, 'keperluan'))
                            <div class="min-w-0 sm:col-span-2">
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Keperluan</dt>
                                <dd class="mt-1 whitespace-pre-line break-words leading-relaxed text-slate-700">{{ data_get($letterRequest->form_data, 'keperluan') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Catatan Petugas Desa --}}
                @if($letterRequest->admin_notes)
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-xs">
                        <p class="mb-1 font-bold text-slate-700">Catatan Petugas Desa:</p>
                        <p class="whitespace-pre-line leading-relaxed text-slate-600">{{ $letterRequest->admin_notes }}</p>
                    </div>
                @endif

                {{-- Download Button --}}
                @if($letterRequest->result_file_path)
                    <div class="flex flex-col justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 p-5 sm:flex-row sm:items-center">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-[#0A3D29]"></span>
                                <p class="text-sm font-bold text-slate-900">Surat Anda Sudah Selesai Diterbitkan!</p>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Silakan unduh dokumen PDF resmi berikut ini.</p>
                        </div>
                        <a href="{{ asset('storage/' . $letterRequest->result_file_path) }}" target="_blank"
                           class="inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#0A3D29] px-5 py-2.5 text-xs font-semibold text-white shadow-xs transition hover:bg-[#072B1D]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Surat PDF</span>
                        </a>
                    </div>
                @endif

                {{-- Tombol Navigasi --}}
                <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('warga.letter.index') }}"
                       class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-center text-xs font-semibold text-slate-600 transition hover:bg-slate-50 sm:w-auto">
                        Kembali
                    </a>

                    <a href="{{ route('warga.letter.index') }}"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#0A3D29] px-5 py-2.5 text-center text-xs font-semibold text-white shadow-xs transition hover:bg-[#072B1D] active:scale-95 sm:w-auto">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Ajukan Surat Baru</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
