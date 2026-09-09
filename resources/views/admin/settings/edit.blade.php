@extends('layouts.admin')

@section('title', 'Pengaturan Website & Identitas')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 200px; font-size: 0.875rem; line-height: 1.6; font-family: inherit; }
    .ql-toolbar.ql-snow { border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; background-color: #F8FAFC; border-color: #E2E8F0; }
    .ql-container.ql-snow { border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem; border-color: #E2E8F0; font-family: inherit; }
    .ql-toolbar button svg,
    .ql-toolbar .ql-picker-label svg { width: 16px !important; height: 16px !important; display: inline-block !important; float: none !important; }
    .ql-toolbar button { width: 28px !important; height: 28px !important; padding: 3px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; float: left !important; }
    .ql-snow .ql-stroke { stroke: #475569 !important; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2; fill: none !important; }
    .ql-snow .ql-fill { fill: #475569 !important; }
    .ql-snow .ql-picker { color: #475569 !important; float: left !important; }
</style>
@endpush

@section('content')

<div class="max-w-4xl mx-auto space-y-6 font-sans">
    
    <!-- Header Section -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-6">
        <div class="border-b border-[#E2E8F0] pb-5">
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Pengaturan Website & Identitas Desa</h1>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi logo desa, background hero, sambutan pimpinan, tautan perpustakaan, serta kontak resmi pemerintahan.</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center justify-between text-sm shadow-xs animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">&times;</button>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Block 1: Logo Desa (FR-19) -->
            <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                    <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#0F4C3A] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </span>
                        <span>Logo Resmi Desa Catur (FR-19)</span>
                    </h3>
                    <span class="text-[11px] font-semibold text-slate-400">Identitas Visual</span>
                </div>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="w-24 h-24 bg-white border-2 border-dashed border-[#E2E8F0] rounded-2xl p-2 flex items-center justify-center shadow-xs overflow-hidden shrink-0">
                        @if(!empty($settings['village_logo_path']))
                            <img src="{{ asset('storage/' . $settings['village_logo_path']) }}" class="max-w-full max-h-full object-contain">
                        @else
                            <span class="text-slate-400 text-xs text-center font-medium">Belum ada logo</span>
                        @endif
                    </div>

                    <div class="flex-1 space-y-2 w-full">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Unggah / Ganti Logo Desa</label>
                        <input type="file" name="village_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                        <p class="text-[11px] text-slate-500 font-medium">📐 Rekomendasi Ukuran: <strong>512 x 512 px</strong> (Rasio 1:1 Persegi, PNG/SVG Transparan). Maks 2 MB.</p>
                    </div>
                </div>

                @if(!empty($settings['village_logo_path']))
                    <div class="pt-2">
                        <button type="submit" form="delete-logo-form" class="text-xs text-rose-600 hover:text-rose-800 font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Hapus Logo Saat Ini</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Block 1B: Background Hero Section -->
            <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                    <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#0F4C3A] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        <span>Gambar Background Hero Section Utama</span>
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Halaman Utama (Landing Page)</span>
                </div>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="w-44 h-24 bg-slate-200 border border-slate-300 rounded-xl overflow-hidden shadow-xs shrink-0 flex items-center justify-center group">
                        @if(!empty($settings['hero_image_path']))
                            <img src="{{ asset('storage/' . $settings['hero_image_path']) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <img src="{{ asset('images/hero_landscape.png') }}" class="w-full h-full object-cover opacity-80" title="Background Bawaan">
                        @endif
                    </div>

                    <div class="flex-1 space-y-2 w-full">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Unggah / Ganti Gambar Hero</label>
                        <input type="file" name="hero_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                        <p class="text-[11px] text-slate-500 font-medium">📐 Rekomendasi Resolusi: <strong>1920 x 1080 px</strong> (Rasio 16:9 Landscape - Full HD). Format JPG/PNG/WEBP. Maks 5 MB.</p>
                    </div>
                </div>

                @if(!empty($settings['hero_image_path']))
                    <div class="pt-2">
                        <button type="submit" form="delete-hero-form" class="text-xs text-rose-600 hover:text-rose-800 font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Reset ke Gambar Bawaan</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Block 1C: Sambutan & Foto Kepala Desa -->
            <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-5">
                <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                    <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#0F4C3A] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <span>Sambutan & Foto Kepala Desa</span>
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Tampil di Beranda</span>
                </div>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="w-32 h-40 bg-white border border-[#E2E8F0] rounded-xl overflow-hidden shadow-xs shrink-0 flex items-center justify-center relative">
                        @if(!empty($settings['head_photo_path']))
                            <img src="{{ asset('storage/' . $settings['head_photo_path']) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-[10px] text-slate-400 mt-1 font-medium">Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-3 w-full">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Unggah Foto Kepala Desa</label>
                            <input type="file" name="head_photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                            <p class="text-[11px] text-slate-500 font-medium">📐 Rekomendasi Resolusi: <strong>600 x 800 px</strong> (Rasio 3:4 Portrait). Format JPG/PNG/WEBP. Maks 5 MB.</p>
                        </div>

                        @if(!empty($settings['head_photo_path']))
                            <div class="pt-1">
                                <button type="submit" form="delete-head-photo-form" class="text-xs text-rose-600 hover:text-rose-800 font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Hapus Foto Kepala Desa</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Kepala Desa</label>
                        <input type="text" name="head_name" value="{{ old('head_name', $settings['head_name']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs" placeholder="Dra. NUNIK S RAHAYU, M.Pd">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jabatan / Gelar</label>
                        <input type="text" name="head_title" value="{{ old('head_title', $settings['head_title']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs" placeholder="Kepala Desa Catur">
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Sambutan</label>
                    <input type="text" name="welcome_title" value="{{ old('welcome_title', $settings['welcome_title']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs" placeholder="Selamat Datang di Website Resmi Desa Catur">
                </div>

                <div class="space-y-2 pt-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Isi Teks Sambutan Kepala Desa (Rich Text Editor)</label>
                    <div class="bg-white rounded-xl overflow-hidden shadow-xs">
                        <div id="welcome-quill-editor">{!! old('welcome_content', $settings['welcome_content']) !!}</div>
                    </div>
                    <input type="hidden" name="welcome_content" id="welcome_content_input" value="{{ old('welcome_content', $settings['welcome_content']) }}">
                    <p class="text-[11px] text-slate-400">Gunakan toolbar untuk format teks tebal, miring, poin, dan perataan yang akan langsung tampil di beranda.</p>
                </div>
            </div>

            <!-- Block 2: Tautan Perpustakaan Digital (FR-16) -->
            <div class="p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4">
                <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                    <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#0F4C3A] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </span>
                        <span>Perpustakaan Digital "Remen Maos" (FR-16)</span>
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Tautan Layanan</span>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">URL Website Perpustakaan Daerah <span class="text-rose-500">*</span></label>
                    <input type="url" name="library_url" value="{{ old('library_url', $settings['library_url']) }}" required class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] font-mono text-xs p-3 bg-white shadow-xs" placeholder="https://perpustakaan.boyolali.go.id">
                    <p class="text-[11px] text-slate-400">Tautan eksternal yang akan dibuka saat warga mengeklik tombol akses perpustakaan digital.</p>
                </div>
            </div>

            <!-- Block 3: Identitas Umum & Kontak Desa -->
            <div class="p-6 bg-white rounded-2xl border border-[#E2E8F0] space-y-5">
                <div class="border-b border-[#E2E8F0] pb-3">
                    <h3 class="font-jakarta font-bold text-base text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#0F4C3A] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <span>Identitas & Informasi Kontak Resmi</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Data ini ditampilkan pada footer website dan lembar surat resmi pelayanan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Desa <span class="text-rose-500">*</span></label>
                        <input type="text" name="village_name" value="{{ old('village_name', $settings['village_name']) }}" required class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kecamatan & Kabupaten</label>
                        <input type="text" name="village_district" value="{{ old('village_district', $settings['village_district']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Lengkap Kantor Desa</label>
                    <input type="text" name="village_address" value="{{ old('village_address', $settings['village_address']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor Telepon / WhatsApp Desa</label>
                        <input type="text" name="village_phone" value="{{ old('village_phone', $settings['village_phone']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Resmi Desa</label>
                        <input type="email" name="village_email" value="{{ old('village_email', $settings['village_email']) }}" class="w-full rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] text-xs p-3 bg-white shadow-xs">
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-[#E2E8F0] flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-jakarta font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>

        <form id="delete-logo-form" action="{{ route('admin.settings.delete-logo') }}" method="POST" class="hidden" onsubmit="return confirm('Hapus logo desa?')">
            @csrf
            @method('DELETE')
        </form>

        <form id="delete-hero-form" action="{{ route('admin.settings.delete-hero') }}" method="POST" class="hidden" onsubmit="return confirm('Hapus gambar background hero kustom?')">
            @csrf
            @method('DELETE')
        </form>

        <form id="delete-head-photo-form" action="{{ route('admin.settings.delete-head-photo') }}" method="POST" class="hidden" onsubmit="return confirm('Hapus foto Kepala Desa?')">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'link'],
            ['clean']
        ];

        const quill = new Quill('#welcome-quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            },
            placeholder: 'Tuliskan kata sambutan Kepala Desa di sini...'
        });

        const hiddenInput = document.getElementById('welcome_content_input');
        const form = hiddenInput.closest('form');

        if (form) {
            form.addEventListener('submit', function() {
                hiddenInput.value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
