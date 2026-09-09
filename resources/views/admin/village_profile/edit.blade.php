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
            font-family: inherit;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            border-color: #E2E8F0;
            background-color: #F8FAFC;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #E2E8F0;
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
            stroke: #475569 !important;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 2;
            fill: none !important;
        }

        .ql-snow .ql-fill {
            fill: #475569 !important;
        }

        .ql-snow .ql-picker {
            color: #475569 !important;
            float: left !important;
        }
    </style>
@endpush

@section('content')

    <div class="max-w-5xl mx-auto space-y-6 font-sans">

        <!-- Flash Notification -->
        @if(session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center justify-between text-sm shadow-xs animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
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

        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-6">
            <div class="border-b border-[#E2E8F0] pb-5">
                <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Kelola Profil Desa</h1>
            </div>

            <form action="{{ route('admin.village-profile.update') }}" method="POST" enctype="multipart/form-data"
                id="profile-form" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- 1. Foto Utama Profil Desa (Upload Image) -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Foto Profil</label>
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-5 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
                        <div
                            class="w-full sm:w-64 h-36 rounded-xl overflow-hidden bg-slate-200 border border-slate-300 relative shadow-xs shrink-0 group">
                            <img id="image-preview"
                                src="{{ $profile->image ? asset('storage/' . $profile->image) : asset('images/hero_landscape.png') }}"
                                alt="Preview Foto Profil"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="space-y-2.5 flex-1">
                            <input type="file" name="image" id="image-input"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                            <p class="text-xs text-slate-500 leading-relaxed">
                                *Rekomendasi Resolusi: <strong class="text-slate-800">1920 x 1080 px</strong> atau <strong
                                    class="text-slate-800">1280 x 720 px</strong> (Rasio 16:9 Landscape). Format JPG, PNG,
                                WEBP. Maksimal 5 MB.
                            </p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Sejarah & Teks Tengah Profil Desa (Quill Rich Text Editor) -->
                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi</label>
                        <span class="text-xs text-[#0F4C3A] font-semibold">Masukkan Deskripsi</span>
                    </div>
                    <div id="history-quill-editor" class="bg-white">{!! old('history', $profile->history) !!}</div>
                    <input type="hidden" name="history" id="history_input" value="{{ old('history', $profile->history) }}">
                    <p class="text-xs text-slate-400">Teks akan ditampilkan pada halaman Profil Desa</p>
                    @error('history')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-5 border-t border-[#E2E8F0] flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-jakarta font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fullToolbarOptions = [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['blockquote', 'link'],
                ['clean']
            ];

            // History / Story Quill Editor
            const historyQuill = new Quill('#history-quill-editor', {
                theme: 'snow',
                modules: { toolbar: fullToolbarOptions },
                placeholder: 'Masukkan Deskripsi...'
            });

            // Sync Quill HTML to hidden input before form submit
            const profileForm = document.getElementById('profile-form');
            profileForm.addEventListener('submit', function () {
                document.getElementById('history_input').value = historyQuill.root.innerHTML;
            });

            // Image Live Preview Script
            const imageInput = document.getElementById('image-input');
            const imagePreview = document.getElementById('image-preview');
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (evt) {
                        imagePreview.src = evt.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush