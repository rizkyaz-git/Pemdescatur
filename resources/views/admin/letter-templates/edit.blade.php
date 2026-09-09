@extends('layouts.admin')

@section('title', 'Edit Template Surat Siap Cetak')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.letter-templates.index') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Edit Template Surat</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $template->name }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.letter-templates.update', $template->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Nama Template Surat <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $template->name) }}" required
                    placeholder="Contoh: Surat Keterangan Usaha (SKU)"
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current File Info & Replace File Input -->
            <div class="space-y-3">
                <label class="block text-[13px] font-semibold text-[#1E293B]">
                    File Template Surat Siap Cetak
                </label>

                @if($template->has_file)
                    <div class="p-4 rounded-xl bg-emerald-50/60 border border-emerald-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#0F4C3A] text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                {{ $template->file_extension }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-emerald-950">{{ basename($template->file_path) }}</p>
                                <p class="text-[11px] text-emerald-700 mt-0.5">Ukuran: {{ $template->file_size_formatted }} • Tersedia untuk diunduh</p>
                            </div>
                        </div>
                        <a href="{{ $template->file_url }}" target="_blank" download
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white hover:bg-emerald-100 text-[#0F4C3A] border border-emerald-300 text-xs font-bold transition shrink-0 shadow-2xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Unduh File Sekarang</span>
                        </a>
                    </div>
                @endif

                <div>
                    <label for="file" class="block text-xs font-medium text-slate-600 mb-1">
                        {{ $template->has_file ? 'Ganti dengan File Baru (Kosongkan jika tidak ingin mengubah file)' : 'Unggah File Template (Wajib diisi jika belum ada)' }}
                    </label>
                    <input type="file" name="file" id="file"
                        accept=".doc,.docx,.pdf,.rtf,.odt"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-[#F8FAFC]/40 p-2 rounded-xl border border-[#E2E8F0] shadow-xs @error('file') border-rose-500 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Format: Word (.doc, .docx), PDF (.pdf), RTF (.rtf). Maksimal 25 MB.</p>
                    @error('file')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Persyaratan & Berkas Dibutuhkan -->
            <div>
                <label for="requirements" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Persyaratan / Berkas yang Perlu Disiapkan Warga
                </label>
                <textarea name="requirements" id="requirements" rows="3"
                    placeholder="Contoh: 1. Surat Pengantar RT/RW&#10;2. Fotokopi KTP Pemohon&#10;3. Fotokopi Kartu Keluarga (KK)"
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('requirements') border-rose-500 @enderror">{{ old('requirements', $template->requirements) }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Informasi berkas yang harus dilampirkan warga saat membawa surat cetak ke balai desa.</p>
                @error('requirements')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi / Kegunaan Surat -->
            <div>
                <label for="description" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Keterangan & Petunjuk Penggunaan
                </label>
                <textarea name="description" id="description" rows="2"
                    placeholder="Contoh: Digunakan untuk permohonan izin usaha mikro, pengajuan KUR bank, atau keperluan legalitas usaha lainnya."
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('description') border-rose-500 @enderror">{{ old('description', $template->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E2E8F0]">
                <a href="{{ route('admin.letter-templates.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-6 py-2.5 rounded-xl shadow-xs transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
