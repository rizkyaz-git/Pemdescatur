@extends('layouts.admin')

@section('title', 'Edit Menu Navigasi')

@section('content')

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Item Menu Navigasi</h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui label, urutan, atau visibilitas menu.</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Label Menu *</label>
            <input type="text" name="label" value="{{ old('label', $menu->label) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">URL Target / Path *</label>
            <input type="text" name="slug_or_url" value="{{ old('slug_or_url', $menu->slug_or_url) }}" required class="w-full rounded-lg border-gray-300 shadow-xs font-mono text-sm p-3">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Urutan Tampil (Order) *</label>
                <input type="number" name="order" value="{{ old('order', $menu->order) }}" min="0" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Status Aktif *</label>
                <select name="is_active" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
                    <option value="1" {{ old('is_active', $menu->is_active) ? 'selected' : '' }}>Aktif (Tampilkan di Header)</option>
                    <option value="0" {{ !old('is_active', $menu->is_active) ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" id="is_external" name="is_external" value="1" {{ old('is_external', $menu->is_external) ? 'checked' : '' }} class="rounded border-gray-300 text-[#0d631b] focus:ring-[#0d631b]">
            <label for="is_external" class="text-sm font-semibold text-gray-700">Tautan Eksternal (Buka di tab baru target="_blank")</label>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.menus.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
