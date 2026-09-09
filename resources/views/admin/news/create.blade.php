@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            min-height: 320px;
            font-size: 15px;
            line-height: 1.7;
            font-family: inherit;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-color: #E2E8F0;
            background-color: #F8FAFC;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
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
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-3.5">
            <a href="{{ route('admin.news.index') }}"
                class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
                title="Kembali"
                aria-label="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Tambah Berita Baru</h1>
        </div>

        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
            <form id="news-form" action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Judul Berita <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        placeholder="Tuliskan judul berita disini..."
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="category" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="category" id="category" value="{{ old('category', 'Berita') }}" required
                            placeholder="Berita / Pengumuman / Kegiatan"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">
                    </div>

                    <div>
                        <label for="status" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Status Publikasi <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" id="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Tayang)
                            </option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                        </select>
                    </div>

                    <div>
                        <label for="published_at" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Tanggal Publish
                        </label>
                        <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">
                    </div>
                </div>

                <div>
                    <label for="excerpt" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Ringkasan Berita
                    </label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        placeholder="Tuliskan ringkasan sebanyak 1-2 kalimat untuk preview berita..."
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">{{ old('excerpt') }}</textarea>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Isi Berita Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div id="quill-editor" class="bg-white">{!! old('content') !!}</div>
                    <input type="hidden" name="content" id="content_input">
                    @error('content')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-4 p-5 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
                    <div>
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">Upload Gambar Sampul
                            (Opsional)</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0F4C3A] hover:file:bg-emerald-100 cursor-pointer">
                        <p class="text-[11px] text-slate-500 mt-1.5 font-medium">*Rekomendasi Resolusi: <strong>1200 x 630
                                px</strong> (Rasio 16:9). Format JPG, PNG, WEBP. Maksimal 3 MB.</p>
                    </div>

                    <div>
                        <label for="image_caption" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi /
                            Keterangan Gambar</label>
                        <input type="text" name="image_caption" id="image_caption" value="{{ old('image_caption') }}"
                            placeholder="Tuliskan caption/keterangan gambar..."
                            class="w-full px-4 py-2 rounded-xl border border-[#E2E8F0] text-xs sm:text-sm bg-white text-slate-900 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A]">
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                    <a href="{{ route('admin.news.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan & Publikasikan</span>
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
            const toolbarOptions = [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                ['blockquote', 'link', 'image'],
                ['clean']
            ];

            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: { toolbar: toolbarOptions },
                placeholder: 'Tuliskan isi berita lengkap di sini...'
            });

            const form = document.getElementById('news-form');
            form.addEventListener('submit', function () {
                const text = quill.getText().trim();
                document.getElementById('content_input').value = text.length === 0 ? '' : quill.root.innerHTML;
            });
        });
    </script>
@endpush