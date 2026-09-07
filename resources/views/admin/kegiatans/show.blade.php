@extends('layouts.admin')

@section('title', 'Detail & Galeri Kegiatan PPK Ormawa')

@section('content')
<div class="space-y-8">

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

    <!-- Top Navigation & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <a href="{{ route('admin.kegiatans.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Kegiatan</span>
            </a>
            <h3 class="font-serif font-bold text-xl text-gray-900">{{ $kegiatan->judul }}</h3>
            <div class="flex flex-wrap items-center gap-2 mt-1.5 text-xs text-gray-500">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                    {{ $kegiatan->pojok->nama ?? '-' }}
                </span>
                <span>•</span>
                <span>Tanggal: <strong>{{ $kegiatan->tanggal_kegiatan->translatedFormat('l, d F Y') }}</strong></span>
                <span>•</span>
                <span>Dibuat oleh: <strong>{{ $kegiatan->creator->name ?? 'Admin' }}</strong></span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('public.ppko', ['pojok' => $kegiatan->pojok_id]) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat di Publik</span>
            </a>
            <a href="{{ route('admin.kegiatans.edit', $kegiatan) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Kegiatan</span>
            </a>
            <form action="{{ route('admin.kegiatans.destroy', $kegiatan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus seluruh kegiatan dan galeri ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Activity Detail Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            @if($kegiatan->thumbnail)
                <div class="md:col-span-4">
                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Foto Sampul / Thumbnail</span>
                    <img src="{{ asset('storage/' . $kegiatan->thumbnail) }}" alt="{{ $kegiatan->judul }}" class="w-full h-52 object-cover rounded-xl border border-gray-200 shadow-xs">
                </div>
            @endif

            <div class="{{ $kegiatan->thumbnail ? 'md:col-span-8' : 'md:col-span-12' }} space-y-4">
                <div>
                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Deskripsi Kegiatan</span>
                    <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-xl border border-gray-100">
                        {{ $kegiatan->deskripsi }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: GALERI FOTO DOKUMENTASI -->
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
            <div>
                <h4 class="font-serif font-bold text-lg text-gray-900">Galeri Foto Dokumentasi</h4>
                <p class="text-xs text-gray-500">Unggah dan kelola foto-foto dokumentasi pendukung untuk kegiatan ini.</p>
            </div>
            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                Total: {{ $kegiatan->galeriFotos->count() }} Foto
            </span>
        </div>

        <!-- Photo Upload Box -->
        <div class="bg-emerald-50/50 rounded-xl border border-emerald-200/80 p-6 shadow-xs">
            <h5 class="text-xs font-bold text-emerald-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Unggah Foto ke Galeri Kegiatan Ini</span>
            </h5>
            <form action="{{ route('admin.kegiatans.galeri.store', $kegiatan) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-7">
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">
                            Pilih File Foto (Bisa pilih sekaligus lebih dari satu foto) <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer bg-white p-2 rounded-lg border border-gray-300" required>
                        @error('photos')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('photos.*')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-5">
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">
                            Keterangan / Caption <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="text" name="caption" placeholder="Contoh: Sesi diskusi bersama warga dan pemuda..." class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 p-2.5 bg-white">
                        @error('caption')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center justify-between pt-1">
                    <p class="text-[11px] text-gray-500">Format: JPG, JPEG, PNG, WEBP. Maksimal 4MB per foto.</p>
                    <button type="submit" class="inline-flex items-center gap-1.5 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2 rounded-lg transition shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Unggah Foto</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Photos Grid -->
        @if($kegiatan->galeriFotos->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($kegiatan->galeriFotos as $foto)
                    <div class="group relative bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs hover:shadow-md transition">
                        <a href="{{ asset('storage/' . $foto->file_path) }}" target="_blank" class="block aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->caption ?? $kegiatan->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>

                        <div class="p-2.5">
                            @if($foto->caption)
                                <p class="text-xs text-gray-800 font-medium line-clamp-2 leading-tight" title="{{ $foto->caption }}">
                                    {{ $foto->caption }}
                                </p>
                            @else
                                <p class="text-[11px] text-gray-400 italic">Tanpa keterangan</p>
                            @endif
                            <div class="flex items-center justify-between text-[10px] text-gray-400 mt-2 pt-2 border-t border-gray-100">
                                <span>{{ $foto->created_at->format('d/m/Y') }}</span>
                                <form action="{{ route('admin.galeri-fotos.destroy', $foto) }}" method="POST" onsubmit="return confirm('Hapus foto dokumentasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition">
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-xs font-semibold text-gray-700">Belum ada foto dokumentasi di galeri kegiatan ini.</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Gunakan formulir di atas untuk mengunggah foto kegiatan.</p>
            </div>
        @endif
    </div>

</div>
@endsection
