@extends('layouts.public')

@section('title', 'Cek Laporan Saya - Pemerintah Desa Catur')
@section('meta_description', 'Masuk ke portal pengaduan warga untuk mengecek status dan tanggapan laporan Anda via tautan privat aman.')

@section('content')
<div class="bg-white min-h-screen py-8 sm:py-14 border-b border-slate-200">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Navigation Header --}}
        <div class="text-left space-y-3">
            <x-breadcrumbs :items="[
                ['label' => 'BERANDA', 'url' => route('home')],
                ['label' => 'Pengaduan Warga', 'url' => route('warga.complaint.index')],
                ['label' => 'Cek Laporan Saya']
            ]" />

            <div class="flex items-center gap-3.5 pt-1">
                <a href="{{ route('warga.complaint.index') }}"
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0 active:scale-95"
                   title="Kembali ke Halaman Sampul Pengaduan" aria-label="Kembali">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-[#20332A] tracking-tight">
                        Cek Status Laporan Saya
                    </h1>
                </div>
            </div>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-bold text-emerald-900">Tautan Masuk Terkirim!</p>
                    <p class="mt-0.5 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Login Request Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-serif font-bold text-base text-slate-900">Masuk Tanpa Kata Sandi</h2>
                    <p class="text-xs text-slate-500">Cukup masukkan email yang Anda gunakan saat mengirim laporan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('pelapor.login.send') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-semibold text-slate-800">
                        Alamat Email Terdaftar <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border @error('email') border-rose-500 ring-1 ring-rose-500/20 @else border-slate-300 @enderror text-sm text-slate-900 placeholder:text-slate-400 bg-slate-50/40 focus:bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-2 focus:ring-[#0A3D29]/20 transition shadow-xs">
                    @error('email')
                        <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-sm py-3 px-6 rounded-xl shadow-xs hover:shadow-md transition active:scale-[0.98] cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                        <span>Kirim Tautan Akses Privat</span>
                    </button>
                </div>
            </form>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-500 space-y-1">
                <p class="font-semibold text-slate-700">Catatan Keamanan:</p>
                <p class="leading-relaxed">Tautan akses yang dikirim ke email hanya berlaku selama 10 menit. Pastikan untuk memeriksa folder <em>Kotak Masuk (Inbox)</em> atau <em>Spam</em> Anda.</p>
            </div>
        </div>

        {{-- Footer Callout --}}
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500">
                Belum pernah membuat laporan?
                <a href="{{ route('warga.complaint.create') }}" class="text-[#0A3D29] font-bold hover:underline ml-1">
                    Tulis Pengaduan Baru &rarr;
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
