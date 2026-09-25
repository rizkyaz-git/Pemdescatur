@extends('layouts.admin')

@section('title', 'Permohonan Surat Warga')

@section('content')
<div class="space-y-5" x-data="{ createTypeModalOpen: false }">
    {{-- 1. Page Header & Primary Action --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Permohonan Surat Warga</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Pantau, proses, dan verifikasi permohonan surat masuk dari warga secara online.</p>
        </div>
        <div class="shrink-0 self-start sm:self-auto">
            <button type="button" @click="createTypeModalOpen = true"
               class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Jenis Surat</span>
            </button>
        </div>
    </div>

    {{-- 2. Compact Filter Toolbar (Harmonisasi dengan Kelola Berita) --}}
    <form method="GET" action="{{ route('admin.letter-requests.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
        <!-- Search Input (Enter to Search) -->
        <div class="relative flex-1 sm:max-w-xs">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari Pemohon / Jenis Surat..."
                   class="w-full h-9 pl-9 pr-3 text-xs sm:text-sm rounded-lg border border-slate-200 bg-white text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition">
        </div>

        <!-- Dropdown Jenis Surat Gaya Navbar -->
        @php
            $currentTplId = request('template_id');
            $selectedTemplate = $templates->first(function ($t) use ($currentTplId) {
                return (string) $t->id === (string) $currentTplId;
            });
            $selectedLabel = 'Semua Jenis Surat';
            if ($selectedTemplate) {
                $selectedLabel = $selectedTemplate->name . ($selectedTemplate->code ? ' (' . $selectedTemplate->code . ')' : '');
            } elseif ($currentTplId === 'lainnya') {
                $selectedLabel = 'Lainnya';
            }
        @endphp
        <div class="relative shrink-0" x-data="{ templateOpen: false }" @click.away="templateOpen = false">
            <input type="hidden" name="template_id" x-ref="templateInput" value="{{ request('template_id') }}">
            
            <button type="button" @click="templateOpen = !templateOpen"
                class="w-full sm:w-auto h-9 px-3.5 inline-flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer shadow-2xs">
                <span class="truncate max-w-[170px]">
                    {{ $selectedLabel }}
                </span>
                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0"
                    :class="templateOpen ? 'rotate-180 text-[#0F4C3A]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="templateOpen" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                class="absolute left-0 mt-1.5 w-64 rounded-xl bg-white border border-slate-200 shadow-xl py-1 z-30 overflow-hidden text-xs max-h-60 overflow-y-auto custom-scrollbar">
                
                <button type="button" 
                    @click="$refs.templateInput.value = ''; templateOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ !request('template_id') ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Semua Jenis Surat</span>
                    @if(!request('template_id'))
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                @foreach($templates as $tpl)
                    <button type="button" 
                        @click="$refs.templateInput.value = '{{ $tpl->id }}'; templateOpen = false; $el.closest('form').submit()"
                        class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ (string) request('template_id') === (string) $tpl->id ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span class="truncate">{{ $tpl->name }}{{ $tpl->code ? ' (' . $tpl->code . ')' : '' }}</span>
                        @if((string) request('template_id') === (string) $tpl->id)
                            <svg class="w-3.5 h-3.5 text-[#0F4C3A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </button>
                @endforeach

                @if(!$templates->contains('name', 'Lainnya'))
                    <button type="button" 
                        @click="$refs.templateInput.value = 'lainnya'; templateOpen = false; $el.closest('form').submit()"
                        class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('template_id') === 'lainnya' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span class="truncate">Lainnya</span>
                        @if(request('template_id') === 'lainnya')
                            <svg class="w-3.5 h-3.5 text-[#0F4C3A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </button>
                @endif
            </div>
        </div>

        <!-- Dropdown Status Gaya Navbar -->
        <div class="relative shrink-0" x-data="{ statusOpen: false }" @click.away="statusOpen = false">
            <input type="hidden" name="status" x-ref="statusInput" value="{{ request('status') }}">
            
            <button type="button" @click="statusOpen = !statusOpen"
                class="w-full sm:w-auto h-9 px-3.5 inline-flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer shadow-2xs">
                <span>
                    @if(request('status') === 'pending')
                        Pending (Menunggu)
                    @elseif(request('status') === 'approved')
                        Disetujui
                    @elseif(request('status') === 'rejected')
                        Ditolak
                    @else
                        Semua Status
                    @endif
                </span>
                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0"
                    :class="statusOpen ? 'rotate-180 text-[#0F4C3A]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="statusOpen" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                class="absolute left-0 mt-1.5 w-44 rounded-xl bg-white border border-slate-200 shadow-xl py-1 z-30 overflow-hidden text-xs">
                
                <button type="button" 
                    @click="$refs.statusInput.value = ''; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ !request('status') ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Semua Status</span>
                    @if(!request('status'))
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                <button type="button" 
                    @click="$refs.statusInput.value = 'pending'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'pending' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Pending (Menunggu)</span>
                    @if(request('status') === 'pending')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                <button type="button" 
                    @click="$refs.statusInput.value = 'approved'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'approved' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Disetujui</span>
                    @if(request('status') === 'approved')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                <button type="button" 
                    @click="$refs.statusInput.value = 'rejected'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'rejected' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Ditolak</span>
                    @if(request('status') === 'rejected')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>
            </div>
        </div>

        @if(request('search') || request('template_id') || request('status'))
            <div class="flex items-center shrink-0">
                <a href="{{ route('admin.letter-requests.index') }}" 
                   class="h-9 inline-flex items-center justify-center px-2.5 text-xs text-slate-500 hover:text-slate-800 font-medium transition">
                    Reset
                </a>
            </div>
        @endif
    </form>

    {{-- 3. Data Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200/80">
                        <th scope="col" class="px-4 py-3 align-middle min-w-[200px]">Pemohon</th>
                        <th scope="col" class="w-36 px-4 py-3 align-middle whitespace-nowrap">No. WhatsApp</th>
                        <th scope="col" class="px-4 py-3 align-middle min-w-[200px]">Jenis Surat</th>
                        <th scope="col" class="w-32 px-4 py-3 align-middle whitespace-nowrap">Tgl Pengajuan</th>
                        <th scope="col" class="w-32 px-4 py-3 align-middle whitespace-nowrap">Status</th>
                        <th scope="col" class="w-36 px-4 py-3 text-right align-middle whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3.5 align-middle">
                                <p class="font-semibold text-slate-900 text-xs sm:text-sm leading-snug">{{ $req->user ? $req->user->name : data_get($req->form_data, 'nama', '-') }}</p>
                                @if($req->user && $req->user->email)
                                    <p class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $req->user->email }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap font-mono text-slate-600 text-xs">
                                {{ data_get($req->form_data, 'telepon', '-') }}
                            </td>
                            <td class="px-4 py-3.5 align-middle">
                                <span class="font-medium text-slate-800 text-xs">
                                    @if(data_get($req->form_data, 'jenis_surat_lainnya'))
                                        {{ data_get($req->form_data, 'jenis_surat_lainnya') }}
                                        <span class="text-[10px] text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200/60 font-semibold ml-1">Lainnya</span>
                                    @else
                                        {{ $req->template ? ($req->template->title ?? $req->template->name) : '-' }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap text-xs text-slate-600 tabular-nums">
                                {{ $req->created_at ? $req->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                @if($req->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-800 border border-amber-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Menunggu</span>
                                    </span>
                                @elseif($req->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>Disetujui</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-rose-50 text-rose-700 border border-rose-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Ditolak</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 align-middle text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.letter-requests.show', $req->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-blue-600 hover:border-blue-200 hover:bg-slate-50 transition shadow-2xs"
                                       title="Lihat Detail Permohonan">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                    <a href="{{ route('admin.letter-requests.edit', $req->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-medium shadow-2xs transition active:scale-95 cursor-pointer"
                                       title="Proses Surat">
                                        <svg class="w-3.5 h-3.5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <span>Proses</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs font-semibold text-slate-800">Belum ada permohonan surat masuk</p>
                                <p class="text-xs text-slate-400 mt-0.5">Semua permohonan surat dari warga akan ditampilkan di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Summary & Pagination --}}
        @if($requests->hasPages() || $requests->total() > 0)
            <div class="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                <p>
                    Menampilkan <span class="font-medium text-slate-700">{{ $requests->firstItem() ?? 0 }}</span> - <span class="font-medium text-slate-700">{{ $requests->lastItem() ?? 0 }}</span> dari <span class="font-medium text-slate-700">{{ $requests->total() }}</span> permohonan
                </p>
                @if($requests->hasPages())
                    <div class="shrink-0">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Modal Tambah Jenis Surat Cepat --}}
    <template x-teleport="body">
        <div x-show="createTypeModalOpen" 
             x-cloak 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-xs overflow-y-auto"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div @click.away="createTypeModalOpen = false"
                 class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-5 sm:p-6 my-auto text-left relative"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#0F4C3A] flex items-center justify-center border border-emerald-200/60 shadow-2xs shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 font-jakarta leading-snug">Tambah Jenis Surat Baru</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Langsung aktif di formulir pengajuan online warga</p>
                        </div>
                    </div>
                    <button type="button" @click="createTypeModalOpen = false" 
                            class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-100 transition cursor-pointer"
                            aria-label="Tutup Modal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal Form --}}
                <form action="{{ route('admin.letter-requests.store-type') }}" method="POST" class="mt-4 space-y-3.5 text-xs">
                    @csrf
                    
                    {{-- Nama Jenis Surat --}}
                    <div>
                        <label for="type_name" class="block font-semibold text-slate-800 mb-1.5">
                            Nama Jenis Surat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="type_name" 
                               required 
                               placeholder="Contoh: Surat Keterangan Belum Menikah"
                               class="w-full h-10 px-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs text-slate-900 placeholder-slate-400 bg-white">
                    </div>

                    {{-- Kode / Singkatan (Opsional) --}}
                    <div>
                        <label for="type_code" class="block font-semibold text-slate-800 mb-1.5">
                            Kode / Singkatan <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <input type="text" 
                               name="code" 
                               id="type_code" 
                               placeholder="Contoh: SKBM"
                               class="w-full h-10 px-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs text-slate-900 placeholder-slate-400 bg-white uppercase">
                        <p class="text-[10px] text-slate-400 mt-1">Digunakan sebagai singkatan atau kode pengenal surat di sistem.</p>
                    </div>

                    {{-- Persyaratan Berkas (Opsional) --}}
                    <div>
                        <label for="type_requirements" class="block font-semibold text-slate-800 mb-1.5">
                            Persyaratan Berkas <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <textarea name="requirements" 
                                  id="type_requirements" 
                                  rows="3" 
                                  placeholder="Contoh: Surat Pengantar RT/RW, Fotokopi KTP Pemohon, Fotokopi Kartu Keluarga (KK)"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs text-slate-900 placeholder-slate-400 bg-white resize-y"></textarea>
                        <p class="text-[10px] text-slate-400 mt-1">Daftar berkas yang harus disiapkan oleh warga saat mengajukan jenis surat ini.</p>
                    </div>

                    {{-- Deskripsi Singkat (Opsional) --}}
                    <div>
                        <label for="type_description" class="block font-semibold text-slate-800 mb-1.5">
                            Keterangan / Keperluan <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <textarea name="description" 
                                  id="type_description" 
                                  rows="2" 
                                  placeholder="Penjelasan singkat mengenai peruntukan surat ini (opsional)"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs text-slate-900 placeholder-slate-400 bg-white resize-y"></textarea>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        <button type="button" @click="createTypeModalOpen = false" 
                                class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-4.5 py-2 rounded-lg bg-[#0F4C3A] hover:bg-[#072C21] text-xs font-semibold text-white shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Simpan Jenis Surat</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
