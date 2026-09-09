@extends('layouts.admin')

@section('title', 'Upload Foto Galeri')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Dokumentasi Baru</span>
            </div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Upload Foto Galeri Baru</h1>
            <p class="text-xs text-[#64748B] mt-1">Pilih berkas gambar dokumentasi dan tuliskan judul kegiatan.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl border border-[#E2E8F0] transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Judul Foto Dokumentasi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                    placeholder="Contoh: Panen Raya Kopi Arabika Desa Catur 2026"
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('title') border-rose-500 @enderror">
                @error('title')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2 p-5 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
                <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">
                    File Foto (Gambar) <span class="text-rose-500">*</span>
                </label>
                <input type="file" name="image" accept="image/*" required 
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0F4C3A] hover:file:bg-emerald-100 cursor-pointer">
                <p class="text-[11px] text-slate-500 mt-1 font-medium">📐 Rekomendasi Resolusi: <strong>1280 x 720 px</strong> atau <strong>1920 x 1080 px</strong> (Rasio 16:9 Landscape). Format JPG, PNG, WEBP. Maksimal 4 MB.</p>
            </div>

            <div>
                <label for="description" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Deskripsi Singkat (Opsional)
                </label>
                <textarea name="description" id="description" rows="3" 
                    placeholder="Keterangan singkat seputar foto kegiatan..."
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>Upload Foto</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
