@extends('layouts.admin')

@section('title', 'Edit Foto Galeri')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/60 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Edit Galeri</span>
            </div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Edit Foto Galeri</h1>
            <p class="text-xs text-[#64748B] mt-1">Perbarui judul, keterangan, atau ganti berkas gambar dokumentasi.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl border border-[#E2E8F0] transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Judul Foto Dokumentasi <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required 
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('title') border-rose-500 @enderror">
                @error('title')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-3 p-5 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
                <label class="block text-[13px] font-semibold text-[#1E293B]">Foto Saat Ini</label>
                <div class="p-2 bg-white border border-[#E2E8F0] rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-full h-48 object-cover rounded-lg">
                </div>
                <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0F4C3A] hover:file:bg-emerald-100 cursor-pointer">
                <p class="text-[11px] text-slate-500 font-medium">📐 Rekomendasi Resolusi: <strong>1280 x 720 px</strong> atau <strong>1920 x 1080 px</strong> (Rasio 16:9). Format JPG, PNG, WEBP. Maksimal 4 MB.</p>
            </div>

            <div>
                <label for="description" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Deskripsi Singkat (Opsional)
                </label>
                <textarea name="description" id="description" rows="3" 
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
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
