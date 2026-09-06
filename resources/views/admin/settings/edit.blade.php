@extends('layouts.admin')

@section('title', 'Pengaturan Website & Logo')

@section('content')

<div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4">
        <h3 class="font-serif font-bold text-xl text-gray-900">Pengaturan Website, Logo Desa & Perpustakaan (FR-16, FR-19)</h3>
        <p class="text-xs text-gray-500 mt-1">Kelola logo resmi desa, URL tautan Perpustakaan Daerah, dan informasi kontak umum.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Block 1: Logo Desa (FR-19) -->
        <div class="p-6 bg-emerald-50/50 rounded-xl border border-emerald-200 space-y-4">
            <h4 class="font-serif font-bold text-base text-[#0d631b] border-b border-emerald-200 pb-2">
                🏛️ Logo Resmi Desa Catur (FR-19)
            </h4>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="w-24 h-24 bg-white border-2 border-emerald-300 rounded-xl p-2 flex items-center justify-center shadow-xs overflow-hidden">
                    @if(!empty($settings['village_logo_path']))
                        <img src="{{ asset('storage/' . $settings['village_logo_path']) }}" class="max-w-full max-h-full object-contain">
                    @else
                        <span class="text-gray-400 text-xs text-center">Belum ada logo</span>
                    @endif
                </div>

                <div class="flex-1 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Upload / Ganti Logo Desa</label>
                    <input type="file" name="village_logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0d631b] file:text-white hover:file:bg-emerald-800">
                    <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Ukuran: <strong>512 x 512 px</strong> (Rasio 1:1 Persegi, PNG/SVG Transparan). Maks 2 MB.</p>
                </div>
            </div>

            @if(!empty($settings['village_logo_path']))
                <div class="pt-2">
                    <button type="submit" form="delete-logo-form" class="text-xs text-red-600 hover:underline font-bold">
                        🗑️ Hapus Logo Saat Ini
                    </button>
                </div>
            @endif
        </div>

        <!-- Block 1B: Background Hero Section -->
        <div class="p-6 bg-slate-50/80 rounded-xl border border-slate-200 space-y-4">
            <h4 class="font-serif font-bold text-base text-gray-900 border-b border-slate-200 pb-2 flex items-center justify-between">
                <span>🌄 Gambar Background Hero Section Utama</span>
                <span class="text-xs font-normal text-gray-500">Halaman Utama (Landing Page)</span>
            </h4>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="w-44 h-24 bg-slate-200 border border-slate-300 rounded-xl overflow-hidden shadow-xs shrink-0 flex items-center justify-center">
                    @if(!empty($settings['hero_image_path']))
                        <img src="{{ asset('storage/' . $settings['hero_image_path']) }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/hero_landscape.png') }}" class="w-full h-full object-cover opacity-80" title="Background Bawaan">
                    @endif
                </div>

                <div class="flex-1 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Upload / Ganti Gambar Landscape Hero</label>
                    <input type="file" name="hero_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0A3D29] file:text-white hover:file:bg-[#145C3B]">
                    <p class="text-[11px] text-slate-700 font-medium">📐 Rekomendasi Resolusi: <strong>1920 x 1080 px</strong> (Rasio 16:9 Landscape - Full HD). Format JPG/PNG/WEBP. Maks 5 MB.</p>
                </div>
            </div>

            @if(!empty($settings['hero_image_path']))
                <div class="pt-2">
                    <button type="submit" form="delete-hero-form" class="text-xs text-red-600 hover:underline font-bold">
                        🗑️ Reset / Hapus Gambar Hero Kustom (Kembali ke Bawaan)
                    </button>
                </div>
            @endif
        </div>

        <!-- Block 1C: Sambutan & Foto Kepala Desa -->
        <div class="p-6 bg-emerald-50/70 rounded-xl border border-emerald-200 space-y-4">
            <h4 class="font-serif font-bold text-base text-[#0d631b] border-b border-emerald-200 pb-2 flex items-center justify-between">
                <span>👤 Sambutan & Foto Kepala Desa</span>
                <span class="text-xs font-normal text-emerald-800">Ditampilkan di Halaman Utama</span>
            </h4>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="w-32 h-36 bg-white border-2 border-emerald-300 rounded-xl overflow-hidden shadow-xs shrink-0 flex items-center justify-center relative">
                    @if(!empty($settings['head_photo_path']))
                        <img src="{{ asset('storage/' . $settings['head_photo_path']) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-[10px] text-gray-400 mt-1">Belum ada foto</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1 space-y-3 w-full">
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700">Upload / Ganti Foto Kepala Desa</label>
                        <input type="file" name="head_photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0d631b] file:text-white hover:file:bg-emerald-800">
                        <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>600 x 800 px</strong> (Rasio 3:4 Portrait). Format JPG/PNG/WEBP. Maks 5 MB.</p>
                    </div>

                    @if(!empty($settings['head_photo_path']))
                        <div class="pt-1">
                            <button type="submit" form="delete-head-photo-form" class="text-xs text-red-600 hover:underline font-bold">
                                🗑️ Hapus Foto Kepala Desa Saat Ini
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700">Nama Kepala Desa</label>
                    <input type="text" name="head_name" value="{{ old('head_name', $settings['head_name']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-xs p-2.5" placeholder="Dra. NUNIK S RAHAYU, M.Pd">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700">Jabatan / Gelar</label>
                    <input type="text" name="head_title" value="{{ old('head_title', $settings['head_title']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-xs p-2.5" placeholder="Kepala Desa Catur">
                </div>
            </div>

            <div class="space-y-1 pt-2">
                <label class="block text-xs font-semibold text-gray-700">Judul Sambutan</label>
                <input type="text" name="welcome_title" value="{{ old('welcome_title', $settings['welcome_title']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-xs p-2.5" placeholder="Selamat Datang di Website Resmi Desa Catur">
            </div>

            <div class="space-y-1.5 pt-2">
                <label class="block text-xs font-semibold text-gray-700">Isi Teks Sambutan Kepala Desa (Rich Text Editor)</label>
                <!-- Quill CSS -->
                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                <style>
                    .ql-editor { min-height: 200px; font-size: 0.875rem; line-height: 1.6; }
                    .ql-toolbar.ql-snow { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; background-color: #f8fafc; border-color: #d1d5db; }
                    .ql-container.ql-snow { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-color: #d1d5db; }
                    .ql-toolbar button svg,
                    .ql-toolbar .ql-picker-label svg { width: 16px !important; height: 16px !important; display: inline-block !important; float: none !important; }
                    .ql-toolbar button { width: 28px !important; height: 28px !important; padding: 3px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; float: left !important; }
                    .ql-snow .ql-stroke { stroke: #374151 !important; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2; fill: none !important; }
                    .ql-snow .ql-fill { fill: #374151 !important; }
                    .ql-snow .ql-picker { color: #374151 !important; float: left !important; }
                </style>

                <div class="bg-white rounded-lg overflow-hidden shadow-xs">
                    <div id="welcome-quill-editor">{!! old('welcome_content', $settings['welcome_content']) !!}</div>
                </div>
                <input type="hidden" name="welcome_content" id="welcome_content_input" value="{{ old('welcome_content', $settings['welcome_content']) }}">
                <p class="text-[11px] text-gray-500 mt-1">Gunakan toolbar Rich Text Editor untuk memformat teks (tebal, miring, daftar poin/angka, paragraf, rata kiri/tengah/kanan, dll). Format akan tampil langsung di Halaman Utama.</p>
            </div>
        </div>

        <!-- Block 2: Tautan & Gambar Mockup Perpustakaan Digital (FR-16) -->
        <div class="p-6 bg-amber-50/60 rounded-xl border border-amber-200 space-y-5">
            <h4 class="font-serif font-bold text-base text-[#855300] border-b border-amber-200 pb-2">
                📚 Perpustakaan Digital "Remen Maos" (FR-16)
            </h4>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">URL Website Perpustakaan Daerah *</label>
                <input type="url" name="library_url" value="{{ old('library_url', $settings['library_url']) }}" required class="w-full rounded-lg border-gray-300 shadow-xs font-mono text-sm p-3" placeholder="https://perpustakaan.boyolali.go.id">
                <p class="text-[11px] text-amber-800">Tautan eksternal ini akan dibuka di tab baru saat pengunjung menekan tombol Perpustakaan Daerah.</p>
            </div>

        </div>

        <!-- Block 3: Identitas Umum & Kontak Desa -->
        <div class="space-y-6">
            <h4 class="font-serif font-bold text-base text-gray-900 border-b border-gray-200 pb-2">
                📍 Identitas & Informasi Kontak
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">Nama Desa *</label>
                    <input type="text" name="village_name" value="{{ old('village_name', $settings['village_name']) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">Kecamatan & Kabupaten</label>
                    <input type="text" name="village_district" value="{{ old('village_district', $settings['village_district']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap Kantor Desa</label>
                <input type="text" name="village_address" value="{{ old('village_address', $settings['village_address']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">Nomor Telepon / WA Desa</label>
                    <input type="text" name="village_phone" value="{{ old('village_phone', $settings['village_phone']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">Email Resmi Desa</label>
                    <input type="email" name="village_email" value="{{ old('village_email', $settings['village_email']) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end">
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Pengaturan
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

        form.addEventListener('submit', function() {
            hiddenInput.value = quill.root.innerHTML;
        });
    });
</script>
@endpush

@endsection
