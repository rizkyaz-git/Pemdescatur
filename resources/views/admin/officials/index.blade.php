@extends('layouts.admin')

@section('title', 'Kelola Perangkat Desa')

@section('content')
<div class="space-y-6" x-data="{ toastMessage: '', showToast: false, triggerToast(msg) { this.toastMessage = msg; this.showToast = true; setTimeout(() => this.showToast = false, 3000); } }">
    
    <!-- Toast Feedback Message for Reorder -->
    <div x-show="showToast" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-6 right-6 z-50 bg-emerald-700 text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        <span x-text="toastMessage"></span>
    </div>

    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Perangkat Desa</h1>
            <p class="text-xs text-[#64748B] mt-1">Kelola daftar aparatur desa dan jabatan. Atur urutan tampilan struktur dengan menarik dan melepas (drag and drop) baris tabel.</p>
        </div>
        <a href="{{ route('admin.officials.create') }}" class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Perangkat Desa</span>
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                        <th class="w-12 px-3 py-3.5 text-center">
                            <span class="sr-only">Urutan</span>
                        </th>
                        <th class="px-5 py-3.5">Foto</th>
                        <th class="px-5 py-3.5">Nama Lengkap & Gelar</th>
                        <th class="px-5 py-3.5">Jabatan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-officials" class="divide-y divide-[#F1F5F9]">
                    @forelse($officials as $off)
                        <tr data-id="{{ $off->id }}" class="hover:bg-[#F8FAFC]/80 transition-colors group">
                            <td class="w-12 px-3 py-4 text-center cursor-grab active:cursor-grabbing text-slate-300 group-hover:text-slate-500 drag-handle" title="Tarik untuk mengatur urutan">
                                <svg class="w-4 h-4 mx-auto pointer-events-none" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-12a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"/>
                                </svg>
                            </td>
                            <td class="px-5 py-4">
                                @if($off->photo_path)
                                    <img src="{{ asset('storage/' . $off->photo_path) }}" class="w-10 h-10 rounded-full object-cover border border-[#0F4C3A]/30">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#0F4C3A] font-bold text-xs flex items-center justify-center border border-emerald-200">
                                        {{ strtoupper(substr($off->name, 0, 2)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-semibold text-[#0F172A]">
                                {{ $off->name }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-amber-50 text-amber-800 border border-amber-200/70">
                                    {{ $off->position }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right space-x-1.5">
                                <a href="{{ route('admin.officials.edit', $off->id) }}" class="inline-flex items-center gap-1 bg-white hover:bg-slate-50 text-slate-700 border border-[#E2E8F0] hover:border-[#0F4C3A]/30 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('admin.officials.destroy', $off->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200/80 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-xs font-medium">Belum ada data perangkat desa.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
                animation: 180,
                ghostClass: 'bg-emerald-50/70',
                chosenClass: 'bg-emerald-100/50',
                onEnd: function () {
                    const rows = Array.from(el.querySelectorAll('tr[data-id]'));
                    const orderIds = rows.map(r => parseInt(r.getAttribute('data-id'))).filter(Boolean);
                    
                    if (orderIds.length > 0) {
                        fetch('{{ Route::has('admin.officials.reorder') ? route('admin.officials.reorder') : url('/admin/officials/reorder') }}', {
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
                            if (data.success) {
                                const alpineData = Alpine.$data(document.querySelector('[x-data]'));
                                if (alpineData && alpineData.triggerToast) {
                                    alpineData.triggerToast(data.message || 'Urutan susunan perangkat desa berhasil diperbarui.');
                                }
                            }
                        })
                        .catch(err => {
                            console.error('Reorder error:', err);
                        });
                    }
                }
            });
        }
    });
</script>
@endpush
