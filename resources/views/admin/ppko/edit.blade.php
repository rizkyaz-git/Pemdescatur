@extends('layouts.admin')

@section('title', 'Kelola ' . $pojok->nama . ' – Admin PPKO')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor Styling & Tailwind Reset Fixes */
    .ql-editor {
        min-height: 180px;
        font-size: 14px;
        line-height: 1.6;
        font-family: inherit;
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
</style>
@endpush

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- Flash Alert Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm shadow-xs space-y-1">
            <div class="font-bold">Periksa kembali input formulir:</div>
            <ul class="list-disc list-inside text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header & Back Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <a href="{{ route('admin.ppko.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Menu Admin PPKO</span>
            </a>
            <h3 class="font-serif font-bold text-xl text-gray-900">{{ $pojok->nama }}</h3>
            <p class="text-xs text-gray-500 mt-0.5">Kelola foto sampul pojok dan file unduhan (modul materi & panduan) untuk pilar ini.</p>
        </div>

        <a href="{{ route('public.ppko') }}#{{ Str::slug(str_replace('Pojok ', '', $pojok->nama)) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
            <span>Lihat di Halaman Publik</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    @php
        $isHarmoni = ($pojok->id == 1);
        $defaultImages = [
            1 => asset('images/cover_ppko.png'),
            2 => asset('images/remen_maos_mockup.png'),
            3 => asset('images/coffee_processing.png'),
            4 => asset('images/culture_pura.png'),
            5 => asset('images/sawah_irigasi.png'),
        ];
        $hasCustomPhoto = !empty($pojok->gambar);
        $currentPhoto = $hasCustomPhoto ? asset('storage/' . $pojok->gambar) : ($defaultImages[$pojok->id] ?? asset('images/cover_ppko.png'));

        // For Pojok Harmoni 3-Card Stack Showcase
        $cardPhotos = [
            1 => [
                'title' => 'Kartu 1 (Depan / Teratas)',
                'badge' => 'Front Card',
                'hasCustom' => !empty($pojok->gambar),
                'url' => !empty($pojok->gambar) ? asset('storage/' . $pojok->gambar) : asset('images/cover_ppko.png'),
                'desc' => 'Tampil paling depan pada tumpukan kartu bergaya shuffle Pojok Harmoni.',
            ],
            2 => [
                'title' => 'Kartu 2 (Tengah)',
                'badge' => 'Middle Card',
                'hasCustom' => !empty($pojok->gambar_2),
                'url' => !empty($pojok->gambar_2) ? asset('storage/' . $pojok->gambar_2) : asset('images/culture_pura.png'),
                'desc' => 'Tampil di lapisan kedua pada tumpukan kartu bergaya shuffle Pojok Harmoni.',
            ],
            3 => [
                'title' => 'Kartu 3 (Belakang / Terbawah)',
                'badge' => 'Back Card',
                'hasCustom' => !empty($pojok->gambar_3),
                'url' => !empty($pojok->gambar_3) ? asset('storage/' . $pojok->gambar_3) : asset('images/sawah_irigasi.png'),
                'desc' => 'Tampil di lapisan belakang pada tumpukan kartu bergaya shuffle Pojok Harmoni.',
            ],
        ];
    @endphp

    <!-- ========================================================================= -->
    <!-- 1. KELOLA FOTO POJOK -->
    <!-- ========================================================================= -->
    @if($isHarmoni)
        <!-- KHUSUS POJOK HARMONI: 3 FOTO KARTU TUMPUK (CARD STACK) -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-gray-100">
                <div>
                    <h4 class="font-serif font-bold text-base text-gray-900 flex items-center gap-2">
                        <span>🃏</span>
                        <span>3 Foto Kartu Tumpuk (Card Stack) {{ $pojok->nama }}</span>
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Pojok Harmoni menampilkan galeri 3 kartu foto bertumpuk yang berotasi otomatis. Anda dapat memasukkan 3 foto berbeda untuk masing-masing kartu.</p>
                </div>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                    ✨ Fitur Kartu Tumpuk Aktif
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($cardPhotos as $slot => $card)
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-xs text-slate-800 uppercase tracking-wider">{{ $card['title'] }}</span>
                                @if($card['hasCustom'])
                                    <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">Kustom</span>
                                @else
                                    <span class="text-[10px] font-medium bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full">Bawaan</span>
                                @endif
                            </div>
                            <p class="text-[11px] text-gray-500 mb-3">{{ $card['desc'] }}</p>
                            
                            <div class="relative aspect-square bg-slate-200 rounded-xl overflow-hidden border border-slate-300 shadow-xs">
                                <img id="card-preview-{{ $slot }}" 
                                     src="{{ $card['url'] }}" 
                                     alt="{{ $card['title'] }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="space-y-3 pt-2 border-t border-slate-200">
                            <form action="{{ route('admin.ppko.foto.update', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                @csrf
                                <input type="hidden" name="slot" value="{{ $slot }}">
                                <label class="block text-[11px] font-semibold text-slate-700">Pilih Foto Kartu {{ $slot }}</label>
                                <input type="file" 
                                       name="foto" 
                                       id="foto-slot-{{ $slot }}"
                                       accept="image/jpeg,image/png,image/webp" 
                                       class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2.5 file:rounded file:border-0 file:text-[11px] file:font-semibold file:bg-[#0d631b] file:text-white hover:file:bg-emerald-800 cursor-pointer bg-white p-1.5 rounded-md border border-gray-300 transition" 
                                       required
                                       onchange="previewCardImage(this, 'card-preview-{{ $slot }}')">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs py-2 px-3 rounded-lg shadow-xs transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    <span>Simpan Kartu {{ $slot }}</span>
                                </button>
                            </form>

                            @if($card['hasCustom'])
                                <form action="{{ route('admin.ppko.foto.delete', $pojok) }}" method="POST" onsubmit="return confirm('Kembalikan foto kartu ke-{{ $slot }} ke foto bawaan?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="slot" value="{{ $slot }}">
                                    <button type="submit" class="w-full inline-flex items-center justify-center gap-1 text-[11px] font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 py-1.5 px-2.5 rounded-md transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Reset Kartu {{ $slot }}</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- UNTUK POJOK LAINNYA: 1 FOTO SAMPUL STANDAR -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-gray-100">
                <div>
                    <h4 class="font-serif font-bold text-base text-gray-900 flex items-center gap-2">
                        <span>📷</span>
                        <span>Foto Sampul {{ $pojok->nama }}</span>
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Foto sampul akan ditampilkan di section katalog pojok pada halaman profil PPKO.</p>
                </div>
                <div>
                    @if($hasCustomPhoto)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            ✓ Foto Kustom Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            Menggunakan Foto Bawaan
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                <!-- Image Preview Box -->
                <div class="md:col-span-6 space-y-2">
                    <span class="block text-xs font-bold text-gray-600 uppercase tracking-wider">Pratinjau Foto Sampul Saat Ini</span>
                    <div class="relative aspect-[16/10] bg-slate-100 rounded-xl overflow-hidden border border-gray-200 shadow-inner">
                        <img id="cover-preview" 
                             src="{{ $currentPhoto }}" 
                             alt="{{ $pojok->nama }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <p class="text-[11px] text-gray-400">Rasio tampilan optimal: 16:10 atau 16:9 (Landscape).</p>
                </div>

                <!-- Upload & Actions Form -->
                <div class="md:col-span-6 space-y-4">
                    <form action="{{ route('admin.ppko.foto.update', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Pilih Foto Baru untuk Foto Sampul
                            </label>
                            <input type="file" 
                                   name="foto" 
                                   id="foto-input"
                                   accept="image/jpeg,image/png,image/webp" 
                                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0d631b] file:text-white hover:file:bg-emerald-800 cursor-pointer bg-gray-50 p-2.5 rounded-lg border border-gray-300 transition" 
                                   required
                                   onchange="previewCoverImage(this)">
                            <p class="text-[11px] text-gray-400 mt-1">Mendukung format JPG, PNG, WEBP (Maksimal 5MB).</p>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit" class="inline-flex items-center gap-1.5 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-lg shadow-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Simpan Foto Sampul Baru</span>
                            </button>
                        </div>
                    </form>

                    @if($hasCustomPhoto)
                        <div class="pt-3 border-t border-gray-100">
                            <form action="{{ route('admin.ppko.foto.delete', $pojok) }}" method="POST" onsubmit="return confirm('Kembalikan foto sampul ke foto bawaan sistem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3.5 py-2 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Reset ke Foto Bawaan</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 2. FORM TAMBAH FILE UNDUHAN BARU -->
    <!-- ========================================================================= -->
    <div class="bg-emerald-50/50 rounded-xl border border-emerald-200/80 p-6 sm:p-8 shadow-xs space-y-4">
        <div class="flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-lg bg-[#0d631b] text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                📄
            </span>
            <div>
                <h4 class="font-serif font-bold text-base text-gray-900">Tambah File yang Dapat Diunduh</h4>
                <p class="text-xs text-gray-500">Tambahkan modul pelatihan, materi bacaan, silabus, atau panduan lengkap dengan nama dan deskripsinya.</p>
            </div>
        </div>

        <form action="{{ route('admin.ppko.file.store', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-2">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Nama File / Judul Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           value="{{ old('judul') }}" 
                           placeholder="Contoh: Modul Psychological First Aid (PFA)" 
                           class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 bg-white shadow-2xs" 
                           required>
                    <p class="text-[11px] text-gray-400 mt-1">Nama file yang akan tampil jelas pada tombol unduhan di halaman publik.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Pilih Dokumen File <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                           name="file" 
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar" 
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#0d631b] file:text-white hover:file:bg-emerald-800 cursor-pointer bg-white p-2 rounded-lg border border-gray-300 shadow-2xs" 
                           required>
                    <p class="text-[11px] text-gray-400 mt-1">Format: PDF, DOCX, PPTX, XLSX, ZIP (Maksimal 50MB).</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Deskripsi / Keterangan File <span class="text-gray-400 font-normal">(Sangat Disarankan)</span>
                </label>
                <textarea name="deskripsi" 
                          rows="2" 
                          placeholder="Jelaskan secara ringkas isi materi, manfaat, atau panduan penggunaan dokumen ini bagi masyarakat..." 
                          class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 bg-white shadow-2xs">{{ old('deskripsi') }}</textarea>
                <p class="text-[11px] text-gray-400 mt-1">Deskripsi ini akan dimunculkan langsung pada katalog pojok halaman publik.</p>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Unggah File Unduhan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. DAFTAR FILE UNDUHAN YANG TERSEDIA -->
    <!-- ========================================================================= -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-gray-200 pb-3">
            <div>
                <h4 class="font-serif font-bold text-base text-gray-900">Daftar File Unduhan Aktif ({{ $pojok->nama }})</h4>
                <p class="text-xs text-gray-500">File-file di bawah ini otomatis muncul di halaman profil publik PPKO dan dapat diunduh langsung oleh pengunjung.</p>
            </div>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">
                {{ $pojok->kurikulums->count() }} File Tersedia
            </span>
        </div>

        @if($pojok->kurikulums->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pojok->kurikulums as $file)
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between space-y-4">
                        <div class="space-y-2.5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100">
                                        📁
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="text-sm font-bold text-gray-900 leading-snug">{{ $file->judul }}</h5>
                                        <span class="text-[11px] text-gray-400 block truncate">{{ $file->file_name }} • {{ $file->formatted_file_size }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($file->deskripsi)
                                <div class="p-3 rounded-lg bg-gray-50 border border-gray-100">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Deskripsi File:</span>
                                    <p class="text-xs text-gray-700 leading-relaxed">
                                        {{ $file->deskripsi }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-[11px] text-gray-400">
                                Diunggah: {{ $file->created_at->translatedFormat('d M Y') }}
                            </span>
                            <div class="flex items-center gap-3">
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-slate-600 hover:text-slate-900 font-semibold transition">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Lihat</span>
                                </a>
                                <a href="{{ route('public.ppko.kurikulum.download', $file) }}" class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 font-bold transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    <span>Unduh</span>
                                </a>
                                <form action="{{ route('admin.ppko.file.destroy', $file) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl border border-dashed border-gray-300 p-8 text-center">
                <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-xs font-semibold text-gray-700">Belum ada file unduhan untuk {{ $pojok->nama }}.</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Gunakan formulir di atas untuk mengunggah modul materi atau panduan lengkap dengan deskripsinya.</p>
            </div>
        @endif
    </div>

    <!-- ========================================================================= -->
    <!-- 4. EDIT INFORMASI POJOK (NAMA & DESKRIPSI SINGKAT DENGAN QUILL) -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-4">
        <h4 class="font-serif font-bold text-base text-gray-900 pb-2 border-b border-gray-100 flex items-center gap-2">
            <span>📝</span>
            <span>Informasi Narasi {{ $pojok->nama }}</span>
        </h4>
        <form id="form-informasi-pojok" action="{{ route('admin.ppko.update', $pojok) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Nama Pilar Pojok <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama', $pojok->nama) }}" class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 bg-white shadow-2xs" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Deskripsi Program (Quill Rich Text Editor) <span class="text-red-500">*</span>
                </label>
                <div id="deskripsi-quill-editor" class="bg-white">{!! old('deskripsi_singkat', $pojok->deskripsi_singkat) !!}</div>
                <input type="hidden" name="deskripsi_singkat" id="deskripsi_input" value="{{ old('deskripsi_singkat', $pojok->deskripsi_singkat) }}">
                <p class="text-[11px] text-gray-400">Gunakan toolbar untuk format teks tebal, miring, garis bawah, daftar poin, perataan teks, dan tautan.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Simpan Perubahan Informasi</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
function previewCoverImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('cover-preview');
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function previewCardImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

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

    const quill = new Quill('#deskripsi-quill-editor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions },
        placeholder: 'Tuliskan narasi dan deskripsi pilar pojok pemberdayaan ini...'
    });

    const form = document.getElementById('form-informasi-pojok');
    if (form) {
        form.addEventListener('submit', function() {
            const text = quill.getText().trim();
            // Jika editor kosong, set string kosong agar validasi Laravel menangkapnya
            document.getElementById('deskripsi_input').value = text.length === 0 ? '' : quill.root.innerHTML;
        });
    }
});
</script>
@endpush
@endsection
