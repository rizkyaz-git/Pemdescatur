@extends('layouts.admin')

@section('title', 'Tambah Perangkat Desa')

@section('content')

<div class="max-w-3xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Tambah Data Perangkat Desa Baru</h3>
            <p class="text-xs text-gray-500 mt-1">Masukkan nama, jabatan, posisi hierarki, dan foto perangkat desa.</p>
        </div>
        <a href="{{ route('admin.officials.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.officials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap & Gelar *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="Contoh: I Wayan Suardana, S.Pd.">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Jabatan *</label>
                <input type="text" name="position" value="{{ old('position') }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="Contoh: Perbekel / Sekretaris Desa / Kaur">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Atasan (Hierarki Organisasi)</label>
                <select name="parent_id" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                    <option value="">-- Tidak ada (Posisi Teratas / Perbekel) --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->position }} — {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Urutan Tampil (Order) *</label>
                <input type="number" name="order" value="{{ old('order', 1) }}" min="0" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Nomor Telepon / WA (Opsional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="081234567890">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Email (Opsional)</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3" placeholder="perangkat@desacatur.id">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Foto Profil (Opsional)</label>
            <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0d631b] hover:file:bg-emerald-100">
            <p class="text-[11px] text-emerald-900 font-medium">📐 Rekomendasi Resolusi: <strong>600 x 800 px</strong> (Rasio 3:4 Portrait) atau <strong>512 x 512 px</strong> (Rasio 1:1 Pasfoto). Format JPG, PNG, WEBP. Maksimal 2 MB.</p>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.officials.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Perangkat Desa
            </button>
        </div>
    </form>
</div>

@endsection
