@extends('layouts.admin')

@section('title', 'Tambah Data Statistik Infografis')

@section('content')

<div class="max-w-xl mx-auto space-y-5">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div class="flex items-center gap-3 mb-5">
            <a href="{{ route('admin.village-stats.index') }}" class="text-gray-400 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h3 class="font-serif font-bold text-xl text-gray-900">Tambah Data Statistik</h3>
                <p class="text-xs text-gray-500">Tambah data baru untuk chart infografis profil desa</p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl space-y-1">
            @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
        </div>
        @endif

        <form action="{{ route('admin.village-stats.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->label }} ({{ $cat->chart_type }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
                    <input type="text" name="label" value="{{ old('label') }}" required placeholder="contoh: Petani"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nilai (Angka) <span class="text-red-500">*</span></label>
                    <input type="number" name="value" value="{{ old('value') }}" required step="0.01" placeholder="contoh: 624"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tahun</label>
                    <input type="number" name="year" value="{{ old('year') }}" placeholder="contoh: 2018 (kosongkan jika tidak ada tahun)"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Sub Grup</label>
                    <input type="text" name="sub_group" value="{{ old('sub_group') }}" placeholder="contoh: Baik, Sedang, Rusak"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Urutan Tampil</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A3D29]">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-[#0A3D29] hover:bg-emerald-800 text-white font-bold text-sm py-2.5 rounded-xl transition">
                    Simpan Data
                </button>
                <a href="{{ route('admin.village-stats.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm py-2.5 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
