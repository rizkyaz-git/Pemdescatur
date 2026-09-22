@extends('layouts.public')

@section('title', 'Pengajuan Surat - Pemerintah Desa Catur')
@section('meta_description', 'Formulir pengajuan surat resmi Pemerintah Desa Catur. Isi data diri Anda dan jenis surat yang dibutuhkan — admin desa akan menghubungi Anda melalui WhatsApp.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="text-left space-y-2">
                <x-breadcrumbs :items="[
                    ['label' => 'Layanan', 'url' => '/'],
                    ['label' => 'Pengajuan Surat']
                ]" />
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="font-serif text-2xl font-bold text-slate-900 tracking-tight">Pengajuan Surat</h1>
                        <p class="text-xs text-slate-500 mt-1">Isi formulir di bawah. Admin Desa akan menghubungi Anda melalui WhatsApp untuk menindaklanjuti.</p>
                    </div>
                    {{-- Tautan sekunder ke katalog template — understated, sesuai PRD §19 --}}
                    <a href="{{ route('warga.letter.templates') }}"
                       class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#0A3D29] hover:text-[#072B1D] underline underline-offset-2 shrink-0 mt-1 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Lihat Template &amp; Format Surat</span>
                    </a>
                </div>
            </div>

            {{-- Flash Success --}}
            @if(session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-green-800 font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
                <form action="{{ route('warga.letter.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Lengkap (field baru) --}}
                    <div>
                        <label for="nama" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="form_data[nama]" id="nama" value="{{ old('form_data.nama') }}" required
                            placeholder="Masukkan nama lengkap sesuai KTP"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('form_data.nama') border-rose-500 @enderror">
                        @error('form_data.nama')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="form_data[nik]" id="nik" value="{{ old('form_data.nik') }}" required
                            maxlength="16" inputmode="numeric" placeholder="16 digit NIK sesuai KTP"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 font-mono @error('form_data.nik') border-rose-500 @enderror">
                        @error('form_data.nik')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. WhatsApp --}}
                    <div>
                        <label for="telepon" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="form_data[telepon]" id="telepon" value="{{ old('form_data.telepon') }}" required
                            placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('form_data.telepon') border-rose-500 @enderror">
                        <p class="text-[11px] text-slate-400 mt-1">Admin akan menghubungi Anda melalui nomor ini untuk menindaklanjuti permohonan.</p>
                        @error('form_data.telepon')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Surat --}}
                    <div>
                        <label for="template_id" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Jenis Surat <span class="text-rose-500">*</span>
                        </label>
                        @if($isEmpty)
                            <select name="template_id" id="template_id" disabled
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-400 bg-slate-100 cursor-not-allowed">
                                <option value="">Belum ada jenis surat tersedia — hubungi admin desa</option>
                            </select>
                            <p class="text-xs text-amber-600 font-medium mt-1">Jenis surat belum tersedia. Silakan hubungi Kantor Desa Catur secara langsung.</p>
                        @else
                            <select name="template_id" id="template_id" required
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('template_id') border-rose-500 @enderror">
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($templates as $tpl)
                                    <option value="{{ $tpl->id }}" {{ old('template_id', request('template_id')) == $tpl->id ? 'selected' : '' }}>
                                        {{ $tpl->name }}{{ $tpl->code ? ' (' . $tpl->code . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('template_id')
                                <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>

                    {{-- Keperluan / Keterangan --}}
                    <div>
                        <label for="keperluan" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Keperluan / Keterangan Permohonan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="form_data[keperluan]" id="keperluan" rows="4" required
                            placeholder="Jelaskan maksud penggunaan surat ini (contoh: untuk keperluan pengajuan KUR bank, pendaftaran sekolah, dll)..."
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('form_data.keperluan') border-rose-500 @enderror">{{ old('form_data.keperluan') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Minimal 10 karakter, maksimal 1.000 karakter.</p>
                        @error('form_data.keperluan')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="reset"
                            class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                            Reset
                        </button>
                        <button type="submit" {{ $isEmpty ? 'disabled' : '' }}
                            class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-6 rounded-lg transition shadow-xs cursor-pointer {{ $isEmpty ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span>Kirim Permohonan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
