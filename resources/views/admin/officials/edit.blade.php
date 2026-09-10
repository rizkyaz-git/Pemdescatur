@extends('layouts.admin')

@section('title', 'Edit Perangkat Desa')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Page: Tombol kembali di kiri gaya ikon, header sederhana hanya judul -->
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.officials.index') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Edit Data Perangkat Desa</h1>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.officials.update', $official->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $official->name) }}" required 
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="position" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Jabatan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="position" id="position" value="{{ old('position', $official->position) }}" required 
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('position') border-rose-500 @enderror">
                    @error('position')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Nomor Telepon / WhatsApp
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $official->phone) }}" 
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm tabular-nums bg-[#F8FAFC]/40 text-slate-900">
                </div>

                <div>
                    <label for="email" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Alamat Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $official->email) }}" 
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">
                </div>
            </div>

            <!-- Upload Foto Profil Section -->
            <div class="p-5 sm:p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] space-y-4"
                 x-data="{
                    preview: null,
                    hasExisting: {{ ($official->photo_path && Storage::disk('public')->exists($official->photo_path)) ? 'true' : 'false' }},
                    imgError: false,
                    fileChosen(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.preview = URL.createObjectURL(file);
                            this.imgError = false;
                        }
                    }
                 }">
                <div class="flex items-center justify-between">
                    <label class="block text-[13px] font-semibold text-[#1E293B]">
                        Foto Profil Resmi
                    </label>
                    <span class="text-[11px] font-medium text-slate-500">
                        Format JPG, PNG, WEBP (Maks. 2MB)
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <!-- Avatar / Image Preview Container -->
                    <div class="relative w-20 h-24 sm:w-24 sm:h-28 rounded-xl overflow-hidden bg-white border border-[#E2E8F0] shadow-xs flex items-center justify-center shrink-0">
                        <!-- Preview jika user memilih berkas baru -->
                        <template x-if="preview">
                            <img :src="preview" alt="Preview Foto" class="w-full h-full object-cover object-top">
                        </template>

                        <!-- Foto yang sudah ada di database -->
                        <template x-if="!preview && hasExisting && !imgError">
                            <img src="{{ asset('storage/' . $official->photo_path) }}" 
                                 alt="{{ $official->name }}" 
                                 x-on:error="imgError = true" 
                                 class="w-full h-full object-cover object-top">
                        </template>

                        <!-- Fallback avatar inisial jika belum ada atau file hilang/rusak -->
                        <div x-show="preview === null && (!hasExisting || imgError)" 
                             class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-[#0F4C3A]">
                            <span class="font-jakarta font-bold text-base text-[#0F4C3A]">
                                {{ strtoupper(substr($official->name ?? 'PD', 0, 2)) }}
                            </span>
                            <span class="text-[9px] text-slate-400 font-medium mt-0.5">Belum ada</span>
                        </div>
                    </div>

                    <!-- Upload Controls & Info -->
                    <div class="flex-1 min-w-0 space-y-2">
                        <div class="text-xs text-slate-600">
                            <p class="font-medium text-slate-800" x-text="preview ? 'Foto baru siap diunggah' : (hasExisting && !imgError ? 'Foto profil aktif saat ini' : 'Belum ada foto yang tersimpan')"></p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Pilih berkas foto baru jika ingin memperbarui tampilan profil aparatur.</p>
                        </div>

                        <div>
                            <input type="file" 
                                   name="photo" 
                                   id="photo" 
                                   accept="image/*" 
                                   @change="fileChosen"
                                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0F4C3A] hover:file:bg-emerald-100 file:cursor-pointer cursor-pointer border border-[#E2E8F0] rounded-xl bg-white p-1 focus:outline-hidden">
                        </div>

                        <p class="text-[11px] text-slate-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Rekomendasi rasio pasfoto <strong>3:4</strong> (misal 600×800 px) atau kotak <strong>1:1</strong>.</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                <a href="{{ route('admin.officials.index') }}" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Perbarui Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
