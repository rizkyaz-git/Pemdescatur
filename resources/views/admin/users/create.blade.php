@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 font-sans">
    <!-- Header Page Sesuai Desain Minimalis -->
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.users.index') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Tambah Pengguna Baru</h1>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8" x-data="{
        avatarPreview: '',
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
        }
    }">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Foto Profil (Opsional) -->
            <div class="space-y-3 pb-6 border-b border-[#F1F5F9]">
                <label class="block text-[13px] font-semibold text-[#1E293B]">Foto Profil (Opsional)</label>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-100 border border-[#E2E8F0] flex items-center justify-center text-slate-400 shrink-0">
                        <template x-if="avatarPreview">
                            <img :src="avatarPreview" alt="Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!avatarPreview">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </template>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="avatar" id="avatar" accept="image/png,image/jpeg,image/jpg,image/webp"
                            @change="previewImage($event)"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">
                        <p class="text-[11px] text-[#64748B] mt-1">Format: JPG, PNG, WEBP. Maks 2 MB.</p>
                    </div>
                </div>
                @error('avatar')
                    <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Rian Pratama"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        placeholder="email@desacatur.id"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Peran & Hak Akses (Role) <span class="text-rose-500">*</span>
                </label>
                <select name="role" id="role" required
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-white text-slate-900 @error('role') border-rose-500 @enderror">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran Pengguna --</option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>
                        Super Admin — Akses seluruh menu, pengaturan website & kelola pengguna
                    </option>
                    <option value="admin_pemdes" {{ old('role') === 'admin_pemdes' ? 'selected' : '' }}>
                        Admin Pemdes — Akses profil desa, berita, perangkat desa, galeri & layanan publik
                    </option>
                    <option value="ppk_ormawa" {{ old('role') === 'ppk_ormawa' ? 'selected' : '' }}>
                        PPK Ormawa — Akses berita & modul kurikulum/kegiatan PPK Ormawa
                    </option>
                </select>
                @error('role')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password & Konfirmasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div>
                    <label for="password" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('password') border-rose-500 @enderror">
                    @error('password')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                        placeholder="Ketik ulang kata sandi"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#E2E8F0]">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-xs transition active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Simpan Pengguna</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
