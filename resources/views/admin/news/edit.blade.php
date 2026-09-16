@extends('layouts.admin')

@section('title', 'Edit Berita')

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
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            border-color: #E2E8F0;
            background-color: #F8FAFC;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
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
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.news.index') }}"
                class="w-9 h-9 rounded-lg bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-2xs shrink-0"
                title="Kembali" aria-label="Kembali">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-jakarta text-xl sm:text-2xl font-bold text-[#0F172A]">Edit Berita</h1>
        </div>

        <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-xs p-5 sm:p-7" x-data="{
                    categoryDropdownOpen: false,
                    selectedCategory: '{{ old('category', $news->category) }}',
                    categoryModalOpen: false,
                    newCategoryName: '',
                    isSubmittingCategory: false,
                    categoriesList: [
                        @foreach($categories as $cat)
                            { id: {{ $cat->id }}, name: '{{ addslashes($cat->name) }}' },
                        @endforeach
                    ],
                    selectCategory(name) {
                        this.selectedCategory = name;
                        this.categoryDropdownOpen = false;
                    },
                    async submitCategory() {
                        if (!this.newCategoryName.trim()) return;
                        this.isSubmittingCategory = true;
                        try {
                            const res = await fetch('{{ route('admin.news-categories.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ name: this.newCategoryName })
                            });
                            const data = await res.json();
                            if (data.success && data.category) {
                                this.categoriesList.push({ id: data.category.id, name: data.category.name });
                                this.selectedCategory = data.category.name;
                                this.newCategoryName = '';
                                this.categoryModalOpen = false;
                                this.categoryDropdownOpen = false;
                            } else {
                                alert(data.message || 'Gagal menambahkan kategori');
                            }
                        } catch (e) {
                            alert('Terjadi kesalahan saat menambahkan kategori.');
                        } finally {
                            this.isSubmittingCategory = false;
                        }
                    }
                }">
            <form id="news-form" action="{{ route('admin.news.update', $news) }}" method="POST"
                enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" id="news-status-input" value="{{ old('status', $news->status) }}">

                <div>
                    <label for="title" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Judul Berita <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                        class="w-full px-3.5 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900 @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Dropdown Kategori (Navbar Dropdown Style) -->
                    <div class="relative" @click.away="categoryDropdownOpen = false">
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Kategori <span class="text-rose-500">*</span>
                        </label>

                        <!-- Trigger Button -->
                        <button type="button" @click="categoryDropdownOpen = !categoryDropdownOpen"
                            class="flex items-center justify-between w-full px-3.5 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900 cursor-pointer text-left transition">
                            <span x-text="selectedCategory ? selectedCategory : '-- Pilih Kategori --'"
                                :class="selectedCategory ? 'text-slate-900 font-medium' : 'text-slate-400'"></span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-150 shrink-0"
                                :class="categoryDropdownOpen ? 'rotate-180 text-[#0F4C3A]' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <input type="hidden" name="category" :value="selectedCategory" required>

                        <!-- Dropdown Menu Box -->
                        <div x-show="categoryDropdownOpen" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-98 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-98 -translate-y-1"
                            class="absolute left-0 mt-1.5 w-full rounded-lg bg-white border border-slate-200 text-[#20332A] p-0 z-50 overflow-hidden shadow-xl"
                            style="display: none;">

                            <div class="max-h-52 overflow-y-auto custom-scrollbar">
                                <template x-for="cat in categoriesList" :key="cat.id || cat.name">
                                    <button type="button" @click="selectCategory(cat.name)"
                                        class="flex items-center justify-between w-full px-4 py-2.5 text-xs font-semibold text-left transition-colors duration-150 cursor-pointer"
                                        :class="selectedCategory === cat.name ? 'bg-black/[0.04] text-[#0F4C3A] font-bold hover:bg-black/[0.06]' : 'text-[#20332A] hover:bg-black/[0.05] active:bg-black/[0.08] hover:text-[#0A3D29]'">
                                        <span x-text="cat.name"></span>
                                        <template x-if="selectedCategory === cat.name">
                                            <svg class="w-4 h-4 text-[#0F4C3A] shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </template>
                                    </button>
                                </template>
                            </div>

                            <!-- Garis Tipis & Tombol Tambah Kategori -->
                            <div class="border-t border-slate-200/80">
                                <button type="button" @click="categoryDropdownOpen = false; categoryModalOpen = true"
                                    class="flex items-center gap-2.5 w-full px-4 py-2.5 text-xs font-bold text-[#0F4C3A] hover:bg-black/[0.05] active:bg-black/[0.08] transition-colors duration-150 cursor-pointer text-left">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Tambah Kategori</span>
                                </button>
                            </div>
                        </div>

                        @error('category')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penulis Berita -->
                    <div>
                        <label for="author" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Penulis / Redaksi
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#0F4C3A] z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="author" id="author"
                                value="{{ old('author', $news->author ?? 'Admin Pemdes Catur') }}"
                                placeholder="mis. Admin Pemdes Catur"
                                class="w-full pl-10 pr-3.5 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900 placeholder:text-slate-400 @error('author') border-rose-500 @enderror">
                        </div>
                        @error('author')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Publish -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="published_at" class="block text-[13px] font-semibold text-[#1E293B]">
                                Tanggal Publish
                            </label>
                            <button type="button" id="btn-quick-today"
                                class="text-xs font-semibold text-[#0F4C3A] hover:text-[#072C21] hover:underline cursor-pointer inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Set Hari Ini</span>
                            </button>
                        </div>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#0F4C3A] z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="text" name="published_at" id="published_at"
                                value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : '') }}"
                                placeholder="Pilih tanggal..."
                                class="w-full pl-10 pr-3.5 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900 cursor-pointer font-medium placeholder:text-slate-400">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Isi Berita Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div id="quill-editor" class="bg-white">{!! old('content', $news->content) !!}</div>
                    <input type="hidden" name="content" id="content_input">
                    @error('content')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#1E293B] mb-2">Gambar Sampul</label>
                    <x-file-picker name="image" accept="image/*"
                        current="{{ $news->image_path ? asset('storage/' . $news->image_path) : '' }}"
                        currentName="{{ basename($news->image_path ?? '') }}" />
                    @error('image')
                        <p class="text-xs text-rose-600 font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image_caption" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">Deskripsi /
                        Keterangan Gambar</label>
                    <input type="text" name="image_caption" id="image_caption"
                        value="{{ old('image_caption', $news->image_caption) }}"
                        placeholder="Tuliskan caption/keterangan gambar..."
                        class="w-full px-3.5 py-2 rounded-lg border border-[#E2E8F0] text-sm bg-white text-slate-900 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A]">
                </div>

                <div class="pt-3 flex flex-wrap items-center justify-end gap-2.5 border-t border-[#F1F5F9]">
                    <a href="{{ route('admin.news.index') }}"
                        class="px-4 py-2 rounded-lg border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>

                    <!-- Tombol Simpan sebagai Draf -->
                    <button type="submit" onclick="document.getElementById('news-status-input').value = 'draft'"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-[#0F4C3A] text-[#0F4C3A] bg-white hover:bg-emerald-50 text-xs font-semibold shadow-2xs transition cursor-pointer shrink-0 whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        <span>Simpan Draf</span>
                    </button>

                    <!-- Tombol Simpan & Publikasikan -->
                    <button type="submit" onclick="document.getElementById('news-status-input').value = 'published'"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-xs transition cursor-pointer shrink-0 whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan & Publikasikan</span>
                    </button>
                </div>
            </form>

            <!-- Modal Tambah Kategori Cepat -->
            <div x-show="categoryModalOpen" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div @click.away="categoryModalOpen = false"
                    class="bg-white rounded-xl border border-[#E2E8F0] shadow-xl max-w-md w-full p-5 sm:p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-[#F1F5F9]">
                        <h3 class="font-jakarta font-bold text-base text-[#0F172A]">Tambah Kategori Berita</h3>
                        <button type="button" @click="categoryModalOpen = false"
                            class="text-slate-400 hover:text-slate-600 transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="modal_category_name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                                Nama Kategori Baru <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" x-model="newCategoryName" id="modal_category_name"
                                placeholder="Contoh: Pengumuman Desa" @keydown.enter.prevent="submitCategory()"
                                class="w-full px-3.5 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900">
                        </div>

                        <div class="flex items-center justify-end gap-2.5 pt-2">
                            <button type="button" @click="categoryModalOpen = false"
                                class="px-4 py-2 rounded-lg border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition cursor-pointer">
                                Batal
                            </button>
                            <button type="button" @click="submitCategory()" :disabled="isSubmittingCategory"
                                class="px-4 py-2 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-xs transition cursor-pointer disabled:opacity-50">
                                <span x-show="!isSubmittingCategory">Simpan Kategori</span>
                                <span x-show="isSubmittingCategory">Menyimpan...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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

            if (window.flatpickr) {
                const fp = flatpickr('#published_at', {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "j F Y",
                    altInputClass: "w-full pl-10 pr-3.5 py-2 rounded-lg border border-[#E2E8F0] focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-sm bg-white text-slate-900 cursor-pointer font-medium placeholder:text-slate-400 transition",
                    locale: "id",
                    monthSelectorType: "static",
                    disableMobile: true,
                    onReady: function (selectedDates, dateStr, instance) {
                        if (instance.calendarContainer && !instance.calendarContainer.querySelector('.flatpickr-custom-footer')) {
                            const footer = document.createElement('div');
                            footer.className = 'flatpickr-custom-footer';
                            footer.innerHTML = `
                                <button type="button" class="flatpickr-btn-clear">
                                    Reset
                                </button>
                                <button type="button" class="flatpickr-btn-today">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Pilih Hari Ini</span>
                                </button>
                            `;

                            footer.querySelector('.flatpickr-btn-today').addEventListener('click', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                instance.setDate(new Date(), true);
                                instance.close();
                            });

                            footer.querySelector('.flatpickr-btn-clear').addEventListener('click', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                instance.clear();
                                instance.close();
                            });

                            instance.calendarContainer.appendChild(footer);
                        }
                    }
                });

                const btnQuickToday = document.getElementById('btn-quick-today');
                if (btnQuickToday && fp) {
                    btnQuickToday.addEventListener('click', function () {
                        fp.setDate(new Date(), true);
                    });
                }
            }
        });
    </script>
@endpush