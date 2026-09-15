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
            <div class="space-y-2 p-5 sm:p-6 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
                <label class="block text-[13px] font-semibold text-[#1E293B] mb-2">
                    Foto Profil Resmi
                </label>
                <x-file-picker 
                    name="photo" 
                    accept="image/*" 
                    current="{{ ($official->photo_path && Storage::disk('public')->exists($official->photo_path)) ? asset('storage/' . $official->photo_path) : '' }}" 
                    currentName="{{ basename($official->photo_path ?? '') }}" 
                />
                @error('photo')
                    <p class="text-xs text-rose-600 font-medium mt-1.5">{{ $message }}</p>
                @enderror
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
