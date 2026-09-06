@extends('layouts.admin')

@section('title', 'Edit Perangkat Desa')

@section('content')

<div class="max-w-3xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Data Perangkat Desa</h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui nama, jabatan, urutan, atau foto perangkat desa.</p>
        </div>
        <a href="{{ route('admin.officials.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.officials.update', $official->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap & Gelar *</label>
                <input type="text" name="name" value="{{ old('name', $official->name) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Jabatan *</label>
                <input type="text" name="position" value="{{ old('position', $official->position) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Atasan (Hierarki Organisasi)</label>
                <select name="parent_id" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                    <option value="">-- Tidak ada (Posisi Teratas / Perbekel) --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $official->parent_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->position }} — {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Urutan Tampil (Order) *</label>
                <input type="number" name="order" value="{{ old('order', $official->order) }}" min="0" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Nomor Telepon / WA</label>
                <input type="text" name="phone" value="{{ old('phone', $official->phone) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $official->email) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Foto Profil</label>
            @if($official->photo_path)
                <div class="flex items-center gap-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                    <img src="{{ asset('storage/' . $official->photo_path) }}" class="w-16 h-16 rounded-full object-cover border border-emerald-600">
                    <p class="text-xs text-gray-500">Foto profil saat ini. Upload foto baru jika ingin mengganti.</p>
                </div>
            @endif
            <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0d631b] hover:file:bg-emerald-100">
            <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>600 x 800 px</strong> (Rasio 3:4 Portrait) atau <strong>512 x 512 px</strong> (Rasio 1:1 Pasfoto). Format JPG, PNG, WEBP. Maksimal 2 MB.</p>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.officials.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
