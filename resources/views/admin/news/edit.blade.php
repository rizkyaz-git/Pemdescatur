@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')

<div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Berita / Pengumuman</h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui judul, isi, atau gambar sampul berita.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Judul Berita *</label>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" required class="w-full rounded-lg border-gray-300 shadow-xs focus:border-[#0d631b] focus:ring-[#0d631b] text-sm p-3">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Kategori *</label>
                <input type="text" name="category" value="{{ old('category', $news->category) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-2.5">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Status *</label>
                <select name="status" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-2.5">
                    <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                    <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Tanggal Publish</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-2.5">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Ringkasan Singkat (Excerpt)</label>
            <textarea name="excerpt" rows="2" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">{{ old('excerpt', $news->excerpt) }}</textarea>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Konten Berita Lengkap *</label>
            <textarea name="content" rows="10" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">{{ old('content', $news->content) }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Gambar Sampul</label>
            @if($news->image_path)
                <div class="flex items-center gap-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                    <img src="{{ asset('storage/' . $news->image_path) }}" class="w-20 h-20 object-cover rounded-md">
                    <p class="text-xs text-gray-500">Upload foto baru di bawah jika ingin mengganti gambar ini.</p>
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0d631b] hover:file:bg-emerald-100">
            <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>1200 x 630 px</strong> (Rasio 16:9 Landscape Banner). Format JPG, PNG, WEBP. Maksimal 3 MB.</p>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
