@extends('layouts.public')

@section('title', 'Tautan Tidak Berlaku - Portal Pengaduan Desa Catur')
@section('meta_description', 'Tautan verifikasi atau masuk privat telah kedaluwarsa atau tidak valid.')

@section('content')
<div class="bg-white min-h-screen py-12 sm:py-16 border-b border-slate-200">
    <div class="max-w-lg mx-auto px-4 sm:px-6 space-y-6 text-center">

        <div class="w-16 h-16 mx-auto rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200/80 shadow-xs">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <div class="space-y-2">
            <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-[#20332A] tracking-tight">
                Tautan tidak berlaku
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm mx-auto">
                Tautan verifikasi atau akses masuk mungkin sudah kedaluwarsa (lebih dari batas waktu), telah digunakan sebelumnya, atau tautan tidak valid.
            </p>
        </div>

        <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 text-xs text-slate-500 text-left space-y-1.5">
            <p class="font-semibold text-slate-700">Mengapa ini terjadi?</p>
            <ul class="list-disc pl-4 space-y-1">
                <li>Tautan verifikasi laporan hanya aktif selama 15 menit.</li>
                <li>Tautan masuk portal hanya aktif selama 10 menit.</li>
                <li>Setiap tautan hanya dapat digunakan satu kali demi keamanan data.</li>
            </ul>
        </div>

        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('pelapor.login.request') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs sm:text-sm px-6 py-3 rounded-xl shadow-xs transition active:scale-95 cursor-pointer">
                <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Minta Tautan Masuk Baru</span>
            </a>

            <a href="{{ route('warga.complaint.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm px-5 py-3 rounded-xl transition active:scale-95 cursor-pointer">
                <span>Kembali ke Beranda Pengaduan</span>
            </a>
        </div>

    </div>
</div>
@endsection
