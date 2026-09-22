@extends('layouts.admin')

@section('title', 'Perangkat Desa')

@section('content')
<div class="space-y-5" x-data="{ 
    toastMessage: '', 
    showToast: false, 
    isSaving: false,
    hasChanges: false,
    triggerToast(msg) { 
        this.toastMessage = msg; 
        this.showToast = true; 
        setTimeout(() => this.showToast = false, 3500); 
    },
    saveOrder() {
        const el = document.getElementById('sortable-officials');
        if (!el) return;
        const rows = Array.from(el.querySelectorAll('tr[data-id]'));
        const orderIds = rows.map(r => parseInt(r.getAttribute('data-id'))).filter(Boolean);
        if (orderIds.length === 0) return;

        this.isSaving = true;
        fetch('{{ Route::has('admin.officials.reorder') ? route('admin.officials.reorder') : url('/kelola/officials/reorder') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order: orderIds })
        })
        .then(response => response.json())
        .then(data => {
            this.isSaving = false;
            if (data.success) {
                this.hasChanges = false;
                this.triggerToast(data.message || 'Urutan susunan perangkat desa berhasil diperbarui!');
            } else {
                alert(data.message || 'Gagal menyimpan urutan perangkat desa.');
            }
        })
        .catch(err => {
            this.isSaving = false;
            console.error('Reorder error:', err);
            alert('Terjadi kesalahan saat menyimpan urutan. Silakan coba lagi.');
        });
    }
}">
    
    <!-- Toast Feedback Message for Reorder -->
    <div x-show="showToast" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-6 right-6 z-50 bg-[#0F4C3A] text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-xl flex items-center gap-2 border border-emerald-600/40">
        <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        <span x-text="toastMessage"></span>
    </div>

    {{-- 1. Page Header & Action Group --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Perangkat Desa</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola susunan aparatur desa dan urutkan perangkat sesuai struktur organisasi.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0 flex-wrap self-start sm:self-auto">
            <!-- Secondary Action: Perbarui Urutan -->
            <button type="button" 
                    @click="saveOrder()" 
                    :disabled="isSaving"
                    class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200 text-xs font-semibold px-3 py-2 rounded-lg shadow-2xs transition cursor-pointer disabled:opacity-60"
                    title="Simpan susunan urutan perangkat desa">
                <svg class="w-3.5 h-3.5 text-slate-500" :class="{ 'animate-spin': isSaving }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <template x-if="!isSaving">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </template>
                    <template x-if="isSaving">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </template>
                </svg>
                <span x-text="isSaving ? 'Menyimpan...' : 'Perbarui Urutan'">Perbarui Urutan</span>
                <span x-show="hasChanges" x-cloak class="inline-block w-2 h-2 rounded-full bg-amber-400"></span>
            </button>

            <!-- Tertiary Action: Pratinjau Publik -->
            <a href="{{ route('public.officials') }}" target="_blank" 
               class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 border border-slate-200 text-xs font-semibold px-3 py-2 rounded-lg shadow-2xs transition cursor-pointer"
               title="Buka Halaman Struktur Organisasi Publik">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span class="hidden sm:inline">Lihat Publik</span>
            </a>

            <!-- Primary Action: Tambah Perangkat Desa -->
            <a href="{{ route('admin.officials.create') }}" 
               class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Perangkat</span>
            </a>
        </div>
    </div>

    {{-- 2. Data Table Container (Harmonisasi dengan Kelola Berita) --}}
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200/80">
                        <th scope="col" class="w-20 px-4 py-3 text-center align-middle whitespace-nowrap">Urutan</th>
                        <th scope="col" class="w-16 px-4 py-3 align-middle whitespace-nowrap">Foto</th>
                        <th scope="col" class="px-4 py-3 align-middle min-w-[220px]">Nama Lengkap &amp; Gelar</th>
                        <th scope="col" class="px-4 py-3 align-middle min-w-[180px]">Jabatan</th>
                        <th scope="col" class="w-36 px-4 py-3 text-right align-middle whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-officials" class="divide-y divide-slate-100 bg-white">
                    @forelse($officials as $off)
                        <tr data-id="{{ $off->id }}" class="hover:bg-slate-50/70 transition-colors group">
                            <td class="w-20 px-4 py-3 text-center align-middle cursor-grab active:cursor-grabbing text-slate-400 group-hover:text-slate-600 drag-handle" title="Tarik baris ini untuk mengatur urutan">
                                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-slate-100 group-hover:bg-emerald-50 border border-slate-200 group-hover:border-emerald-200 text-slate-700 group-hover:text-[#0F4C3A] font-bold text-xs select-none transition-colors">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#0F4C3A] pointer-events-none shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-12a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"/>
                                    </svg>
                                    <span class="row-order-num">#{{ $loop->iteration }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                @if($off->photo_path)
                                    <img src="{{ asset('storage/' . $off->photo_path) }}" alt="{{ $off->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-2xs">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-emerald-50 text-[#0F4C3A] font-bold text-xs flex items-center justify-center border border-emerald-200">
                                        {{ strtoupper(substr($off->name, 0, 2)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <a href="{{ route('admin.officials.edit', $off->id) }}" class="font-semibold text-slate-900 hover:text-[#0F4C3A] text-xs sm:text-sm block transition-colors">
                                    {{ $off->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                    {{ $off->position }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.officials.edit', $off->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-[#0F4C3A] hover:border-[#0F4C3A]/30 hover:bg-slate-50 transition shadow-2xs"
                                       title="Edit Perangkat">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin.officials.destroy', $off->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition shadow-2xs cursor-pointer"
                                                title="Hapus Perangkat">
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-xs font-semibold text-slate-800">Belum ada data perangkat desa</p>
                                <p class="text-xs text-slate-400 mt-0.5">Tambahkan aparatur desa pertama melalui tombol di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Summary --}}
        @if($officials->count() > 0)
            <div class="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                <p>
                    Menampilkan total <span class="font-medium text-slate-700">{{ $officials->count() }}</span> perangkat desa
                </p>
                <p class="text-[11px] text-slate-400 hidden sm:block">
                    Tarik baris tabel untuk mengubah urutan struktur
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('sortable-officials');
        if (el) {
            Sortable.create(el, {
                handle: '.drag-handle',
                animation: 200,
                ghostClass: 'bg-emerald-50/80',
                chosenClass: 'bg-emerald-100/60',
                onEnd: function () {
                    // Update nomor urut visual di tabel secara instan
                    const rows = Array.from(el.querySelectorAll('tr[data-id]'));
                    rows.forEach((row, index) => {
                        const badge = row.querySelector('.row-order-num');
                        if (badge) {
                            badge.textContent = '#' + (index + 1);
                        }
                    });

                    // Update state Alpine bahwa ada perubahan urutan dan jalankan penyimpanan
                    const alpineRoot = document.querySelector('[x-data]');
                    if (alpineRoot && window.Alpine) {
                        const alpineData = Alpine.$data(alpineRoot);
                        if (alpineData) {
                            alpineData.hasChanges = true;
                            alpineData.saveOrder();
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
