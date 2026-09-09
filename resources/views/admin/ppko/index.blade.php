@extends('layouts.admin')

@section('title', 'Admin PPKO – Kelola 5 Pojok & File Unduhan')

@section('content')
<div class="space-y-6">

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

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#D9B85C]/20 text-[#7A5A00] border border-[#D9B85C]/30 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>PPKO Catur Cerdas</span>
            </div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Kelola 5 Pilar Pojok PPKO & Modul Unduhan</h1>
            <p class="text-xs text-[#64748B] mt-1">Kelola foto sampul katalog pojok, file modul unduhan kurikulum, serta tabel rincian detail program PPKO.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('public.ppko') }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition shadow-xs">
                <span>Lihat Halaman Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- 5 Pojok Showcase Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $defaultImages = [
                1 => asset('images/mental_kesehatan.png'),
                2 => asset('images/edukasi_anak.png'),
                3 => asset('images/umkm_digital.png'),
                4 => asset('images/karang_taruna.png'),
                5 => asset('images/sawah_irigasi.png'),
            ];
        @endphp

        @foreach($pojoks as $index => $pojok)
            @php
                $hasCustomPhoto = !empty($pojok->gambar);
                $coverPhoto = $hasCustomPhoto ? asset('storage/' . $pojok->gambar) : ($defaultImages[$pojok->id] ?? asset('images/cover_ppko.png'));
            @endphp
            <div class="bg-white rounded-[20px] border border-[#E2E8F0] overflow-hidden shadow-xs hover:shadow-md hover:border-[#0F4C3A]/30 transition-all flex flex-col justify-between group">
                <div>
                    <!-- Photo Header Container -->
                    <div class="relative w-full aspect-[16/9] bg-slate-100 overflow-hidden">
                        <img src="{{ $coverPhoto }}" 
                             alt="{{ $pojok->nama }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        <!-- Badges on Photo -->
                        <div class="absolute top-3 left-3 flex items-center gap-1.5">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-md text-slate-800 shadow-xs border border-white/40 uppercase tracking-wider">
                                Pilar 0{{ $index + 1 }}
                            </span>
                            @if($hasCustomPhoto)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#0F4C3A] text-white shadow-xs">
                                    ✓ Foto Kustom
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-slate-900/75 backdrop-blur-md text-slate-200 shadow-xs">
                                    Foto Bawaan
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 space-y-3">
                        <div>
                            <h4 class="font-jakarta font-bold text-base text-[#0F172A] leading-snug">
                                {{ $pojok->nama }}
                            </h4>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1 line-clamp-2">
                                {{ $pojok->deskripsi_singkat }}
                            </p>
                        </div>

                        <!-- File Unduhan Summary -->
                        <div class="pt-3 border-t border-[#F1F5F9]">
                            <div class="flex items-center justify-between text-xs mb-2">
                                <span class="font-semibold text-slate-700 flex items-center gap-1.5 text-xs">
                                    <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>File Unduhan ({{ $pojok->kurikulums_count }})</span>
                                </span>
                            </div>

                            @if($pojok->kurikulums->isNotEmpty())
                                <div class="space-y-1.5">
                                    @foreach($pojok->kurikulums->take(2) as $file)
                                        <div class="flex items-center gap-2 p-2 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] text-xs">
                                            <svg class="w-4 h-4 text-[#0F4C3A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <div class="min-w-0 flex-1">
                                                <span class="font-semibold text-slate-800 truncate block">{{ $file->judul }}</span>
                                                <span class="text-[10px] text-slate-400 block">{{ $file->formatted_file_size }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($pojok->kurikulums->count() > 2)
                                        <span class="text-[11px] text-slate-400 font-medium block pl-1">+{{ $pojok->kurikulums->count() - 2 }} file lainnya</span>
                                    @endif
                                </div>
                            @else
                                <div class="p-2.5 rounded-xl bg-[#F8FAFC] border border-dashed border-[#E2E8F0] text-center">
                                    <p class="text-[11px] text-slate-400 italic">Belum ada file unduhan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Footer Action -->
                <div class="p-5 pt-0">
                    <a href="{{ route('admin.ppko.edit', $pojok) }}" class="w-full flex items-center justify-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white font-semibold text-xs py-2.5 px-4 rounded-xl transition shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Kelola Foto & Modul Unduhan</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ================================================================= -->
    <!-- BAGIAN: PENGATURAN TABEL DETAIL PROGRAM PPKO                      -->
    <!-- ================================================================= -->
    <div id="kelola-detail-program" x-data="{ openAddModal: false, editItem: null, openEditModal: false }" class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#F1F5F9] pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#0F4C3A]"></span>
                    <h3 class="font-jakarta font-bold text-lg text-[#0F172A]">Tabel Detail Program PPKO</h3>
                </div>
                <p class="text-xs text-[#64748B] mt-0.5">
                    Kelola data yang tampil pada tabel detail program di halaman publik (bersebelahan dengan bagian Tentang Program).
                </p>
            </div>
            <button type="button" 
                    @click="openAddModal = true" 
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold transition shadow-xs shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Baris Detail</span>
            </button>
        </div>

        <!-- Tabel Daftar Detail Program -->
        <div class="overflow-x-auto rounded-xl border border-[#E2E8F0]">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
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
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] tabular-nums font-semibold">
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
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#DCFCE7] text-[#15803D]">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
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
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.ppko.detail-program.destroy', $detail) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus baris detail program ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus detail program">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
        <div x-show="openAddModal" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.away="openAddModal = false" 
                 class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xl max-w-lg w-full p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                    <h4 class="font-jakarta font-bold text-base text-[#0F172A]">Tambah Baris Detail Program</h4>
                    <button type="button" @click="openAddModal = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
                </div>
                <form action="{{ route('admin.ppko.detail-program.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Aspek / Program <span class="text-rose-500">*</span></label>
                        <input type="text" name="aspek" required placeholder="Contoh: Partisipatif & Inklusif" class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Keterangan / Uraian <span class="text-rose-500">*</span></label>
                        <textarea name="keterangan" rows="4" required placeholder="Tuliskan keterangan detail program secara lengkap..." class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 leading-relaxed"></textarea>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Nomor Urutan</label>
                        <input type="number" name="urutan" value="{{ ($programDetails->max('urutan') ?? 0) + 1 }}" min="0" class="w-24 text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 tabular-nums">
                        <span class="text-[11px] text-slate-400 block mt-1">Urutan tampilan di tabel (angka lebih kecil tampil lebih dulu).</span>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                        <button type="button" @click="openAddModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-xs">Simpan Baris</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDIT BARIS DETAIL PROGRAM -->
        <div x-show="openEditModal" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.away="openEditModal = false" 
                 class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xl max-w-lg w-full p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                    <h4 class="font-jakarta font-bold text-base text-[#0F172A]">Edit Baris Detail Program</h4>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
                </div>
                <form :action="'{{ url('admin/ppko/detail-program') }}/' + (editItem ? editItem.id : '')" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Aspek / Program <span class="text-rose-500">*</span></label>
                        <input type="text" name="aspek" x-model="editItem.aspek" required class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Keterangan / Uraian <span class="text-rose-500">*</span></label>
                        <textarea name="keterangan" rows="4" x-model="editItem.keterangan" required class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 leading-relaxed"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Nomor Urutan</label>
                            <input type="number" name="urutan" x-model="editItem.urutan" min="0" class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900 tabular-nums">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1E293B] mb-1">Status Tampil</label>
                            <select name="is_active" x-model="editItem.is_active" class="w-full text-xs rounded-xl border border-[#E2E8F0] px-3.5 py-2.5 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] bg-[#F8FAFC]/40 text-slate-900">
                                <option :value="1">Aktif (Tampil)</option>
                                <option :value="0">Nonaktif (Sembunyikan)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F1F5F9]">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0F4C3A] hover:bg-[#072C21] transition shadow-xs">Perbarui Baris</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
