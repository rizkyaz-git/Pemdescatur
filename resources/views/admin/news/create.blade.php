@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')

@section('content')

<div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Tambah Berita / Pengumuman Baru</h3>
            <p class="text-xs text-gray-500 mt-1">Isi formulir untuk menayangkan berita di portal publik desa.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Judul Berita *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 shadow-xs focus:border-[#0d631b] focus:ring-[#0d631b] text-sm p-3" placeholder="Contoh: Panen Raya Kopi Arabika Desa Catur 2026">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Kategori *</label>
                <input type="text" name="category" value="{{ old('category', 'Berita') }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-2.5" placeholder="Berita / Pengumuman / Kegiatan">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Status *</label>
                <select name="status" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-2.5">
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Tanggal Tanggal Publish</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-2.5">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Ringkasan Singkat (Excerpt)</label>
            <textarea name="excerpt" rows="2" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="Ringkasan 1-2 kalimat untuk tampilan kartu depan...">{{ old('excerpt') }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Konten Berita Lengkap *</label>
            <textarea name="content" rows="10" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="Tuliskan isi berita lengkap di sini...">{{ old('content') }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Upload Gambar Sampul (Opsional)</label>
            <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0d631b] hover:file:bg-emerald-100">
            <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>1200 x 630 px</strong> (Rasio 16:9 Landscape Banner). Format JPG, PNG, WEBP. Maksimal 3 MB.</p>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                🚀 Simpan Berita
            </button>
        </div>
    </form>
</div>

@endsection
