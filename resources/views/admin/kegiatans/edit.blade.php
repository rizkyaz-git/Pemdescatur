@extends('layouts.admin')

@section('title', 'Edit Kegiatan PPK Ormawa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.kegiatans.show', $kegiatan) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Detail Kegiatan</span>
            </a>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Kegiatan PPKO</h3>
            <p class="text-xs text-gray-500">Perbarui rincian kegiatan atau ganti foto sampul utama.</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.kegiatans.update', $kegiatan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Pojok Pemberdayaan & Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="pojok_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Pojok Pemberdayaan <span class="text-red-500">*</span>
                    </label>
                    <select name="pojok_id" id="pojok_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 @error('pojok_id') border-red-500 @enderror" required>
                        @foreach($pojoks as $p)
                            <option value="{{ $p->id }}" {{ old('pojok_id', $kegiatan->pojok_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('pojok_id')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_kegiatan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Tanggal Pelaksanaan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $kegiatan->tanggal_kegiatan ? $kegiatan->tanggal_kegiatan->format('Y-m-d') : '') }}" class="w-full text-sm rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 @error('tanggal_kegiatan') border-red-500 @enderror" required>
                    @error('tanggal_kegiatan')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Judul Kegiatan -->
            <div>
                <label for="judul" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Judul Kegiatan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $kegiatan->judul) }}" class="w-full text-sm rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 @error('judul') border-red-500 @enderror" required>
                @error('judul')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail Gambar & Preview Saat Ini -->
            <div>
                <label for="thumbnail" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Foto Sampul / Thumbnail
                </label>
                @if($kegiatan->thumbnail)
                    <div class="mb-3 flex items-center gap-4 p-3 bg-gray-50 border border-gray-200 rounded-xl">
                        <img src="{{ asset('storage/' . $kegiatan->thumbnail) }}" alt="{{ $kegiatan->judul }}" class="w-20 h-16 object-cover rounded-lg border border-gray-200 shadow-2xs">
                        <div>
                            <span class="text-xs font-bold text-gray-700 block">Thumbnail Saat Ini</span>
                            <span class="text-[11px] text-gray-500">Unggah file baru di bawah jika ingin mengganti foto sampul ini.</span>
                        </div>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-emerald-500 transition">
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-[11px] text-gray-400 mt-2">Format: JPG, JPEG, PNG, WEBP. Maksimal 4MB.</p>
                </div>
                @error('thumbnail')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Kegiatan -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Deskripsi Lengkap Kegiatan <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="6" class="w-full text-sm rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-3 @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.kegiatans.show', $kegiatan) }}" class="px-4 py-2 text-xs font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Perbarui Data Kegiatan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
