@extends('layouts.admin')

@section('title', 'Admin PPK Ormawa')

@section('content')
<div class="space-y-6" x-data="{ 
    activeTab: {{ request('tab', $pojoks->first()->id ?? 1) }},
    openEditInfoModal: false,
    editPojokData: { id: null, nama: '', deskripsi_singkat: '' }
}">

    <!-- Flash Alert Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-sm shadow-xs space-y-1">
            <span class="font-bold">Terjadi kesalahan:</span>
            <ul class="list-disc list-inside text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Kelola Halaman PPK Ormawa</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola gambar dokumentasi kegiatan dan modul file unduhan untuk setiap pilar pojok desa.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('public.ppko') }}" target="_blank"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition shadow-xs">
                <span>Lihat Halaman Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>

    <!-- 5 Tab Bar Navigation (1 Tab per Pojok) -->
    <div class="bg-white rounded-2xl border border-[#E2E8F0] p-1.5 shadow-xs overflow-x-auto">
        <div class="flex items-center gap-1.5 min-w-max">
            @foreach($pojoks as $p)
                <button type="button"
                    @click="activeTab = {{ $p->id }}; history.replaceState(null, '', '?tab={{ $p->id }}')"
                    :class="activeTab === {{ $p->id }} 
                        ? 'bg-[#0F4C3A] text-white shadow-xs font-bold' 
                        : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs transition-all cursor-pointer">
                    <span class="w-5 h-5 rounded-lg flex items-center justify-center text-[10px] font-bold shrink-0 transition"
                          :class="activeTab === {{ $p->id }} ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'">
                        {{ $loop->iteration }}
                    </span>
                    <span>{{ $p->nama }}</span>
                    @if($p->kurikulums_count > 0)
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-semibold tabular-nums"
                              :class="activeTab === {{ $p->id }} ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600'">
                            {{ $p->kurikulums_count }} file
                        </span>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <!-- Tab Content Containers -->
    @foreach($pojoks as $pojok)
        <div x-show="activeTab === {{ $pojok->id }}" x-cloak class="space-y-6">

            <!-- 1. Ringkasan Info Pojok -->
            <div class="bg-white p-5 sm:p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                            Pilar 0{{ $loop->iteration }}
                        </span>
                        <h2 class="font-jakarta text-lg font-bold text-[#0F172A]">{{ $pojok->nama }}</h2>
                    </div>
                    <p class="text-xs text-slate-600 max-w-3xl leading-relaxed">{{ $pojok->deskripsi_singkat }}</p>
                </div>
                <button type="button"
                    @click="editPojokData = { id: {{ $pojok->id }}, nama: '{{ addslashes($pojok->nama) }}', deskripsi_singkat: '{{ addslashes($pojok->deskripsi_singkat) }}' }; openEditInfoModal = true"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold transition shrink-0 shadow-xs">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Ubah Nama / Deskripsi</span>
                </button>
            </div>

            <!-- 2. Bagian Gambar yang Ditampilkan (3 Slot) -->
            <div class="bg-white p-5 sm:p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs space-y-4">
                <div>
                    <h3 class="font-jakarta text-base font-bold text-[#0F172A]">Gambar yang Ditampilkan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tersedia 3 slot gambar kegiatan untuk pojok ini. Jika slot belum diisi, akan tampil kotak abu-abu penanda belum diisi.</p>
                </div>

                @php
                    $slots = [
                        1 => [
                            'slot' => 1,
                            'label' => 'Slide 1 (Foto Utama)',
                            'path' => $pojok->gambar,
                            'desc' => $pojok->deskripsi_gambar,
                        ],
                        2 => [
                            'slot' => 2,
                            'label' => 'Slide 2',
                            'path' => $pojok->gambar_2,
                            'desc' => $pojok->deskripsi_gambar_2,
                        ],
                        3 => [
                            'slot' => 3,
                            'label' => 'Slide 3',
                            'path' => $pojok->gambar_3,
                            'desc' => $pojok->deskripsi_gambar_3,
                        ],
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach($slots as $data)
                        <div class="bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0] p-4 flex flex-col justify-between space-y-4"
                             x-data="{ showForm: false }">
                            <div class="space-y-3">
                                <!-- Header Slot -->
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800">{{ $data['label'] }}</span>
                                    @if(!empty($data['path']))
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                            Terisi
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-200 text-slate-600">
                                            Belum diisi
                                        </span>
                                    @endif
                                </div>

                                <!-- Preview Area -->
                                @if(!empty($data['path']))
                                    <div class="space-y-2">
                                        <div class="relative aspect-[16/10] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                            <img src="{{ asset('storage/' . $data['path']) }}" alt="{{ $pojok->nama }}" class="w-full h-full object-cover">
                                        </div>
                                        @if(!empty($data['desc']))
                                            <p class="text-[11px] text-slate-600 line-clamp-2 italic leading-relaxed">“{{ $data['desc'] }}”</p>
                                        @else
                                            <p class="text-[11px] text-slate-400 italic">Tanpa keterangan gambar</p>
                                        @endif
                                    </div>
                                @else
                                    <!-- ABU-ABU PLACEHOLDER: Belum Diisi (Tanpa Gambar Bawaan) -->
                                    <div class="aspect-[16/10] w-full rounded-xl bg-slate-100/90 border-2 border-dashed border-slate-300 flex flex-col items-center justify-center p-4 text-center">
                                        <svg class="w-8 h-8 text-slate-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs font-semibold text-slate-500">Belum diisi</span>
                                        <span class="text-[10px] text-slate-400 mt-0.5">Belum ada gambar kegiatan</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Bar -->
                            <div class="pt-3 border-t border-slate-200/80">
                                @if(!empty($data['path']))
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="showForm = !showForm"
                                            class="flex-1 py-1.5 px-3 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold transition text-center shadow-xs">
                                            <span x-text="showForm ? 'Tutup Form' : 'Ganti / Edit'">Ganti / Edit</span>
                                        </button>
                                        <form action="{{ route('admin.ppko.foto.delete', $pojok) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini? Slot gambar akan menjadi kosong kembali.');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="slot" value="{{ $data['slot'] }}">
                                            <button type="submit" class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus gambar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <button type="button" @click="showForm = !showForm"
                                        class="w-full py-1.5 px-3 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition text-center shadow-xs">
                                        <span x-text="showForm ? 'Tutup Form' : '+ Unggah Gambar'">+ Unggah Gambar</span>
                                    </button>
                                @endif

                                <!-- Collapsible Upload / Edit Form -->
                                <div x-show="showForm" x-cloak class="mt-3 p-3 bg-white rounded-xl border border-slate-200 space-y-3 shadow-xs">
                                    <form action="{{ route('admin.ppko.foto.update', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-2.5">
                                        @csrf
                                        <input type="hidden" name="slot" value="{{ $data['slot'] }}">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">
                                                {{ !empty($data['path']) ? 'Pilih Gambar Baru (Opsional)' : 'Pilih Gambar' }}
                                            </label>
                                            <input type="file" name="foto" accept="image/png,image/jpeg,image/webp" {{ empty($data['path']) ? 'required' : '' }}
                                                class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 text-slate-600">
                                            <span class="text-[10px] text-slate-400 block mt-0.5">JPG, PNG, WEBP. Maks 5MB.</span>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">Keterangan Gambar</label>
                                            <input type="text" name="deskripsi" value="{{ $data['desc'] }}" placeholder="Tuliskan keterangan foto..."
                                                class="w-full text-xs rounded-lg border border-slate-200 px-2.5 py-1.5 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-slate-800">
                                        </div>
                                        <div class="flex items-center justify-end gap-1.5 pt-1">
                                            <button type="button" @click="showForm = false" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-bold text-white bg-[#0F4C3A] hover:bg-[#072C21]">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. Bagian File Dokumen / Modul Unduhan -->
            <div class="bg-white p-5 sm:p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs space-y-4">
                <div>
                    <h3 class="font-jakarta text-base font-bold text-[#0F172A]">File & Modul Unduhan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola dokumen panduan atau kurikulum yang dapat diunduh oleh warga pada pojok ini.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Form Upload File Baru (5 cols) -->
                    <div class="lg:col-span-5 bg-[#F8FAFC] p-4 sm:p-5 rounded-2xl border border-[#E2E8F0] space-y-3">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah File Baru</span>
                        </h4>
                        <form action="{{ route('admin.ppko.file.store', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama / Judul File <span class="text-rose-500">*</span></label>
                                <input type="text" name="judul" required placeholder="Contoh: Modul Pelatihan Kewirausahaan"
                                    class="w-full text-xs rounded-xl border border-slate-200 px-3 py-2 text-slate-900 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat (Opsional)</label>
                                <textarea name="deskripsi" rows="2" placeholder="Keterangan singkat isi dokumen..."
                                    class="w-full text-xs rounded-xl border border-slate-200 px-3 py-2 text-slate-900 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">File Dokumen <span class="text-rose-500">*</span></label>
                                <input type="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                                    class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white file:text-slate-700 hover:file:bg-slate-100 text-slate-600">
                                <span class="text-[10px] text-slate-400 block mt-1">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP. Maks 50MB.</span>
                            </div>
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold transition shadow-xs">
                                Simpan & Unggah File
                            </button>
                        </form>
                    </div>

                    <!-- List File Terunggah (7 cols) -->
                    <div class="lg:col-span-7 bg-[#F8FAFC] p-4 sm:p-5 rounded-2xl border border-[#E2E8F0] space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Daftar File Unduhan</span>
                            </h4>
                            <span class="text-xs text-slate-500 font-semibold">Total: {{ $pojok->kurikulums->count() }} file</span>
                        </div>

                        @if($pojok->kurikulums->isNotEmpty())
                            <div class="divide-y divide-slate-200/70 max-h-[380px] overflow-y-auto pr-1">
                                @foreach($pojok->kurikulums as $file)
                                    <div class="py-3 flex items-start justify-between gap-3 group">
                                        <div class="flex items-start gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-[#0F4C3A] flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <h5 class="text-xs font-bold text-slate-900 leading-snug truncate">{{ $file->judul }}</h5>
                                                @if($file->deskripsi)
                                                    <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $file->deskripsi }}</p>
                                                @endif
                                                <div class="flex items-center gap-2 text-[10px] text-slate-400 mt-1">
                                                    <span>{{ $file->formatted_file_size }}</span>
                                                    <span>•</span>
                                                    <span>{{ $file->created_at->translatedFormat('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 shrink-0">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-[#0F4C3A] hover:bg-white transition" title="Lihat/Unduh File">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.ppko.file.destroy', $file) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-white transition" title="Hapus File">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-8 rounded-xl bg-white border border-dashed border-slate-200 text-center">
                                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-xs text-slate-500 font-medium">Belum ada file unduhan</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Unggah dokumen materi panduan pojok melalui form di sebelah kiri.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    @endforeach

    <!-- MODAL EDIT NAMA & DESKRIPSI SINGKAT POJOK -->
    <div x-show="openEditInfoModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div @click.away="openEditInfoModal = false"
            class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xl max-w-md w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                <h4 class="font-jakarta font-bold text-base text-[#0F172A]">Ubah Informasi Pojok</h4>
                <button type="button" @click="openEditInfoModal = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form :action="'{{ url('admin/ppko') }}/' + editPojokData.id" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-[#1E293B] mb-1">Nama Pojok <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" x-model="editPojokData.nama" required
                        class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 font-semibold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#1E293B] mb-1">Deskripsi Singkat <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi_singkat" rows="3" x-model="editPojokData.deskripsi_singkat" required
                        class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 leading-relaxed"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                    <button type="button" @click="openEditInfoModal = false"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

        <!-- ================================================================= -->
        <!-- BAGIAN: PENGATURAN TABEL DETAIL PROGRAM PPKO (KHUSUS SUPER ADMIN) -->
        <!-- ================================================================= -->
        @if(auth()->user()->isSuperAdmin())
        <div id="kelola-detail-program" x-data="{ openAddModal: false, editItem: null, openEditModal: false }"
            class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#F1F5F9] pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#0F4C3A]"></span>
                        <h3 class="font-jakarta font-bold text-lg text-[#0F172A]">Tabel Detail Program PPKO</h3>
                    </div>
                    <p class="text-xs text-[#64748B] mt-0.5">
                        Kelola data yang tampil pada tabel detail program di halaman publik (bersebelahan dengan bagian
                        Tentang Program).
                    </p>
                </div>
                <button type="button" @click="openAddModal = true"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition shadow-xs shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Baris Detail</span>
                </button>
            </div>

            <!-- Tabel Daftar Detail Program -->
            <div class="overflow-x-auto rounded-xl border border-[#E2E8F0]">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr
                            class="bg-[#F8FAFC] border-b border-[#E2E8F0] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-3.5 w-12 text-center">No</th>
                            <th class="py-3.5 px-3.5 w-20 text-center">Urutan</th>
                            <th class="py-3.5 px-4 w-48 sm:w-56">Aspek / Program</th>
                            <th class="py-3.5 px-4">Keterangan</th>
                            <th class="py-3.5 px-3.5 w-20 text-center">Status</th>
                            <th class="py-3.5 px-3.5 w-28 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9] text-slate-700 bg-white">
                        @forelse($programDetails as $index => $detail)
                            <tr class="hover:bg-[#F8FAFC]/80 transition-colors">
                                <td class="py-3.5 px-3.5 text-center font-semibold text-slate-500 align-top tabular-nums">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-3.5 text-center align-top">
                                    <span
                                        class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] tabular-nums font-semibold">
                                        {{ $detail->urutan }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[#0F172A] align-top">
                                    {{ $detail->aspek }}
                                </td>
                                <td class="py-3.5 px-4 leading-relaxed align-top text-slate-600">
                                    {{ $detail->keterangan }}
                                </td>
                                <td class="py-3.5 px-3.5 text-center align-top">
                                    @if($detail->is_active)
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#DCFCE7] text-[#15803D]">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3.5 text-center align-top">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Tombol Edit -->
                                        <button type="button"
                                            @click="editItem = {{ json_encode($detail) }}; openEditModal = true"
                                            class="p-1.5 rounded-lg text-slate-600 hover:text-[#0F4C3A] hover:bg-slate-100 transition"
                                            title="Edit detail program">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.ppko.detail-program.destroy', $detail) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus baris detail program ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus detail program">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 italic">
                                    Belum ada data detail program. Klik tombol "Tambah Baris Detail" untuk menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MODAL TAMBAH BARIS DETAIL PROGRAM -->
            <div x-show="openAddModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                <div @click.away="openAddModal = false"
                    class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xl max-w-lg w-full p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                        <h4 class="font-jakarta font-bold text-base text-[#0F172A]">Tambah Baris Detail Program</h4>
                        <button type="button" @click="openAddModal = false"
                            class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
                    </div>
                    <form action="{{ route('admin.ppko.detail-program.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Aspek / Program <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" name="aspek" required placeholder="Contoh: Partisipatif & Inklusif"
                                class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Keterangan / Uraian <span
                                    class="text-rose-500">*</span></label>
                            <textarea name="keterangan" rows="4" required
                                placeholder="Tuliskan keterangan detail program secara lengkap..."
                                class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 leading-relaxed"></textarea>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Nomor Urutan</label>
                            <input type="number" name="urutan" value="{{ ($programDetails->max('urutan') ?? 0) + 1 }}"
                                min="0"
                                class="w-24 text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 tabular-nums">
                            <span class="text-[11px] text-slate-400 block mt-1">Urutan tampilan di tabel (angka lebih kecil
                                tampil lebih dulu).</span>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                            <button type="button" @click="openAddModal = false"
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                            <button type="submit"
                                class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-xs">Simpan
                                Baris</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL EDIT BARIS DETAIL PROGRAM -->
            <div x-show="openEditModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                <div @click.away="openEditModal = false"
                    class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xl max-w-lg w-full p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                        <h4 class="font-jakarta font-bold text-base text-[#0F172A]">Edit Baris Detail Program</h4>
                        <button type="button" @click="openEditModal = false"
                            class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
                    </div>
                    <form :action="'{{ url('admin/ppko/detail-program') }}/' + (editItem ? editItem.id : '')" method="POST"
                        class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Aspek / Program <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" name="aspek" x-model="editItem.aspek" required
                                class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Keterangan / Uraian <span
                                    class="text-rose-500">*</span></label>
                            <textarea name="keterangan" rows="4" x-model="editItem.keterangan" required
                                class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 leading-relaxed"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Nomor Urutan</label>
                                <input type="number" name="urutan" x-model="editItem.urutan" min="0"
                                    class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 tabular-nums">
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Status Tampil</label>
                                <select name="is_active" x-model="editItem.is_active"
                                    class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900">
                                    <option :value="1">Aktif (Tampil)</option>
                                    <option :value="0">Nonaktif (Sembunyikan)</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                            <button type="button" @click="openEditModal = false"
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                            <button type="submit"
                                class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-xs">Perbarui
                                Baris</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        @endif

    </div>
@endsection