@extends('layouts.public')

@section('title', 'Lacak Status Surat - Desa Catur')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-start justify-between text-left">
            <div>
                <x-breadcrumbs :items="[
                    ['label' => 'SURAT', 'url' => route('warga.letter.index')],
                    ['label' => 'Status Permohonan']
                ]" />
                <h1 class="font-serif text-2xl font-bold text-gray-900">Detail Status Permohonan Surat</h1>
                <p class="text-xs text-gray-500 mt-1">Tiket: <strong class="font-mono text-emerald-800">{{ $letterRequest->ticket_number }}</strong></p>
            </div>
            <a href="{{ route('warga.letter.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2 rounded-xl transition shrink-0">
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
            <!-- Progress Tracker -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Proses Verifikasi Tiket</p>
                <div class="flex items-center justify-between text-xs">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm mb-1">
                            1
                        </div>
                        <span class="font-semibold text-gray-800">Diajukan</span>
                    </div>

                    <div class="flex-1 h-1 mx-2 {{ $letterRequest->status !== 'pending' ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 rounded-full {{ $letterRequest->status !== 'pending' ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center font-bold text-sm mb-1">
                            2
                        </div>
                        <span class="font-semibold text-gray-800">Verifikasi Admin</span>
                    </div>

                    <div class="flex-1 h-1 mx-2 {{ $letterRequest->status === 'approved' ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 rounded-full {{ $letterRequest->status === 'approved' ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center font-bold text-sm mb-1">
                            3
                        </div>
                        <span class="font-semibold text-gray-800">Selesai / Terbit</span>
                    </div>
                </div>
            </div>

            <!-- Detail Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Jenis Surat</p>
                    <p class="font-bold text-gray-900">{{ $letterRequest->template ? ($letterRequest->template->title ?? $letterRequest->template->name) : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Status Tiket</p>
                    <div class="mt-1">
                        @if($letterRequest->status === 'pending')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Menunggu Verifikasi Admin</span>
                        @elseif($letterRequest->status === 'approved')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Surat Disetujui & Diterbitkan</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($letterRequest->admin_notes)
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-xs">
                    <p class="font-bold text-gray-700 mb-1">Catatan Petugas Desa:</p>
                    <p class="text-gray-600">{{ $letterRequest->admin_notes }}</p>
                </div>
            @endif

            <!-- Download Button -->
            @if($letterRequest->result_file_path)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 text-center space-y-3">
                    <p class="text-base font-bold text-emerald-900">🎉 Surat Anda Sudah Selesai Diterbitkan!</p>
                    <p class="text-xs text-emerald-700">Silakan unduh dokumen PDF resmi berikut ini:</p>
                    <a href="{{ asset('storage/' . $letterRequest->result_file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md transition">
                        ⬇️ Download Surat PDF Resmi
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
