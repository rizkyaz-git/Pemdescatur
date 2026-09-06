@extends('layouts.public')

@section('title', 'Tulis Pengaduan Warga - Desa Catur')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl font-bold text-gray-900">✍️ Buat Laporan Pengaduan / Aspirasi</h1>
                <p class="text-xs text-gray-500 mt-1">Sampaikan laporan permasalahan atau masukan untuk Desa Catur.</p>
            </div>
            <a href="{{ route('warga.complaint.index') }}" class="inline-flex items-center gap-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold px-4 py-2 rounded-xl transition">
                ⬅️ Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 sm:p-8">
            <form action="{{ route('warga.complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Kategori Pengaduan <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-semibold @error('category_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori Permasalahan --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Judul Laporan / Pengaduan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        placeholder="Contoh: Lampu Penerangan Jalan Rusak di Dukuh Catur RT 02"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm font-semibold @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Rincian Isi Pengaduan / Keluhan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                        placeholder="Jelaskan secara lengkapkronologi, lokasi detail, dan permasalahan yang terjadi..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="attachment" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Upload Lampiran Bukti Foto (Opsional)
                    </label>
                    <input type="file" name="attachment" id="attachment" accept="image/png,image/jpeg,image/jpg"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm bg-gray-50 @error('attachment') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Format foto: JPG, JPEG, PNG (Maksimal 2MB).</p>
                    @error('attachment')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('warga.complaint.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm shadow-md transition">
                        🚀 Kirim Laporan Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
