@extends('layouts.public')

@section('title', 'Sampaikan Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Formulir pengaduan warga kepada Pemerintah Desa Catur. Sampaikan keluhan, aspirasi, atau permasalahan Anda dan kami akan menindaklanjuti melalui WhatsApp.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="text-left space-y-2">
                <x-breadcrumbs :items="[
                    ['label' => 'Layanan', 'url' => '/'],
                    ['label' => 'Pengaduan']
                ]" />
                <div>
                    <h1 class="font-serif text-2xl font-bold text-slate-900 tracking-tight">Sampaikan Pengaduan & Aspirasi</h1>
                    <p class="text-xs text-slate-500 mt-1">Isi formulir di bawah. Admin Desa akan menghubungi Anda melalui WhatsApp untuk menindaklanjuti.</p>
                </div>
            </div>

            {{-- Flash Success --}}
            @if(session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-green-800 font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
                <form action="{{ route('warga.complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('nama') border-rose-500 @enderror">
                        @error('nama')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No WhatsApp --}}
                    <div>
                        <label for="no_whatsapp" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="no_whatsapp" id="no_whatsapp" value="{{ old('no_whatsapp') }}" required
                            placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('no_whatsapp') border-rose-500 @enderror">
                        <p class="text-[11px] text-slate-400 mt-1">Admin akan menghubungi Anda melalui nomor ini untuk menindaklanjuti laporan.</p>
                        @error('no_whatsapp')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Kategori Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('kategori') border-rose-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @php
                                $kategoris = [
                                    'infrastruktur'  => 'Infrastruktur & Fasilitas Umum',
                                    'kependudukan'   => 'Administrasi & Kependudukan',
                                    'keamanan'       => 'Keamanan & Ketertiban',
                                    'lingkungan'     => 'Lingkungan & Kebersihan',
                                    'layanan_publik' => 'Layanan Publik',
                                    'lainnya'        => 'Lainnya',
                                ];
                            @endphp
                            @foreach($kategoris as $val => $label)
                                <option value="{{ $val }}" {{ old('kategori') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Isi Laporan --}}
                    <div>
                        <label for="isi_laporan" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Isi Laporan / Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="isi_laporan" id="isi_laporan" rows="5" required
                            placeholder="Jelaskan secara rinci permasalahan yang Anda laporkan, termasuk lokasi dan kronologi kejadian..."
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('isi_laporan') border-rose-500 @enderror">{{ old('isi_laporan') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Minimal 10 karakter, maksimal 2.000 karakter.</p>
                        @error('isi_laporan')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lampiran --}}
                    <div>
                        <label for="lampiran" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Lampiran Bukti <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="file" name="lampiran" id="lampiran" accept="image/jpg,image/jpeg,image/png,application/pdf"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0A3D29] file:text-white hover:file:bg-[#072B1D] cursor-pointer bg-slate-50/50 p-2 rounded-lg border border-slate-300 shadow-xs @error('lampiran') border-rose-500 @enderror">
                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.</p>
                        @error('lampiran')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="reset"
                            class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                            Reset
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-6 rounded-lg transition shadow-xs cursor-pointer">
                            <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span>Kirim Laporan Pengaduan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection