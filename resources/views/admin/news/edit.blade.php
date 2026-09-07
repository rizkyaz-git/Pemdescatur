@extends('layouts.admin')

@section('title', 'Edit Berita')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor Styling & Tailwind Reset Fixes */
    .ql-editor {
        min-height: 320px;
        font-size: 15px;
        line-height: 1.7;
    }
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-color: #d1d5db;
        background-color: #f9fafb;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-color: #d1d5db;
        font-family: inherit;
    }
    .ql-toolbar button svg,
    .ql-toolbar .ql-picker-label svg {
        width: 16px !important;
        height: 16px !important;
        display: inline-block !important;
        float: none !important;
    }
    .ql-toolbar button {
        width: 28px !important;
        height: 28px !important;
        padding: 3px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        float: left !important;
    }
    .ql-snow .ql-stroke {
        stroke: #374151 !important;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-width: 2;
        fill: none !important;
    }
    .ql-snow .ql-fill {
        fill: #374151 !important;
    }
    .ql-snow .ql-picker {
        color: #374151 !important;
        float: left !important;
    }
</style>
@endpush

@section('content')

<div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Berita / Pengumuman</h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui judul, isi, atau gambar sampul berita.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form id="news-form" action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
            <div id="quill-editor" class="bg-white">{!! old('content', $news->content) !!}</div>
            <input type="hidden" name="content" id="content_input">
            @error('content')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-4 p-4 bg-gray-50/80 rounded-xl border border-gray-200">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Gambar Sampul</label>
                @if($news->image_path)
                    <div class="flex items-center gap-4 p-3 bg-white border border-gray-200 rounded-lg">
                        <img src="{{ asset('storage/' . $news->image_path) }}" class="w-20 h-20 object-cover rounded-md">
                        <p class="text-xs text-gray-500">Upload foto baru di bawah jika ingin mengganti gambar ini.</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0d631b] hover:file:bg-emerald-100">
                <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>1200 x 630 px</strong> (Rasio 16:9 Landscape Banner). Format JPG, PNG, WEBP. Maksimal 3 MB.</p>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-gray-700">Deskripsi / Keterangan Gambar (Caption)</label>
                <input type="text" name="image_caption" value="{{ old('image_caption', $news->image_caption) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-xs sm:text-sm p-2.5 bg-white" placeholder="Contoh: Suasana gotong royong warga Desa Catur dalam panen raya padi organik (Foto: Dok. Pemdes Catur)">
                <p class="text-[11px] text-gray-500">Keterangan ini akan ditampilkan berukuran kecil di bawah gambar berita.</p>
            </div>
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
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            ['blockquote', 'link', 'image'],
            ['clean']
        ];

        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions },
            placeholder: 'Tuliskan isi berita lengkap di sini...'
        });

        const form = document.getElementById('news-form');
        form.addEventListener('submit', function() {
            const text = quill.getText().trim();
            // If empty, set empty string so Laravel validation catches it
            document.getElementById('content_input').value = text.length === 0 ? '' : quill.root.innerHTML;
        });
    });
</script>
@endpush
