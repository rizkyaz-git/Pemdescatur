@extends('layouts.admin')

@section('title', 'PPK Ormawa')

@section('content')
<div class="space-y-6" x-data="{ 
    activeTab: {{ request('tab', $pojoks->first()->id ?? 1) }},
    openEditInfoModal: false,
    editPojokData: { id: null, nama: '', deskripsi_singkat: '' }
}">

    <!-- 1. Page Header (Standard Admin Typography: font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-1">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Kelola Halaman PPK Ormawa</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola konten dan informasi program PPK Ormawa Desa Catur.</p>
        </div>
        <a href="{{ route('public.ppko') }}" target="_blank"
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-white hover:bg-[#F4F6F5] text-[#0F4C3A] hover:text-[#072C21] text-xs font-semibold border border-[#DDE5E1] transition shadow-2xs shrink-0 cursor-pointer">
            <span>Lihat Halaman Publik</span>
            <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>
    </div>

    <!-- 2. Flat Category Tabs Strip (Standard Admin Density & Styling) -->
    <div class="flex items-center gap-1.5 overflow-x-auto custom-scrollbar pb-1 border-b border-[#DDE5E1]">
        @foreach($pojoks as $p)
            <button type="button"
                @click="activeTab = {{ $p->id }}; history.replaceState(null, '', '?tab={{ $p->id }}')"
                :class="activeTab === {{ $p->id }} 
                    ? 'bg-[#0F4C3A] text-white font-semibold shadow-2xs' 
                    : 'text-[#607089] hover:text-[#0F4C3A] hover:bg-[#E6F4EE] font-medium'"
                class="px-3.5 py-1.5 text-xs rounded-lg whitespace-nowrap transition-colors cursor-pointer">
                <span>{{ $p->nama }}</span>
            </button>
        @endforeach
    </div>

    <!-- 3. Tab Content Containers (Per-Pojok Management) -->
    @foreach($pojoks as $pojok)
        <div x-show="activeTab === {{ $pojok->id }}" x-cloak class="space-y-6">

            <!-- 3.1 Section Ringkasan & Deskripsi Pojok (White Container, Subtle Border, Clean Typography) -->
            <div class="bg-white rounded-[12px] border border-[#DDE5E1] p-5 sm:p-6 space-y-3.5 shadow-2xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#F1F5F9]">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0F4C3A]"></span>
                        <h2 class="font-jakarta font-bold text-base sm:text-lg text-[#10233F]">{{ $pojok->nama }}</h2>
                    </div>
                    <button type="button"
                        @click="editPojokData = { id: {{ $pojok->id }}, nama: {{ json_encode($pojok->nama) }}, deskripsi_singkat: {{ json_encode($pojok->deskripsi_singkat) }} }; openEditInfoModal = true"
                        class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg border border-[#DDE5E1] text-[#0F4C3A] hover:bg-[#E6F4EE] hover:border-[#0F4C3A]/30 text-xs font-semibold transition shrink-0 cursor-pointer shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Edit Informasi</span>
                    </button>
                </div>

                <!-- Deskripsi Program: Sanitized Rich Text Rendering with Paragraph Spacing -->
                <div class="text-xs sm:text-[13px] text-[#607089] leading-relaxed max-w-4xl space-y-2 [&_p]:leading-relaxed [&_p]:mb-2 last:[&_p]:mb-0 [&_strong]:text-[#10233F] [&_strong]:font-semibold [&_em]:italic [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5 [&_a]:text-[#0F4C3A] [&_a]:underline">
                    {!! \App\Helpers\HtmlPurifierHelper::clean($pojok->deskripsi_singkat) !!}
                </div>
            </div>

            <!-- 3.2 Section Gambar yang Ditampilkan (3 Slide) -->
            <div class="bg-white p-5 sm:p-6 rounded-[12px] border border-[#DDE5E1] shadow-2xs space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0F4C3A]"></span>
                        <h3 class="font-jakarta font-bold text-base text-[#10233F]">Gambar yang Ditampilkan</h3>
                    </div>
                    <span class="text-xs text-[#607089]">3 Slide Gambar</span>
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                    @foreach($slots as $data)
                        <div class="bg-[#F7F9F8] rounded-[10px] border border-[#DDE5E1] p-3.5 flex flex-col justify-between space-y-3"
                             x-data="{ showForm: false }">
                            <div class="space-y-2.5">
                                <!-- Header Slot -->
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold text-[#10233F]">{{ $data['label'] }}</span>
                                    @if(!empty($data['path']))
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#DCFCE7] text-[#15803D]">
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
                                    <div class="space-y-1.5">
                                        <div class="relative aspect-[16/10] w-full rounded-lg overflow-hidden bg-slate-100 border border-[#DDE5E1]">
                                            <img src="{{ asset('storage/' . $data['path']) }}" alt="{{ $pojok->nama }}" class="w-full h-full object-cover">
                                        </div>
                                        @if(!empty($data['desc']))
                                            <p class="text-[11px] text-[#607089] line-clamp-2 italic leading-relaxed">“{{ $data['desc'] }}”</p>
                                        @else
                                            <p class="text-[11px] text-slate-400 italic">Tanpa keterangan gambar</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="aspect-[16/10] w-full rounded-lg bg-white border border-dashed border-[#DDE5E1] flex flex-col items-center justify-center p-3 text-center">
                                        <svg class="w-7 h-7 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs font-medium text-slate-500">Belum diisi</span>
                                        <span class="text-[10px] text-slate-400">Belum ada gambar kegiatan</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Bar -->
                            <div class="pt-2.5 border-t border-[#DDE5E1]">
                                @if(!empty($data['path']))
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="showForm = !showForm"
                                            class="flex-1 h-9 px-3 rounded-lg bg-white hover:bg-slate-50 border border-[#DDE5E1] text-[#10233F] text-xs font-semibold transition text-center shadow-2xs cursor-pointer">
                                            <span x-text="showForm ? 'Tutup Form' : 'Ganti / Edit'">Ganti / Edit</span>
                                        </button>
                                        <form action="{{ route('admin.ppko.foto.delete', $pojok) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini? Slot gambar akan menjadi kosong kembali.');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="slot" value="{{ $data['slot'] }}">
                                            <button type="submit" class="h-9 w-9 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 flex items-center justify-center transition cursor-pointer shadow-2xs" title="Hapus gambar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <button type="button" @click="showForm = !showForm"
                                        class="w-full h-9 px-3 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition text-center shadow-2xs cursor-pointer">
                                        <span x-text="showForm ? 'Tutup Form' : '+ Unggah Gambar'">+ Unggah Gambar</span>
                                    </button>
                                @endif

                                <!-- Collapsible Upload / Edit Form -->
                                <div x-show="showForm" x-cloak class="mt-2.5 p-3 bg-white rounded-lg border border-[#DDE5E1] space-y-2.5 shadow-2xs">
                                    <form action="{{ route('admin.ppko.foto.update', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-2.5">
                                        @csrf
                                        <input type="hidden" name="slot" value="{{ $data['slot'] }}">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-[#10233F] mb-1">
                                                {{ !empty($data['path']) ? 'Pilih Gambar Baru' : 'Pilih Gambar' }}
                                            </label>
                                            <input type="file" name="foto" accept="image/png,image/jpeg,image/webp" {{ empty($data['path']) ? 'required' : '' }}
                                                class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 text-[#607089]">
                                            <span class="text-[10px] text-slate-400 block mt-0.5">JPG, PNG, WEBP. Maks 5MB.</span>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-[#10233F] mb-1">Keterangan Gambar</label>
                                            <input type="text" name="deskripsi" value="{{ $data['desc'] }}" placeholder="Keterangan gambar..."
                                                class="w-full text-xs rounded-lg border border-[#DDE5E1] px-2.5 py-1.5 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] text-slate-900 bg-white">
                                        </div>
                                        <div class="flex items-center justify-end gap-1.5 pt-1">
                                            <button type="button" @click="showForm = false" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-500 hover:bg-slate-100 cursor-pointer">Batal</button>
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-semibold text-white bg-[#0F4C3A] hover:bg-[#072C21] cursor-pointer">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3.3 Section File Dokumen / Modul Unduhan -->
            <div class="bg-white p-5 sm:p-6 rounded-[12px] border border-[#DDE5E1] shadow-2xs space-y-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0F4C3A]"></span>
                        <h3 class="font-jakarta font-bold text-base text-[#10233F]">File & Modul Unduhan</h3>
                    </div>
                    <p class="text-xs text-[#607089] mt-0.5">Kelola dokumen panduan atau kurikulum yang dapat diunduh oleh warga pada pojok ini.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                    <!-- Form Upload File Baru (5 cols) -->
                    <div class="lg:col-span-5 bg-[#F7F9F8] p-4 sm:p-5 rounded-[10px] border border-[#DDE5E1] space-y-3">
                        <h4 class="text-xs font-bold text-[#10233F] uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah File Baru</span>
                        </h4>
                        <form action="{{ route('admin.ppko.file.store', $pojok) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-[#10233F] mb-1">Nama / Judul File <span class="text-rose-500">*</span></label>
                                <input type="text" name="judul" required placeholder="Contoh: Modul Pelatihan Kewirausahaan"
                                    class="w-full h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 text-slate-900 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-[#10233F] mb-1">Deskripsi Singkat (Opsional)</label>
                                <textarea name="deskripsi" rows="2" placeholder="Keterangan singkat isi dokumen..."
                                    class="w-full text-xs rounded-lg border border-[#DDE5E1] p-2.5 text-slate-900 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white leading-relaxed"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-[#10233F] mb-1">File Dokumen <span class="text-rose-500">*</span></label>
                                <input type="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                                    class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white file:text-slate-700 hover:file:bg-slate-100 text-[#607089]">
                                <span class="text-[10px] text-slate-400 block mt-1">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP. Maks 50MB.</span>
                            </div>
                            <button type="submit" class="w-full h-10 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition shadow-2xs cursor-pointer">
                                Simpan & Unggah File
                            </button>
                        </form>
                    </div>

                    <!-- List File Terunggah (7 cols) -->
                    <div class="lg:col-span-7 bg-[#F7F9F8] p-4 sm:p-5 rounded-[10px] border border-[#DDE5E1] space-y-3">
                        <div class="flex items-center justify-between border-b border-[#DDE5E1] pb-2">
                            <h4 class="text-xs font-bold text-[#10233F] uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Daftar File Unduhan</span>
                            </h4>
                            <span class="text-xs text-[#607089] font-medium">Total: {{ $pojok->kurikulums->count() }} file</span>
                        </div>

                        @if($pojok->kurikulums->isNotEmpty())
                            <div class="divide-y divide-[#DDE5E1] max-h-[380px] overflow-y-auto pr-1">
                                @foreach($pojok->kurikulums as $file)
                                    <div class="py-2.5 flex items-start justify-between gap-3 group">
                                        <div class="flex items-start gap-2.5 min-w-0">
                                            <div class="w-7 h-7 rounded-lg bg-white border border-[#DDE5E1] text-[#0F4C3A] flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <h5 class="text-xs font-semibold text-[#10233F] leading-snug truncate">{{ $file->judul }}</h5>
                                                @if($file->deskripsi)
                                                    <p class="text-[11px] text-[#607089] line-clamp-1 mt-0.5">{{ $file->deskripsi }}</p>
                                                @endif
                                                <div class="flex items-center gap-2 text-[10px] text-slate-400 mt-0.5">
                                                    <span>{{ $file->formatted_file_size }}</span>
                                                    <span>•</span>
                                                    <span>{{ $file->created_at->translatedFormat('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="p-1.5 rounded-lg border border-[#DDE5E1] bg-white text-[#0F4C3A] hover:bg-[#E6F4EE] transition shadow-2xs" title="Unduh File">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.ppko.file.destroy', $file) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg border border-rose-200 bg-white text-rose-600 hover:bg-rose-50 transition shadow-2xs cursor-pointer" title="Hapus File">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-7 rounded-lg bg-white border border-dashed border-[#DDE5E1] text-center">
                                <svg class="w-7 h-7 text-slate-300 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-xs text-[#607089] font-medium">Belum ada file unduhan</p>
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
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
        x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="openEditInfoModal = false"
            class="bg-white rounded-[12px] border border-[#DDE5E1] shadow-xl max-w-md w-full p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                <h4 class="font-jakarta font-bold text-base text-[#10233F]">Ubah Informasi Pojok</h4>
                <button type="button" @click="openEditInfoModal = false" class="text-slate-400 hover:text-slate-600 transition cursor-pointer text-lg">&times;</button>
            </div>
            <form :action="'{{ url('admin/ppko') }}/' + editPojokData.id" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-[#10233F] mb-1">Nama Pojok <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" x-model="editPojokData.nama" required
                        class="w-full h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F] font-semibold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#10233F] mb-1">Deskripsi Singkat <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi_singkat" rows="5" x-model="editPojokData.deskripsi_singkat" required
                        class="w-full text-xs rounded-lg border border-[#DDE5E1] p-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F] leading-relaxed"></textarea>
                    <span class="text-[11px] text-[#607089] block mt-1">Dapat berupa teks terformat atau ringkasan kegiatan program.</span>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                    <button type="button" @click="openEditInfoModal = false"
                        class="h-9 px-3.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer">Batal</button>
                    <button type="submit"
                        class="h-9 px-4 rounded-lg text-xs font-semibold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-2xs cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- BAGIAN: PENGATURAN TABEL DETAIL PROGRAM PPKO (KHUSUS SUPER ADMIN) -->
    <!-- ================================================================= -->
    @if(auth()->user()->isSuperAdmin())
    <div id="kelola-detail-program" x-data="{ openAddModal: false, editItem: null, openEditModal: false }"
        class="bg-white rounded-[12px] border border-[#DDE5E1] shadow-2xs p-5 sm:p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#F1F5F9]">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#0F4C3A]"></span>
                    <h3 class="font-jakarta font-bold text-base text-[#10233F]">Tabel Detail Program PPKO</h3>
                </div>
                <p class="text-xs text-[#607089] mt-0.5">
                    Kelola data yang tampil pada tabel detail program di halaman publik (bersebelahan dengan bagian Tentang Program).
                </p>
            </div>
            <button type="button" @click="openAddModal = true"
                class="inline-flex items-center gap-1.5 h-9 px-3.5 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition shadow-2xs shrink-0 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Baris Detail</span>
            </button>
        </div>

        <!-- Tabel Daftar Detail Program -->
        <div class="overflow-x-auto rounded-lg border border-[#DDE5E1]">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F7F9F8] border-b border-[#DDE5E1] text-[#607089] text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="py-3 px-3 w-20 text-center">Urutan</th>
                        <th class="py-3 px-4 w-48 sm:w-56">Aspek / Program</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-3 w-20 text-center">Status</th>
                        <th class="py-3 px-3 w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9] text-slate-700 bg-white">
                    @forelse($programDetails as $index => $detail)
                        <tr class="hover:bg-[#F7F9F8] transition-colors">
                            <td class="py-3 px-3 text-center font-medium text-slate-500 align-middle tabular-nums">
                                {{ $loop->iteration }}
                            </td>
                            <td class="py-3 px-3 text-center align-middle">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-mono text-[11px] tabular-nums font-semibold">
                                    {{ $detail->urutan }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-[#10233F] align-middle">
                                {{ $detail->aspek }}
                            </td>
                            <td class="py-3 px-4 leading-relaxed align-middle text-[#607089] text-xs">
                                {{ $detail->keterangan }}
                            </td>
                            <td class="py-3 px-3 text-center align-middle">
                                @if($detail->is_active)
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#DCFCE7] text-[#15803D]">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-center align-middle">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <!-- Tombol Edit -->
                                    <button type="button"
                                        @click="editItem = {{ json_encode($detail) }}; openEditModal = true"
                                        class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-[#DDE5E1] text-xs font-semibold text-[#0F4C3A] hover:bg-[#F4F6F5] hover:border-[#0F4C3A]/30 transition shadow-2xs cursor-pointer"
                                        title="Edit detail program">
                                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.ppko.detail-program.destroy', $detail) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus baris detail program ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-rose-200 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition shadow-2xs cursor-pointer"
                                            title="Hapus detail program">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <td colspan="6" class="py-8 text-center text-[#607089] italic">
                                Belum ada data detail program. Klik tombol "Tambah Baris Detail" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MODAL TAMBAH BARIS DETAIL PROGRAM -->
        <div x-show="openAddModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.away="openAddModal = false"
                class="bg-white rounded-[12px] border border-[#DDE5E1] shadow-xl max-w-lg w-full p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                    <h4 class="font-jakarta font-bold text-base text-[#10233F]">Tambah Baris Detail Program</h4>
                    <button type="button" @click="openAddModal = false"
                        class="text-slate-400 hover:text-slate-600 transition cursor-pointer text-lg">&times;</button>
                </div>
                <form action="{{ route('admin.ppko.detail-program.store') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-[#10233F] mb-1">Aspek / Program <span class="text-rose-500">*</span></label>
                        <input type="text" name="aspek" required placeholder="Contoh: Partisipatif & Inklusif"
                            class="w-full h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#10233F] mb-1">Keterangan / Uraian <span class="text-rose-500">*</span></label>
                        <textarea name="keterangan" rows="3" required
                            placeholder="Tuliskan keterangan detail program secara lengkap..."
                            class="w-full text-xs rounded-lg border border-[#DDE5E1] p-2.5 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F] leading-relaxed"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#10233F] mb-1">Nomor Urutan</label>
                        <input type="number" name="urutan" value="{{ ($programDetails->max('urutan') ?? 0) + 1 }}" min="0"
                            class="w-24 h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F] tabular-nums">
                        <span class="text-[10px] text-[#607089] block mt-1">Urutan tampilan di tabel (angka lebih kecil tampil lebih dulu).</span>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                        <button type="button" @click="openAddModal = false"
                            class="h-9 px-3.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer">Batal</button>
                        <button type="submit"
                            class="h-9 px-4 rounded-lg text-xs font-semibold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-2xs cursor-pointer">Simpan Baris</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDIT BARIS DETAIL PROGRAM -->
        <div x-show="openEditModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.away="openEditModal = false"
                class="bg-white rounded-[12px] border border-[#DDE5E1] shadow-xl max-w-lg w-full p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                    <h4 class="font-jakarta font-bold text-base text-[#10233F]">Edit Baris Detail Program</h4>
                    <button type="button" @click="openEditModal = false"
                        class="text-slate-400 hover:text-slate-600 transition cursor-pointer text-lg">&times;</button>
                </div>
                <form :action="'{{ url('admin/ppko/detail-program') }}/' + (editItem ? editItem.id : '')" method="POST"
                    class="space-y-3.5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-[#10233F] mb-1">Aspek / Program <span class="text-rose-500">*</span></label>
                        <input type="text" name="aspek" x-model="editItem.aspek" required
                            class="w-full h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#10233F] mb-1">Keterangan / Uraian <span class="text-rose-500">*</span></label>
                        <textarea name="keterangan" rows="3" x-model="editItem.keterangan" required
                            class="w-full text-xs rounded-lg border border-[#DDE5E1] p-2.5 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F] leading-relaxed"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-semibold text-[#10233F] mb-1">Nomor Urutan</label>
                            <input type="number" name="urutan" x-model="editItem.urutan" min="0"
                                class="w-full h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F] tabular-nums">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#10233F] mb-1">Status Tampil</label>
                            <select name="is_active" x-model="editItem.is_active"
                                class="w-full h-10 text-xs rounded-lg border border-[#DDE5E1] px-3 focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] bg-white text-[#10233F]">
                                <option :value="1">Aktif (Tampil)</option>
                                <option :value="0">Nonaktif (Sembunyikan)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                        <button type="button" @click="openEditModal = false"
                            class="h-9 px-3.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer">Batal</button>
                        <button type="submit"
                            class="h-9 px-4 rounded-lg text-xs font-semibold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-2xs cursor-pointer">Perbarui Baris</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @endif

</div>
@endsection