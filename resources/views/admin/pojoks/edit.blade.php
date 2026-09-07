@extends('layouts.admin')

@section('title', 'Kelola ' . $pojok->nama . ' & Kurikulum')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- Flash Alert Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Header & Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <a href="{{ route('admin.pojoks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar 5 Pojok</span>
            </a>
            <h3 class="font-serif font-bold text-xl text-gray-900">{{ $pojok->nama }}</h3>
            <p class="text-xs text-gray-500 mt-0.5">Kelola kurikulum/modul materi pelatihan dan informasi profil pilar ini.</p>
        </div>

        <a href="{{ route('public.ppko') }}#{{ Str::slug(str_replace('Pojok ', '', $pojok->nama)) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
            <span>Lihat Section di Publik</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    <!-- 1. FORM EDIT DESKRIPSI POJOK -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <h4 class="font-serif font-bold text-base text-gray-900 mb-4 pb-2 border-b border-gray-100">
            Deskripsi Pilar {{ $pojok->nama }}
        </h4>
        <form action="{{ route('admin.pojoks.update', $pojok) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Nama Pilar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $pojok->nama) }}" class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5" required>
                    @error('nama')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Deskripsi Singkat Program <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi_singkat" rows="3" class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5" required>{{ old('deskripsi_singkat', $pojok->deskripsi_singkat) }}</textarea>
                    @error('deskripsi_singkat')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs px-4 py-2 rounded-lg transition">
                    <span>Simpan Perubahan Deskripsi</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 2. FORM UPLOAD KURIKULUM BARU -->
    <div class="bg-emerald-50/50 rounded-xl border border-emerald-200/80 p-6 sm:p-8 shadow-xs space-y-4">
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-lg bg-[#0d631b] text-white flex items-center justify-center font-bold text-xs">
                📄
            </span>
            <div>
                <h4 class="font-serif font-bold text-base text-gray-900">Tambah Kurikulum / Modul Materi Baru</h4>
                <p class="text-xs text-gray-500">Unggah silabus, panduan modul, materi pelatihan, atau SOP untuk {{ $pojok->nama }}.</p>
            </div>
        </div>

        <form action="{{ route('admin.pojoks.kurikulum.store', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-2">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Judul Kurikulum / Modul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Modul Pelatihan Pembuatan Pupuk Organik Cair" class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 bg-white" required>
                    @error('judul')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Pilih File Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer bg-white p-2 rounded-lg border border-gray-300" required>
                    <p class="text-[11px] text-gray-400 mt-1">Mendukung format PDF, DOCX, PPTX, ZIP (maksimal 15MB).</p>
                    @error('file')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Ringkasan Isi / Keterangan Materi <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <textarea name="deskripsi" rows="2" placeholder="Ringkasan singkat silabus, bab materi, atau petunjuk penggunaan modul ini bagi warga..." class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 bg-white">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Unggah Dokumen Kurikulum</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 3. DAFTAR KURIKULUM YANG TELAH DIUNGGAH -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-gray-200 pb-3">
            <div>
                <h4 class="font-serif font-bold text-base text-gray-900">Dokumen Kurikulum {{ $pojok->nama }}</h4>
                <p class="text-xs text-gray-500">Materi yang aktif dan dapat diunduh oleh pengunjung publik di halaman profil program.</p>
            </div>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">
                {{ $pojok->kurikulums->count() }} Dokumen
            </span>
        </div>

        @if($pojok->kurikulums->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pojok->kurikulums as $kuri)
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-2xs hover:shadow-sm transition flex flex-col justify-between space-y-3">
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        PDF
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-gray-900 leading-snug">{{ $kuri->judul }}</h5>
                                        <span class="text-[11px] text-gray-400 block">{{ $kuri->file_name }} • {{ $kuri->formatted_file_size }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($kuri->deskripsi)
                                <p class="text-xs text-gray-600 leading-relaxed bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                    {{ $kuri->deskripsi }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-[11px] text-gray-400">
                                Diunggah: {{ $kuri->created_at->translatedFormat('d M Y') }}
                            </span>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('public.ppko.kurikulum.download', $kuri) }}" class="text-emerald-700 hover:text-emerald-900 font-bold flex items-center gap-1 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    <span>Unduh</span>
                                </a>
                                <form action="{{ route('admin.kurikulums.destroy', $kuri) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kurikulum ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl border border-dashed border-gray-300 p-8 text-center">
                <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-xs font-semibold text-gray-700">Belum ada dokumen kurikulum untuk {{ $pojok->nama }}.</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Gunakan formulir di atas untuk mengunggah silabus atau modul materi.</p>
            </div>
        @endif
    </div>

</div>
@endsection
