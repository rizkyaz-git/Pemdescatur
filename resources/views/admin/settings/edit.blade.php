@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6 font-sans">

        <!-- Header Section -->
        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-6">
            <div class="border-b border-[#E2E8F0] pb-5 flex items-center justify-between gap-4">
                <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Pengaturan Website &
                    Identitas Desa</h1>
                {{-- Tombol Bersihkan Cache (POST, CSRF-protected) --}}
                <form method="POST" action="{{ route('admin.clear-cache') }}"
                      onsubmit="return confirm('Yakin ingin membersihkan semua cache aplikasi?')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 text-xs font-semibold px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Bersihkan Cache
                    </button>
                </form>
            </div>


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

                    <x-file-picker 
                        name="village_logo" 
                        accept="image/*" 
                        current="{{ !empty($settings['village_logo_path']) ? asset('storage/' . $settings['village_logo_path']) : '' }}" 
                        currentName="{{ basename($settings['village_logo_path'] ?? '') }}" 
                    />
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

                <x-file-picker 
                    name="hero_image" 
                    accept="image/*" 
                    current="{{ !empty($settings['hero_image_path']) ? asset('storage/' . $settings['hero_image_path']) : asset('images/hero_landscape.png') }}" 
                    currentName="{{ basename($settings['hero_image_path'] ?? 'hero_landscape.png') }}" 
                />

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
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Link Akun Instagram Desa</label>
                            <input type="text" name="village_instagram"
                                value="{{ old('village_instagram', $settings['village_instagram']) }}"
                                placeholder="https://www.instagram.com/pemdescatur atau @pemdescatur"
                                class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                            <p class="text-[11px] text-slate-400">Masukkan link URL profil Instagram atau username akun desa (misal: @pemdescatur).</p>
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

                <!-- Block 4: Pengaturan Berita Utama (Featured Headline) -->
                <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                    <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                        <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                            <span>Berita Utama (Headline Halaman Berita)</span>
                        </h3>
                        <span class="text-xs font-semibold text-slate-400">Portal Berita</span>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Pilih Berita yang Dijadikan Berita Utama
                        </label>
                        <select name="featured_news_id" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                            <option value="">-- Otomatis (Berita Terakhir yang Diterbitkan) --</option>
                            @if(isset($publishedNews))
                                @foreach($publishedNews as $pNews)
                                    <option value="{{ $pNews->id }}" {{ (string) old('featured_news_id', $settings['featured_news_id']) === (string) $pNews->id ? 'selected' : '' }}>
                                        [{{ $pNews->category }}] {{ $pNews->title }} ({{ $pNews->published_at ? $pNews->published_at->format('d/m/Y') : '-' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <p class="text-[11px] text-slate-400">
                            Berita yang dipilih akan tampil di kolom tengah Hero Section pada halaman Berita. Anda juga dapat langsung mengaturnya melalui tombol "Set Utama" di tabel Daftar Berita.
                        </p>
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