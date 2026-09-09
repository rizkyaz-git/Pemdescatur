@extends('layouts.public')

@section('title', 'Tulis Laporan Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Formulir pengajuan aspirasi, keluhan fasilitas, dan pengaduan warga kepada Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali.')

@section('content')
<div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        {{-- Navigation Header --}}
        <div class="flex items-center gap-3.5">
            <a href="{{ route('warga.complaint.index') }}" 
               class="w-10 h-10 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-2xs shrink-0"
               title="Kembali ke Daftar Laporan"
               aria-label="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="font-serif text-2xl font-bold text-slate-900 tracking-tight">Tulis Laporan &amp; Aspirasi Warga</h1>
                <p class="text-xs text-slate-500 mt-0.5">Sampaikan laporan permasalahan atau masukan fasilitas untuk Desa Catur.</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
            <form action="{{ route('warga.complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="category_id" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                        Kategori Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('category_id') border-rose-500 @enderror">
                        <option value="">-- Pilih Kategori Permasalahan --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                        Judul Laporan / Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        placeholder="Contoh: Lampu Penerangan Jalan Rusak di Dusun Catur RT 02"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                        Rincian Isi Pengaduan / Keluhan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                        placeholder="Jelaskan secara rinci kronologi, lokasi spesifik, dan permasalahan yang memerlukan penanganan..."
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="attachment" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                        Lampiran Foto Bukti (Opsional)
                    </label>
                    <input type="file" name="attachment" id="attachment" accept="image/png,image/jpeg,image/jpg"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0A3D29] file:text-white hover:file:bg-[#072B1D] cursor-pointer bg-slate-50/50 p-2 rounded-lg border border-slate-300 shadow-2xs @error('attachment') border-rose-500 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Format gambar: JPG, JPEG, PNG. Maksimal 2 MB.</p>
                    @error('attachment')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('warga.complaint.index') }}" 
                       class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-6 rounded-lg transition shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span>Kirim Laporan Pengaduan</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
