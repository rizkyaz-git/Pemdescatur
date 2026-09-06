@extends('layouts.admin')

@section('title', 'Tambah Template Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">➕ Tambah Template Surat</h1>
            <p class="text-xs text-gray-500 mt-1">Buat format jenis surat baru dan masukkan placeholder data otomatis.</p>
        </div>
        <a href="{{ route('admin.letter-templates.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.letter-templates.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Nama Template Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Surat Keterangan Usaha (SKU)"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Kode Singkat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" required
                        placeholder="Contoh: SKU"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-mono uppercase @error('code') border-red-500 @enderror">
                    @error('code')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Keterangan & Persyaratan
                </label>
                <textarea name="description" id="description" rows="2"
                    placeholder="Contoh: Diperlukan untuk permohonan izin usaha mikro kecil..."
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="template_text" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Format Isian / Teks Template Surat (HTML/Text) <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-500 mb-2">Gunakan placeholder seperti <code>&#123;&#123;nama&#125;&#125;</code>, <code>&#123;&#123;nik&#125;&#125;</code>, <code>&#123;&#123;alamat&#125;&#125;</code>, <code>&#123;&#123;keperluan&#125;&#125;</code>.</p>
                <textarea name="template_text" id="template_text" rows="12" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs font-mono bg-gray-50 @error('template_text') border-red-500 @enderror">{{ old('template_text') }}</textarea>
                @error('template_text')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.letter-templates.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold shadow-sm transition">
                    💾 Simpan Template
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
