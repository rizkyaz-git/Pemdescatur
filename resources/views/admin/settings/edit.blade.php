@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6 font-sans">

        <!-- Header Section -->
        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-6">
            <div class="border-b border-[#E2E8F0] pb-5">
                <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Pengaturan Website &
                    Identitas Desa</h1>
            </div>

            @if(session('success'))
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center justify-between text-sm shadow-xs animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()"
                        class="text-emerald-500 hover:text-emerald-700 p-1">&times;</button>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Block 1: Logo Desa (FR-19) -->
                <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                    <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                        <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                            <span>Logo Resmi Desa Catur (FR-19)</span>
                        </h3>
                        <span class="text-[11px] font-semibold text-slate-400">Identitas Visual</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div
                            class="w-24 h-24 bg-white border-2 border-dashed border-[#E2E8F0] rounded-2xl p-2 flex items-center justify-center shadow-xs overflow-hidden shrink-0">
                            @if(!empty($settings['village_logo_path']))
                                <img src="{{ asset('storage/' . $settings['village_logo_path']) }}"
                                    class="max-w-full max-h-full object-contain">
                            @else
                                <span class="text-slate-400 text-xs text-center font-medium">Belum ada logo</span>
                            @endif
                        </div>

                        <div class="flex-1 space-y-2 w-full">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Unggah / Ganti
                                Logo Desa</label>
                            <input type="file" name="village_logo" accept="image/*"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                            <p class="text-[11px] text-slate-500 font-medium">*Rekomendasi Ukuran: <strong>512 x 512
                                    px</strong> (Rasio 1:1. Format <strong>PNG/SVG Transparan</strong>). Maks <strong> 2 MB.
                                </strong></p>
                        </div>
                    </div>

                    @if(!empty($settings['village_logo_path']))
                        <div class="pt-2">
                            <button type="submit" form="delete-logo-form"
                                class="text-xs text-rose-600 hover:text-rose-800 font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Hapus Logo</span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Block 1B: Background Hero Section -->
                <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                    <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                        <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                            <span>Gambar Latar Sampul Utama</span>
                        </h3>
                        <span class="text-xs font-semibold text-slate-400">Halaman Utama (Beranda)</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div
                            class="w-44 h-24 bg-slate-200 border border-slate-300 rounded-xl overflow-hidden shadow-xs shrink-0 flex items-center justify-center group">
                            @if(!empty($settings['hero_image_path']))
                                <img src="{{ asset('storage/' . $settings['hero_image_path']) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <img src="{{ asset('images/hero_landscape.png') }}"
                                    class="w-full h-full object-cover opacity-80" title="Background Bawaan">
                            @endif
                        </div>

                        <div class="flex-1 space-y-2 w-full">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Unggah / Ganti
                                Gambar </label>
                            <input type="file" name="hero_image" accept="image/*"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                            <p class="text-[11px] text-slate-500 font-medium"> *Rekomendasi Resolusi: <strong>1920 x 1080
                                    px</strong> (Rasio 16:9). Format <strong> JPG/PNG/WEBP.</strong> Maks <strong> 5 MB.
                                </strong></p>
                        </div>
                    </div>

                    @if(!empty($settings['hero_image_path']))
                        <div class="pt-2">
                            <button type="submit" form="delete-hero-form"
                                class="text-xs text-rose-600 hover:text-rose-800 font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Reset Gambar</span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Block 2: Tautan Perpustakaan Digital (FR-16) -->
                <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                    <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                        <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                            <span> Link Perpustakaan Digital Remen Maos</span>
                        </h3>
                        <span class="text-xs font-semibold text-slate-400">Tautan Layanan</span>
                    </div>

                    <div class="space-y-1.5">
                        <input type="url" name="library_url" value="{{ old('library_url', $settings['library_url']) }}"
                            required
                            class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] font-mono text-xs p-3 bg-white shadow-xs"
                            placeholder="https://perpustakaan.boyolali.go.id">
                        <p class="text-[11px] text-slate-400">Link akses menuju perpustakaan digital desa</p>
                    </div>
                </div>

                <!-- Block 3: Identitas Umum & Kontak Desa -->
                <div class="p-6 bg-white rounded-2xl border border-[#E2E8F0] space-y-5">
                    <div class="border-b border-[#E2E8F0] pb-3">
                        <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                            <span>Identitas & Informasi Kontak Resmi</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Desa <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" name="village_name"
                                value="{{ old('village_name', $settings['village_name']) }}" required
                                class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kecamatan &
                                Kabupaten</label>
                            <input type="text" name="village_district"
                                value="{{ old('village_district', $settings['village_district']) }}"
                                class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Lengkap Kantor
                            Desa</label>
                        <input type="text" name="village_address"
                            value="{{ old('village_address', $settings['village_address']) }}"
                            class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor Telepon /
                                WhatsApp Desa</label>
                            <input type="text" name="village_phone"
                                value="{{ old('village_phone', $settings['village_phone']) }}"
                                class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Resmi
                                Desa</label>
                            <input type="email" name="village_email"
                                value="{{ old('village_email', $settings['village_email']) }}"
                                class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                        </div>
                    </div>
                </div>

                <div class="pt-5 border-t border-[#E2E8F0] flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-jakarta font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>

            <form id="delete-logo-form" action="{{ route('admin.settings.delete-logo') }}" method="POST" class="hidden"
                onsubmit="return confirm('Hapus logo desa?')">
                @csrf
                @method('DELETE')
            </form>

            <form id="delete-hero-form" action="{{ route('admin.settings.delete-hero') }}" method="POST" class="hidden"
                onsubmit="return confirm('Hapus gambar background hero kustom?')">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

@endsection