@extends('layouts.admin')

@section('title', 'Edit Kartu Keluarga')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">✏️ Edit Kartu Keluarga</h1>
            <p class="text-xs text-gray-500 mt-1">Perbarui informasi No. KK, Nama Kepala Keluarga, atau Alamat.</p>
        </div>
        <a href="{{ route('admin.families.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.families.update', $family->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="kk_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Nomor Kartu Keluarga (16 Digit) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kk_number" id="kk_number" value="{{ old('kk_number', $family->kk_number) }}" maxlength="16" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-mono @error('kk_number') border-red-500 @enderror">
                @error('kk_number')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="head_of_family" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Nama Kepala Keluarga <span class="text-red-500">*</span>
                </label>
                <input type="text" name="head_of_family" id="head_of_family" value="{{ old('head_of_family', $family->head_of_family) }}" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('head_of_family') border-red-500 @enderror">
                @error('head_of_family')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Alamat Tempat Tinggal <span class="text-red-500">*</span>
                </label>
                <textarea name="address" id="address" rows="3" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('address') border-red-500 @enderror">{{ old('address', $family->address) }}</textarea>
                @error('address')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.families.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold shadow-sm transition">
                    💾 Perbarui Data KK
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
