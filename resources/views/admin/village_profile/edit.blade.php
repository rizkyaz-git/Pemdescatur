@extends('layouts.admin')

@section('title', 'Kelola Profil Desa')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor Styling & Tailwind Reset Fixes */
    .ql-editor {
        min-height: 280px;
        font-size: 14px;
        line-height: 1.6;
    }
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        border-color: #e5e7eb;
        background-color: #f9fafb;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-color: #e5e7eb;
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

<div class="max-w-5xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4">
        <h3 class="font-serif font-bold text-xl text-gray-900">Kelola Profil, Narasi Sejarah, & Foto Desa Catur</h3>
        <p class="text-xs text-gray-500 mt-1">Gunakan editor di bawah ini untuk memperbarui foto sampul dan teks narasi sejarah desa. Teks narasi sejarah akan langsung tampil di kolom tengah halaman publik profil desa.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-semibold flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.village-profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- 1. Foto Utama Profil Desa (Upload Image) -->
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-800">Foto Utama Profil / Lanskap Desa</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-full sm:w-64 h-36 rounded-xl overflow-hidden bg-gray-100 border border-gray-300 relative shadow-xs shrink-0">
                    <img id="image-preview" 
                         src="{{ $profile->image ? asset('storage/' . $profile->image) : asset('images/hero_landscape.png') }}" 
                         alt="Preview Foto Profil" 
                         class="w-full h-full object-cover">
                </div>
                <div class="space-y-2 flex-1">
                    <input type="file" 
                           name="image" 
                           id="image-input" 
                           accept="image/png,image/jpeg,image/jpg,image/webp" 
                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0d631b] file:text-white hover:file:bg-emerald-800 cursor-pointer">
                    <p class="text-xs text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>1920 x 1080 px</strong> atau <strong>1280 x 720 px</strong> (Rasio 16:9 Landscape). Format JPG, PNG, WEBP. Maksimal 5 MB.</p>
                </div>
            </div>
            @error('image')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 2. Sejarah & Teks Tengah Profil Desa (Quill Rich Text Editor) -->
        <div class="space-y-2">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <label class="block text-sm font-bold text-gray-800">Teks Narasi & Sejarah Desa (Kolom Tengah Profil)</label>
                <span class="text-xs text-emerald-700 font-medium">Dukungan format lengkap: Heading, Bold, Paragraf, Kutipan, dsb.</span>
            </div>
            <div id="history-quill-editor" class="bg-white">{!! old('history', $profile->history) !!}</div>
            <input type="hidden" name="history" id="history_input" value="{{ old('history', $profile->history) }}">
            <p class="text-xs text-gray-500">Seluruh teks yang Anda tulis di sini akan ditampilkan secara dinamis di kolom tengah halaman profil desa.</p>
            @error('history')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end">
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition cursor-pointer flex items-center gap-2">
                <span>💾 Simpan Perubahan Profil</span>
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fullToolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'link'],
            ['clean']
        ];

        // History / Story Quill Editor
        const historyQuill = new Quill('#history-quill-editor', {
            theme: 'snow',
            modules: { toolbar: fullToolbarOptions },
            placeholder: 'Tuliskan narasi dan sejarah lengkap Desa Catur di sini...'
        });

        // Sync Quill HTML to hidden input before form submit
        const profileForm = document.getElementById('profile-form');
        profileForm.addEventListener('submit', function() {
            document.getElementById('history_input').value = historyQuill.root.innerHTML;
        });

        // Image Live Preview Script
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    imagePreview.src = evt.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
