@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 font-sans">

    <!-- Header Sesuai Desain Minimalis -->
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.dashboard') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali ke Dashboard"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Pengaturan Profil Admin</h1>
    </div>

    <!-- Main Card Form -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8 space-y-8" x-data="{
        avatarPreview: '{{ $user->avatar_url ?? '' }}',
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
        }
    }">

        <!-- Ringkasan Akun & Role Badge -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
            <div class="flex items-center gap-4">
                <!-- Avatar Circle / Initials -->
                <div class="relative w-16 h-16 rounded-2xl overflow-hidden bg-[#0F4C3A] text-white flex items-center justify-center font-jakarta font-bold text-xl shadow-xs border border-white shrink-0">
                    <template x-if="avatarPreview">
                        <img :src="avatarPreview" alt="Foto Profil" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!avatarPreview">
                        <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </template>
                </div>
                <div>
                    <h3 class="font-jakarta font-bold text-base text-[#0F172A]">{{ $user->name }}</h3>
                    <p class="text-xs text-[#64748B]">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Role Badge -->
            <div class="flex items-center gap-2">
                @if($user->isSuperAdmin())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                        <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                        Super Admin
                    </span>
                @elseif($user->isAdminPemdes())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Admin Pemdes
                    </span>
                @elseif($user->isPpkOrmawa())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                        PPK Ormawa
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $user->role_label }}
                    </span>
                @endif
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Foto Profil -->
            <div class="space-y-4">
                <div class="border-b border-[#F1F5F9] pb-3">
                    <h2 class="font-jakarta font-bold text-base text-[#0F172A]">Foto Profil</h2>
                    <p class="text-xs text-[#64748B] mt-0.5">Unggah foto profil resmi untuk tampilan akun dan navigasi.</p>
                </div>

                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <input type="file" name="avatar" id="avatar" accept="image/png,image/jpeg,image/jpg,image/webp"
                            @change="previewImage($event)"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F4C3A] file:text-white hover:file:bg-[#072C21] cursor-pointer bg-white p-1 rounded-xl border border-[#E2E8F0]">

                        @if($user->avatar)
                            <button type="button" 
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus foto profil?')) { document.getElementById('delete-avatar-form').submit(); }"
                                class="px-3.5 py-2.5 rounded-xl text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition shrink-0">
                                Hapus Foto
                            </button>
                        @endif
                    </div>
                    <p class="text-[11px] text-[#64748B]">Format gambar yang didukung: JPG, PNG, WEBP. Ukuran maksimal 2 MB.</p>
                    @error('avatar')
                        <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bagian 2: Informasi Dasar -->
            <div class="space-y-4">
                <div class="border-b border-[#F1F5F9] pb-3">
                    <h2 class="font-jakarta font-bold text-base text-[#0F172A]">Informasi Akun</h2>
                    <p class="text-xs text-[#64748B] mt-0.5">Nama pengguna dan alamat surel utama yang digunakan untuk masuk.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Ganti Password (Opsional) -->
            <div class="space-y-4">
                <div class="border-b border-[#F1F5F9] pb-3">
                    <h2 class="font-jakarta font-bold text-base text-[#0F172A]">Ubah Kata Sandi</h2>
                    <p class="text-xs text-[#64748B] mt-0.5">Kosongkan jika Anda tidak bermaksud memperbarui kata sandi akun.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                            Kata Sandi Saat Ini
                        </label>
                        <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                            placeholder="Masukkan sandi saat ini jika ingin mengganti sandi baru"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('current_password') border-rose-500 @enderror">
                        @error('current_password')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                                Kata Sandi Baru
                            </label>
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('password') border-rose-500 @enderror">
                            @error('password')
                                <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                placeholder="Ketik ulang kata sandi baru"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E2E8F0]">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold shadow-xs transition active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

        <!-- Hidden Form untuk Hapus Avatar -->
        @if($user->avatar)
            <form id="delete-avatar-form" action="{{ route('admin.profile.destroy-avatar') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>

</div>
@endsection
