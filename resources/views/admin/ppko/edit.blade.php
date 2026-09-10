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
    </style>
@endpush

@section('content')
    <div class="space-y-6 max-w-5xl mx-auto font-sans">

        <!-- Flash Alert Message -->
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

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl text-sm shadow-xs space-y-2">
                <div class="font-bold flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Periksa kembali kelengkapan formulir:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Page: Tombol kembali di kiri gaya ikon, header sederhana hanya judul -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <a href="{{ route('admin.ppko.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
                    title="Kembali" aria-label="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">{{ $pojok->nama }}</h1>
            </div>

            <a href="{{ route('public.ppko') }}#{{ Str::slug(str_replace('Pojok ', '', $pojok->nama)) }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold border border-[#E2E8F0] transition shadow-xs shrink-0">
                <span>Lihat di Halaman Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>

        @php
            $defaultFallbackCards = [
                1 => [
                    ['url' => asset('images/cover_ppko.png'), 'desc' => 'Sesi bimbingan belajar dan ruang kreasi anak-anak Desa Catur'],
                    ['url' => asset('images/culture_pura.png'), 'desc' => 'Kegiatan keagamaan dan penguatan harmoni sosial lintas warga'],
                    ['url' => asset('images/sawah_irigasi.png'), 'desc' => 'Ruang konseling dan pendampingan kesejahteraan psikososial keluarga'],
                ],
                2 => [
                    ['url' => asset('images/remen_maos_mockup.png'), 'desc' => 'Pojok literasi ramah anak dan pojok baca Remen Maos'],
                    ['url' => asset('images/hero_landscape.png'), 'desc' => 'Permainan edukatif dan aktivitas dongeng inspiratif nusantara'],
                    ['url' => asset('images/cover_ppko.png'), 'desc' => 'Edukasi kesehatan emosional dan pembentukan karakter generasi muda'],
                ],
                3 => [
                    ['url' => asset('images/coffee_processing.png'), 'desc' => 'Pendampingan pengolahan pasca panen dan pengemasan produk kopi lokal'],
                    ['url' => asset('images/coffee_plantation.png'), 'desc' => 'Pelatihan pemasaran digital dan optimasi katalog e-commerce warga'],
                    ['url' => asset('images/sawah_irigasi.png'), 'desc' => 'Workshop manajemen keuangan mandiri bagi pelaku usaha desa'],
                ],
                4 => [
                    ['url' => asset('images/culture_pura.png'), 'desc' => 'Pelestarian situs cagar budaya dan tradisi kearifan lokal Desa Catur'],
                    ['url' => asset('images/umbul_siraman.png'), 'desc' => 'Dokumentasi seni karawitan dan ruang ekspresi kebudayaan tradisional'],
                    ['url' => asset('images/masjid_wonokusumo.png'), 'desc' => 'Wisata edukasi sejarah dan pengenalan warisan leluhur desa'],
                ],
                5 => [
                    ['url' => asset('images/sawah_irigasi.png'), 'desc' => 'Inovasi sistem irigasi cerdas dan pemetaan lahan pertanian produktif'],
                    ['url' => asset('images/coffee_plantation.png'), 'desc' => 'Pemberdayaan kelompok tani dalam pembuatan pupuk organik ramah lingkungan'],
                    ['url' => asset('images/hero_landscape.png'), 'desc' => 'Budidaya tanaman pangan berkelanjutan menuju ketahanan pangan desa'],
                ],
            ];

            $defSet = $defaultFallbackCards[$pojok->id] ?? $defaultFallbackCards[1];

            $cardPhotos = [
                1 => [
                    'title' => 'Foto 1 (Slide Utama)',
                    'badge' => 'Slide 1',
                    'hasCustom' => !empty($pojok->gambar),
                    'url' => !empty($pojok->gambar) ? asset('storage/' . $pojok->gambar) : $defSet[0]['url'],
                    'desc' => !empty($pojok->deskripsi_gambar) ? $pojok->deskripsi_gambar : $defSet[0]['desc'],
                    'hasCustomDesc' => !empty($pojok->deskripsi_gambar),
                ],
                2 => [
                    'title' => 'Foto 2 (Slide Kedua)',
                    'badge' => 'Slide 2',
                    'hasCustom' => !empty($pojok->gambar_2),
                    'url' => !empty($pojok->gambar_2) ? asset('storage/' . $pojok->gambar_2) : $defSet[1]['url'],
                    'desc' => !empty($pojok->deskripsi_gambar_2) ? $pojok->deskripsi_gambar_2 : $defSet[1]['desc'],
                    'hasCustomDesc' => !empty($pojok->deskripsi_gambar_2),
                ],
                3 => [
                    'title' => 'Foto 3 (Slide Ketiga)',
                    'badge' => 'Slide 3',
                    'hasCustom' => !empty($pojok->gambar_3),
                    'url' => !empty($pojok->gambar_3) ? asset('storage/' . $pojok->gambar_3) : $defSet[2]['url'],
                    'desc' => !empty($pojok->deskripsi_gambar_3) ? $pojok->deskripsi_gambar_3 : $defSet[2]['desc'],
                    'hasCustomDesc' => !empty($pojok->deskripsi_gambar_3),
                ],
            ];
        @endphp

        <!-- ========================================================================= -->
        <!-- 1. KELOLA 3 FOTO SLIDER & DESKRIPSI GAMBAR POJOK -->
        <!-- ========================================================================= -->
        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-[#E2E8F0]">
                <div>
                    <h2 class="font-jakarta font-bold text-lg text-slate-900 flex items-center gap-2">
                        <span>Gambar Kegiatan {{ $pojok->nama }}</span>
                    </h2>
                </div>
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($cardPhotos as $slot => $card)
                    <div
                        class="bg-[#F8FAFC] rounded-2xl p-5 border border-[#E2E8F0] flex flex-col justify-between space-y-4 hover:border-emerald-200 transition">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="font-jakarta font-bold text-xs text-slate-800 uppercase tracking-wider">{{ $card['title'] }}</span>
                                @if($card['hasCustom'] || $card['hasCustomDesc'])
                                    <span
                                        class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">Kustom</span>
                                @else
                                    <span
                                        class="text-[10px] font-semibold bg-slate-200 text-slate-600 px-2.5 py-0.5 rounded-full">Bawaan</span>
                                @endif
                            </div>

                            <!-- Image Preview Box -->
                            <div
                                class="relative aspect-[16/10] bg-slate-200 rounded-xl overflow-hidden border border-slate-300 shadow-xs mb-3 group">
                                <img id="card-preview-{{ $slot }}" src="{{ $card['url'] }}" alt="{{ $card['title'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                        </div>

                        <div class="space-y-3 pt-3 border-t border-[#E2E8F0]">
                            <form action="{{ route('admin.ppko.foto.update', $pojok) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <input type="hidden" name="slot" value="{{ $slot }}">

                                <div>
                                    <label
                                        class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Pilih
                                        Gambar</label>
                                    <input type="file" name="foto" id="foto-slot-{{ $slot }}"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0] transition"
                                        onchange="previewCardImage(this, 'card-preview-{{ $slot }}')">
                                    <p class="text-[10px] text-slate-400 mt-1">Format JPG, PNG, WEBP (Maksimal 5MB).</p>
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Deskripsi
                                        Gambar</label>
                                    <textarea name="deskripsi" rows="2"
                                        class="w-full text-xs rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] p-2.5 bg-white shadow-xs"
                                        placeholder="Tuliskan keterangan singkat aktivitas foto ini...">{{ old('deskripsi', $card['desc']) }}</textarea>
                                </div>

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-bold text-xs py-2 px-3 rounded-xl shadow-xs transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Simpan Slide {{ $slot }}</span>
                                </button>
                            </form>

                            @if($card['hasCustom'] || $card['hasCustomDesc'])
                                <form action="{{ route('admin.ppko.foto.delete', $pojok) }}" method="POST"
                                    onsubmit="return confirm('Kembalikan foto dan deskripsi slide ke-{{ $slot }} ke setelan bawaan?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="slot" value="{{ $slot }}">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-1 text-[11px] font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 py-1.5 px-2.5 rounded-xl transition cursor-pointer">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Reset Gambar</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 2. FORM TAMBAH FILE UNDUHAN BARU -->
        <!-- ========================================================================= -->
        <div class="bg-white rounded-[20px] border border-[#E2E8F0] p-6 sm:p-8 shadow-xs space-y-5">
            <div class="flex items-center gap-3">
                <div>
                    <h3 class="font-jakarta font-bold text-base text-slate-900">Tambah Modul Materi / File Unduhan</h3>
                </div>
            </div>

            <form action="{{ route('admin.ppko.file.store', $pojok) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4 pt-2">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama File / Judul Dokumen <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul dokumen..."
                            class="w-full text-xs rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] p-3 bg-white shadow-xs"
                            required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Pilih Dokumen File <span class="text-rose-500">*</span>
                        </label>
                        <input type="file" name="file" id="dokumen-file-input" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-2 rounded-xl border border-[#E2E8F0] shadow-xs"
                            onchange="validateDocumentFile(this)"
                            required>
                        <p class="text-[11px] text-slate-400 mt-1">Format PDF, DOCX, PPTX, XLSX, ZIP (Maksimal 50MB).</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi / Ringkasan Isi File <span class="text-slate-400 font-normal">(Sangat Disarankan)</span>
                    </label>
                    <textarea name="deskripsi" rows="2"
                        placeholder="Jelaskan secara ringkas isi materi, manfaat, atau panduan penggunaan dokumen..."
                        class="w-full text-xs rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] p-3 bg-white shadow-xs">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Unggah File</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ========================================================================= -->
        <!-- 3. DAFTAR FILE UNDUHAN YANG TERSEDIA -->
        <!-- ========================================================================= -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <div>
                    <h3 class="font-jakarta font-bold text-base text-slate-900">Daftar File Ter-upload
                        ({{ $pojok->nama }})</h3>
                </div>
                <span
                    class="px-3 py-1 bg-emerald-50 text-[#0F4C3A] border border-emerald-200/60 rounded-full text-xs font-bold">
                    {{ $pojok->kurikulums->count() }} file Tersedia
                </span>
            </div>

            @if($pojok->kurikulums->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($pojok->kurikulums as $file)
                        <div
                            class="bg-white rounded-[20px] border border-[#E2E8F0] p-5 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0F4C3A] flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-jakarta text-sm font-bold text-slate-900 leading-snug">{{ $file->judul }}
                                        </h4>
                                        <span
                                            class="text-[11px] text-slate-400 block truncate font-mono mt-0.5">{{ $file->file_name }}
                                            • {{ $file->formatted_file_size }}</span>
                                    </div>
                                </div>

                                @if($file->deskripsi)
                                    <div class="p-3 rounded-xl bg-slate-50 border border-[#E2E8F0]/70">
                                        <span
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi</span>
                                        <p class="text-xs text-slate-600 leading-relaxed">
                                            {{ $file->deskripsi }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-[#E2E8F0] flex items-center justify-between text-xs">
                                <span class="text-[11px] text-slate-400">
                                    {{ $file->created_at->translatedFormat('d M Y') }}
                                </span>
                                <div class="flex items-center gap-3">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1 text-slate-600 hover:text-slate-900 font-semibold transition">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Lihat</span>
                                    </a>
                                    <a href="{{ route('public.ppko.kurikulum.download', $file) }}"
                                        class="inline-flex items-center gap-1 text-[#0F4C3A] hover:text-[#072C21] font-bold transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Unduh</span>
                                    </a>
                                    <form action="{{ route('admin.ppko.file.destroy', $file) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-rose-500 hover:text-rose-700 font-semibold transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-[20px] border border-dashed border-[#E2E8F0] p-10 text-center">
                    <div
                        class="w-12 h-12 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="font-jakarta font-bold text-sm text-slate-800">Belum ada file</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Gunakan formulir di atas untuk mengunggah file.</p>
                </div>
            @endif
        </div>

        <!-- ========================================================================= -->
        <!-- 4. EDIT INFORMASI POJOK (NAMA & DESKRIPSI SINGKAT DENGAN QUILL) -->
        <!-- ========================================================================= -->
        <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-5">
            <div class="pb-3 border-b border-[#E2E8F0] flex items-center gap-3">
                <div>
                    <h3 class="font-jakarta font-bold text-base text-slate-900">Deskripsi Pojok</h3>
                </div>
            </div>

            <form id="form-informasi-pojok" action="{{ route('admin.ppko.update', $pojok) }}" method="POST"
                class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Pojok <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $pojok->nama) }}"
                        class="w-full text-xs rounded-xl border-[#E2E8F0] focus:border-[#0F4C3A] focus:ring-[#0F4C3A] p-3 bg-white shadow-xs"
                        required>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi <span class="text-rose-500">*</span>
                    </label>
                    <div id="deskripsi-quill-editor" class="bg-white">
                        {!! old('deskripsi_singkat', $pojok->deskripsi_singkat) !!}
                    </div>
                    <input type="hidden" name="deskripsi_singkat" id="deskripsi_input"
                        value="{{ old('deskripsi_singkat', $pojok->deskripsi_singkat) }}">
                </div>

                <div class="flex justify-end pt-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Perubahan</span>
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
                    reader.onload = function (e) {
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
                    const file = input.files[0];
                    const maxBytes = 5 * 1024 * 1024; // 5MB
                    if (file.size > maxBytes) {
                        const sizeMb = (file.size / (1024 * 1024)).toFixed(1);
                        alert('Ukuran gambar melebihi batas 5MB (' + sizeMb + 'MB). Harap pilih gambar yang lebih kecil atau kompres gambar terlebih dahulu.');
                        input.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById(previewId);
                        if (preview) {
                            preview.src = e.target.result;
                        }
                    }
                    reader.readAsDataURL(file);
                }
            }

            function validateDocumentFile(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const maxBytes = 50 * 1024 * 1024; // 50MB
                    if (file.size > maxBytes) {
                        const sizeMb = (file.size / (1024 * 1024)).toFixed(1);
                        alert('Ukuran dokumen melebihi batas 50MB (' + sizeMb + 'MB). Harap pilih file yang lebih kecil atau kompres file terlebih dahulu.');
                        input.value = '';
                        return;
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const toolbarOptions = [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
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
                    form.addEventListener('submit', function () {
                        const text = quill.getText().trim();
                        document.getElementById('deskripsi_input').value = text.length === 0 ? '' : quill.root.innerHTML;
                    });
                }
            });
        </script>
    @endpush
@endsection