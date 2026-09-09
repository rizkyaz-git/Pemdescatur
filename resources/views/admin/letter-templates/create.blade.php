@extends('layouts.admin')

@section('title', 'Tambah Template Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-[#0F4C3A] border border-emerald-100 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Format Layanan Baru</span>
            </div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Tambah Template Surat</h1>
            <p class="text-xs text-[#64748B] mt-1">Buat format jenis surat baru dan tentukan placeholder data otomatis.</p>
        </div>
        <a href="{{ route('admin.letter-templates.index') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl border border-[#E2E8F0] transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.letter-templates.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Nama Template Surat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Surat Keterangan Usaha (SKU)"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Kode Singkat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" required
                        placeholder="Contoh: SKU"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm font-mono uppercase bg-[#F8FAFC]/40 text-slate-900 @error('code') border-rose-500 @enderror">
                    @error('code')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Keterangan & Persyaratan
                </label>
                <textarea name="description" id="description" rows="2"
                    placeholder="Contoh: Diperlukan untuk permohonan izin usaha mikro kecil..."
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="template_text" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Format Isian / Teks Template Surat (HTML/Text) <span class="text-rose-500">*</span>
                </label>
                <p class="text-xs text-[#64748B] mb-2">Gunakan placeholder dinamis seperti: <code class="px-1.5 py-0.5 rounded-md bg-slate-100 font-mono text-[#0F4C3A]">&#123;&#123;nama&#125;&#125;</code>, <code class="px-1.5 py-0.5 rounded-md bg-slate-100 font-mono text-[#0F4C3A]">&#123;&#123;nik&#125;&#125;</code>, <code class="px-1.5 py-0.5 rounded-md bg-slate-100 font-mono text-[#0F4C3A]">&#123;&#123;alamat&#125;&#125;</code>, <code class="px-1.5 py-0.5 rounded-md bg-slate-100 font-mono text-[#0F4C3A]">&#123;&#123;keperluan&#125;&#125;</code>.</p>
                <textarea name="template_text" id="template_text" rows="12" required
                    class="w-full px-4 py-3 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs font-mono bg-[#F8FAFC]/60 text-slate-900 leading-relaxed @error('template_text') border-rose-500 @enderror">{{ old('template_text') }}</textarea>
                @error('template_text')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                <a href="{{ route('admin.letter-templates.index') }}" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Template</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
