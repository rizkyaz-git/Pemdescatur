@extends('layouts.public')

@section('title', 'Kirim Pengaduan & Aspirasi Warga - Pemerintah Desa Catur')
@section('meta_description', 'Formulir pengajuan pengaduan, aspirasi, dan keluhan fasilitas warga Desa Catur secara privat dan terverifikasi.')

@section('content')
<div class="bg-white min-h-screen py-8 sm:py-12 border-b border-slate-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- ========================================================================= --}}
        {{-- 1. NAVIGATION HEADER & BREADCRUMBS                                       --}}
        {{-- ========================================================================= --}}
        <div class="text-left space-y-3">
            <x-breadcrumbs :items="[
                ['label' => 'BERANDA', 'url' => route('home')],
                ['label' => 'Pengaduan Warga', 'url' => route('warga.complaint.index')],
                ['label' => 'Kirim Pengaduan']
            ]" />

            <div class="flex items-center gap-3.5 pt-1">
                <a href="{{ route('warga.complaint.index') }}"
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0 active:scale-95"
                   title="Kembali ke Halaman Sampul Pengaduan" aria-label="Kembali">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-[#20332A] tracking-tight">
                        Kirim Pengaduan &amp; Aspirasi Warga
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Lengkapi formulir di bawah ini dengan data yang valid. Laporan Anda bersifat privat.
                    </p>
                </div>
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- 2. PRIVACY & SECURITY GUARANTEE BANNER                                    --}}
        {{-- ========================================================================= --}}
        <div class="bg-[#EAF1E8]/70 border border-[#DCE6DA] rounded-xl p-4 sm:p-5 flex items-start gap-3.5 shadow-xs">
            <div class="w-8 h-8 rounded-lg bg-[#0A3D29] text-white flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div class="space-y-1 text-xs sm:text-sm">
                <h4 class="font-serif font-bold text-[#0A3D29]">Kerahasiaan &amp; Keamanan Data Terjamin</h4>
                <p class="text-[#3E4D45] leading-relaxed">
                    Data NIK Anda dienkripsi satu arah dengan aman. Setelah formulir dikirim, sistem akan mengirimkan <strong>tautan verifikasi ke email Anda</strong> untuk mengaktifkan pengaduan.
                </p>
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- 3. MAIN FORM CARD                                                         --}}
        {{-- ========================================================================= --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8 space-y-6">
            <form method="POST" action="{{ route('warga.complaint.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Group A: Identitas Pelapor --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <h2 class="font-serif font-bold text-sm sm:text-base text-slate-900">
                            1. Identitas Pelapor
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        {{-- Nama Lengkap --}}
                        <div class="space-y-1.5">
                            <label for="nama" class="block text-xs font-semibold text-slate-800">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                   placeholder="Masukkan Nama Lengkap..."
                                   autocomplete="name"
                                   class="w-full px-4 py-2.5 rounded-xl border @error('nama') border-rose-500 ring-1 ring-rose-500/20 @else border-slate-300 @enderror text-sm text-slate-900 placeholder:text-slate-400 bg-slate-50/40 focus:bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-2 focus:ring-[#0A3D29]/20 transition shadow-xs">
                            @error('nama')
                                <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        {{-- NIK --}}
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="nik" class="block text-xs font-semibold text-slate-800">
                                    NIK (16 Digit) <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[11px] text-slate-400">Dienkripsi aman</span>
                            </div>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                                   inputmode="numeric" maxlength="16" pattern="[0-9]{16}"
                                   placeholder="Contoh: 330912xxxxxxxxxx"
                                   class="w-full px-4 py-2.5 rounded-xl border @error('nik') border-rose-500 ring-1 ring-rose-500/20 @else border-slate-300 @enderror text-sm text-slate-900 placeholder:text-slate-400 bg-slate-50/40 focus:bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-2 focus:ring-[#0A3D29]/20 font-mono transition shadow-xs">
                            @error('nik')
                                <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-semibold text-slate-800">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="nama@email.com"
                               autocomplete="email"
                               class="w-full px-4 py-2.5 rounded-xl border @error('email') border-rose-500 ring-1 ring-rose-500/20 @else border-slate-300 @enderror text-sm text-slate-900 placeholder:text-slate-400 bg-slate-50/40 focus:bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-2 focus:ring-[#0A3D29]/20 transition shadow-xs">
                        <p class="text-[11px] text-slate-500">
                            Tautan verifikasi pembukaan laporan dan notifikasi tindak lanjut akan dikirim ke email ini.
                        </p>
                        @error('email')
                            <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Group B: Uraian Laporan --}}
                <div class="space-y-4 pt-3 border-t border-slate-100">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h2 class="font-serif font-bold text-sm sm:text-base text-slate-900">
                            2. Rincian Laporan Pengaduan
                        </h2>
                    </div>

                    {{-- Kategori Pengaduan (Dropdown Custom Styled) --}}
                    <div class="space-y-1.5">
                        <label for="kategori" class="block text-xs font-semibold text-slate-800">
                            Kategori Masalah / Bidang <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="kategori" id="kategori" required
                                    class="w-full px-4 py-2.5 rounded-xl border @error('kategori') border-rose-500 ring-1 ring-rose-500/20 @else border-slate-300 @enderror text-sm text-slate-900 bg-slate-50/40 focus:bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-2 focus:ring-[#0A3D29]/20 transition shadow-xs appearance-none pr-10 cursor-pointer">
                                <option value="">-- Pilih Kategori Permasalahan --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" @selected(old('kategori', $selectedCategory ?? '') === $cat)>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- Custom Dropdown Arrow Icon --}}
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('kategori')
                            <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- Isi Laporan --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="isi_laporan" class="block text-xs font-semibold text-slate-800">
                                Uraian Lengkap Laporan / Keluhan <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] text-slate-400">Minimal 10 karakter</span>
                        </div>
                        <textarea name="isi_laporan" id="isi_laporan" rows="6" required
                                  placeholder="Jelaskan secara jelas kronologi persoalan: lokasi kejadian (Dusun, RT/RW atau patokan jalan), waktu kejadian, dampak permasalahan, serta tindakan penanganan yang diharapkan..."
                                  class="w-full px-4 py-3 rounded-xl border @error('isi_laporan') border-rose-500 ring-1 ring-rose-500/20 @else border-slate-300 @enderror text-sm text-slate-900 placeholder:text-slate-400 bg-slate-50/40 focus:bg-white focus:outline-none focus:border-[#0A3D29] focus:ring-2 focus:ring-[#0A3D29]/20 transition shadow-xs leading-relaxed">{{ old('isi_laporan') }}</textarea>
                        @error('isi_laporan')
                            <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- Lampiran Berkas / Foto Bukti (Upload Card with Alpine.js Preview) --}}
                    <div class="space-y-1.5" x-data="{
                        fileName: '',
                        fileSize: '',
                        isHovered: false,
                        handleFileChange(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                                this.fileSize = (file.size / (1024 * 1024) > 1)
                                    ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                                    : (file.size / 1024).toFixed(0) + ' KB';
                            } else {
                                this.fileName = '';
                                this.fileSize = '';
                            }
                        },
                        clearFile() {
                            this.fileName = '';
                            this.fileSize = '';
                            this.$refs.fileInput.value = '';
                        }
                    }">
                        <label for="lampiran" class="block text-xs font-semibold text-slate-800">
                            Lampiran Bukti Foto atau Dokumen (Opsional)
                        </label>
                        
                        <div class="relative border-2 border-dashed rounded-xl p-5 text-center transition cursor-pointer"
                             :class="isHovered ? 'border-[#0A3D29] bg-emerald-50/20' : 'border-slate-300 bg-slate-50/40 hover:bg-slate-50/80'"
                             @dragover.prevent="isHovered = true"
                             @dragleave.prevent="isHovered = false"
                             @drop.prevent="isHovered = false; $refs.fileInput.files = $event.dataTransfer.files; handleFileChange({ target: $refs.fileInput })"
                             @click="$refs.fileInput.click()">
                            
                            {{-- Hidden native file input --}}
                            <input type="file" name="lampiran" id="lampiran" x-ref="fileInput"
                                   accept="image/jpeg,image/png,application/pdf"
                                   class="sr-only"
                                   @change="handleFileChange($event)">

                            {{-- State A: Belum ada file dipilih --}}
                            <div x-show="!fileName" class="space-y-2">
                                <div class="w-10 h-10 mx-auto rounded-full bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div class="text-xs text-slate-600">
                                    <span class="font-bold text-[#0A3D29] hover:underline">Klik untuk pilih berkas</span>
                                    <span>atau seret ke area ini</span>
                                </div>
                                <p class="text-[11px] text-slate-400">
                                    Format: JPG, JPEG, PNG, atau PDF (Ukuran maksimal 2 MB)
                                </p>
                            </div>

                            {{-- State B: File telah dipilih --}}
                            <div x-show="fileName" x-cloak class="flex items-center justify-between bg-white p-3 rounded-lg border border-slate-200 text-left">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-md bg-[#0A3D29] text-white flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-slate-900 truncate" x-text="fileName"></p>
                                        <p class="text-[10px] text-slate-400" x-text="fileSize"></p>
                                    </div>
                                </div>
                                
                                <button type="button" @click.stop="clearFile()"
                                        class="text-xs text-rose-600 hover:text-rose-800 font-semibold px-2 py-1 rounded hover:bg-rose-50 transition shrink-0"
                                        title="Hapus berkas ini">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        @error('lampiran')
                            <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('warga.complaint.index') }}"
                       class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs sm:text-sm font-semibold hover:bg-slate-50 transition text-center active:scale-[0.98]">
                        Batal
                    </a>
                    
                    <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs sm:text-sm py-2.5 px-6 rounded-xl shadow-xs hover:shadow-md transition active:scale-[0.98] cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Kirim &amp; Verifikasi Lewat Email</span>
                    </button>
                </div>

            </form>
        </div>

        {{-- Footer Link to Check Reports --}}
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500">
                Sudah pernah mengirim laporan sebelumnya?
                <a href="{{ route('pelapor.login.request') }}" class="text-[#0A3D29] font-bold hover:underline ml-1">
                    Cek Status Laporan Saya &rarr;
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
