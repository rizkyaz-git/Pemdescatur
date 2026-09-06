@extends('layouts.admin')

@section('title', 'Edit Titik Lokasi Peta')

@section('content')

<div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Titik Lokasi Peta (FR-21)</h3>
            <p class="text-xs text-gray-500 mt-1">Ubah angka koordinat secara manual atau gunakan picker peta interaktif.</p>
        </div>
        <a href="{{ route('admin.locations.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.locations.update', $location->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Nama Titik / Label Lokasi *</label>
            <input type="text" name="name" value="{{ old('name', $location->name) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Gambar Thumbnail Lokasi / UMKM</label>
            @if($location->image)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border border-gray-200 w-fit">
                    <img src="{{ asset('storage/' . $location->image) }}" alt="{{ $location->name }}" class="w-20 h-16 object-cover rounded-lg shadow-xs">
                    <span class="text-xs text-gray-500 font-medium">Thumbnail saat ini</span>
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-600 border border-gray-300 rounded-lg p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-800 hover:file:bg-emerald-100">
            <p class="text-[11px] text-gray-500">Pilih file gambar baru jika ingin memperbarui thumbnail saat ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Latitude *</label>
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}" required class="w-full rounded-lg border-gray-300 shadow-xs font-mono text-sm p-3">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Longitude *</label>
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}" required class="w-full rounded-lg border-gray-300 shadow-xs font-mono text-sm p-3">
            </div>
        </div>

        <!-- Reusable Interactive Map Marker Picker Component (FR-21) -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Pilih Koordinat via Klik Pada Peta (Interactive Picker)</label>
            <x-leaflet-map-picker :latitude="(float) old('latitude', $location->latitude)" :longitude="(float) old('longitude', $location->longitude)" />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Deskripsi Singkat</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">{{ old('description', $location->description) }}</textarea>
        </div>

        <div class="space-y-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_umkm" name="is_umkm" value="1" {{ old('is_umkm', $location->is_umkm) ? 'checked' : '' }} class="rounded border-gray-300 text-[#0d631b] focus:ring-[#0d631b]">
                <label for="is_umkm" class="text-sm font-semibold text-gray-800">Tandai / Tag sebagai <strong>UMKM Desa</strong> (Tampil di slider "UMKM di Sekitar")</label>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_education" name="is_education" value="1" {{ old('is_education', $location->is_education) ? 'checked' : '' }} class="rounded border-gray-300 text-[#0d631b] focus:ring-[#0d631b]">
                <label for="is_education" class="text-sm font-semibold text-gray-800">Tandai / Tag sebagai <strong>Institusi Pendidikan</strong> (Tampil di slider "Institusi Pendidikan")</label>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_primary" name="is_primary" value="1" {{ old('is_primary', $location->is_primary) ? 'checked' : '' }} class="rounded border-gray-300 text-[#0d631b] focus:ring-[#0d631b]">
                <label for="is_primary" class="text-sm font-semibold text-gray-700">Jadikan lokasi utama (Pusat Balai Desa Catur)</label>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.locations.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
