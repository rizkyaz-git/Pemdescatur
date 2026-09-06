@extends('layouts.admin')

@section('title', 'Edit Statistik')

@section('content')

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Edit Data Statistik</h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui label, nilai, atau kategori statistik.</p>
        </div>
        <a href="{{ route('admin.statistics.index') }}" class="text-xs text-gray-600 hover:underline">← Kembali</a>
    </div>

    <form action="{{ route('admin.statistics.update', $statistic->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Kategori *</label>
            <input type="text" name="category" value="{{ old('category', $statistic->category) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Label Indikator *</label>
            <input type="text" name="label" value="{{ old('label', $statistic->label) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Nilai (Value) *</label>
                <input type="text" name="value" value="{{ old('value', $statistic->value) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Satuan (Unit)</label>
                <input type="text" name="unit" value="{{ old('unit', $statistic->unit) }}" class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Periode / Tahun *</label>
                <input type="text" name="period" value="{{ old('period', $statistic->period) }}" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-700">Urutan Tampil (Order) *</label>
                <input type="number" name="order" value="{{ old('order', $statistic->order) }}" min="0" required class="w-full rounded-lg border-gray-300 shadow-xs text-sm p-3">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.statistics.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-lg shadow-md transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
