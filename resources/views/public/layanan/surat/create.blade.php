@extends('layouts.public')

@section('title', 'Buat Permohonan Surat - Desa Catur')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-start justify-between text-left">
            <div>
                <x-breadcrumbs :items="[
                    ['label' => 'SURAT', 'url' => route('warga.letter.index')],
                    ['label' => 'Buat Permohonan']
                ]" />
                <h1 class="font-serif text-2xl font-bold text-gray-900">Buat Permohonan Surat Baru</h1>
                <p class="text-xs text-gray-500 mt-1">Pilih jenis surat dan lengkapi data permohonan Anda.</p>
            </div>
            <a href="{{ route('warga.letter.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2 rounded-xl transition shrink-0">
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
            <form action="{{ route('warga.letter.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="template_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Pilih Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="template_id" id="template_id" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-semibold @error('template_id') border-red-500 @enderror">
                        <option value="">-- Pilih Jenis Surat Administrasi --</option>
                        @foreach($templates as $tpl)
                            <option value="{{ $tpl->id }}" {{ (old('template_id', request('template_id')) == $tpl->id) ? 'selected' : '' }}>
                                {{ $tpl->title ?? $tpl->name }} ({{ $tpl->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('template_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <h3 class="font-bold text-sm text-gray-800 uppercase tracking-wider">Isian Data Permohonan</h3>

                    <div>
                        <label for="keperluan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Maksud / Keperluan Permohonan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="form_data[keperluan]" id="keperluan" rows="3" required
                            placeholder="Jelaskan maksud penggunaan surat ini (contoh: Keperluan pengajuan KUR bank, pendaftaran sekolah, dll)..."
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">{{ old('form_data.keperluan') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nik_pemohon" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                NIK Pemohon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="form_data[nik]" id="nik_pemohon" required maxlength="16"
                                placeholder="16 Digit NIK"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm font-mono"
                                value="{{ old('form_data.nik', auth()->user()->nik ?? '') }}">
                        </div>

                        <div>
                            <label for="telepon" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Nomor WA / Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="form_data[telepon]" id="telepon" required
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm"
                                value="{{ old('form_data.telepon') }}">
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('warga.letter.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-sm shadow-md transition">
                        🚀 Kirim Permohonan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
