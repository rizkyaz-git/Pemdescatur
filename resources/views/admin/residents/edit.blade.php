@extends('layouts.admin')

@section('title', 'Edit Data Penduduk')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">✏️ Edit Data Penduduk</h1>
            <p class="text-xs text-gray-500 mt-1">Perbarui biodata penduduk {{ $resident->name }}.</p>
        </div>
        <a href="{{ route('admin.residents.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.residents.update', $resident->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="family_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Kartu Keluarga (KK) <span class="text-red-500">*</span>
                </label>
                <select name="family_id" id="family_id" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('family_id') border-red-500 @enderror">
                    @foreach($families as $family)
                        <option value="{{ $family->id }}" {{ old('family_id', $resident->family_id) == $family->id ? 'selected' : '' }}>
                            {{ $family->kk_number }} - Kepala Keluarga: {{ $family->head_of_family }}
                        </option>
                    @endforeach
                </select>
                @error('family_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="nik" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        NIK (16 Digit) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $resident->nik) }}" maxlength="16" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-mono @error('nik') border-red-500 @enderror">
                    @error('nik')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $resident->name) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="gender" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="gender" id="gender" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('gender') border-red-500 @enderror">
                        <option value="L" {{ old('gender', $resident->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender', $resident->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_place" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $resident->birth_place) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('birth_place') border-red-500 @enderror">
                    @error('birth_place')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', \Carbon\Carbon::parse($resident->birth_date)->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="relationship_to_head" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Hubungan Dalam Keluarga
                    </label>
                    <input type="text" name="relationship_to_head" id="relationship_to_head" value="{{ old('relationship_to_head', $resident->relationship_to_head) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('relationship_to_head') border-red-500 @enderror">
                    @error('relationship_to_head')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Status Keberadaan <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('status') border-red-500 @enderror">
                        <option value="hidup" {{ old('status', $resident->status) == 'hidup' ? 'selected' : '' }}>Hidup</option>
                        <option value="meninggal" {{ old('status', $resident->status) == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                        <option value="pindah" {{ old('status', $resident->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.residents.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold shadow-sm transition">
                    💾 Perbarui Data Penduduk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
