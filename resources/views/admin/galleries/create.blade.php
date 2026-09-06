@extends('layouts.admin')

@section('title', 'Upload Foto Galeri')

@section('content')

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Upload Foto Galeri Baru</h3>
            <p class="text-xs text-gray-500 mt-1">Pilih berkas gambar dan tulis judul dokumentasi kegiatan.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Judul Foto Dokumentasi *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="Contoh: Panen Raya Kopi Kintamani Desa Catur">
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">File Foto (Gambar) *</label>
            <input type="file" name="image" accept="image/*" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0d631b] hover:file:bg-emerald-100">
            <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>1280 x 720 px</strong> atau <strong>1920 x 1080 px</strong> (Rasio 16:9 Landscape). Format JPG, PNG, WEBP. Maksimal 4 MB.</p>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Deskripsi Singkat (Opsional)</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="Keterangan singkat seputar foto kegiatan...">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                📤 Upload Foto
            </button>
        </div>
    </form>
</div>

@endsection
