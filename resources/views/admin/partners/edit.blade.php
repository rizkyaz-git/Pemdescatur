@extends('layouts.admin')

@section('title', 'Edit Logo Program / Mitra')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200">
        <h1 class="font-serif font-bold text-xl text-gray-900">Edit Logo Program: {{ $partner->name }}</h1>
        <p class="text-xs text-gray-500 mt-1">Ubah data atau upload gambar logo baru.</p>
    </div>

    <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap Program / Mitra *</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" required class="w-full text-xs px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            @error('name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Tampilan / Display Name (Label Marquee depan)</label>
            <input type="text" name="display_name" value="{{ old('display_name', $partner->display_name) }}" placeholder="Contoh: Kemendagri" class="w-full text-xs px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            <p class="text-[11px] text-gray-500 font-medium mt-1">Nama pendek yang ditampilkan di marquee halaman depan. Jika dikosongkan, akan menggunakan Nama Lengkap.</p>
            @error('display_name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">File Gambar Logo (Ganti jika ingin diperbarui)</label>
            @if($partner->logo)
                <div class="mb-2 p-2 bg-gray-50 rounded-lg inline-block border border-gray-200">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-10 object-contain">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full text-xs px-4 py-2 rounded-xl border border-gray-300 bg-gray-50 text-gray-600">
            <p class="text-[11px] text-emerald-900 font-medium mt-1">📐 Rekomendasi Resolusi: <strong>400 x 200 px</strong> (Format PNG / SVG Transparan disarankan). Maksimal 2 MB.</p>
            @error('logo') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tautan Web / Portal (URL Opsional)</label>
            <input type="url" name="url" value="{{ old('url', $partner->url) }}" placeholder="https://..." class="w-full text-xs px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            @error('url') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Urutan Tampilan</label>
                <input type="number" name="order" value="{{ old('order', $partner->order) }}" class="w-full text-xs px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            </div>

            <div class="flex items-center pt-6">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $partner->is_active ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                    <span class="text-xs font-bold text-gray-700">Tampilkan (Aktif)</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.partners.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 text-xs font-bold hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0d631b] hover:bg-[#0a4d15] text-white text-xs font-bold transition shadow-sm">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
