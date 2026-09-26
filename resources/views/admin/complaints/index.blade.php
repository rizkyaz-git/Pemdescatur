@extends('layouts.admin')

@section('title', 'Pengaduan & Aspirasi Warga')

@section('content')
<div class="space-y-5">
    {{-- 1. Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Pengaduan &amp; Aspirasi Warga</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Hubungi pelapor melalui WhatsApp, lalu tandai selesai setelah ditangani.</p>
        </div>
    </div>

    {{-- 2. Tab Baru / Riwayat dan filter --}}
    @php
        $tabParams = array_filter([
            'search' => request('search'),
            'kategori' => request('kategori'),
        ], static fn (mixed $value): bool => $value !== null && $value !== '');
        $newTabUrl = route('admin.complaints.index', array_merge($tabParams, ['tab' => 'baru']));
        $historyTabUrl = route('admin.complaints.index', array_merge($tabParams, ['tab' => 'riwayat']));
    @endphp

    <div class="flex items-center gap-1 border-b border-slate-200" role="tablist" aria-label="Pengelompokan pengaduan warga">
        <a href="{{ $newTabUrl }}" role="tab" aria-current="{{ $activeTab === 'baru' ? 'page' : 'false' }}"
           class="inline-flex items-center justify-center rounded-t-lg border-b-2 px-4 py-3 text-xs font-bold transition {{ $activeTab === 'baru' ? 'border-[#0F4C3A] bg-[#0F4C3A]/5 text-[#0F4C3A]' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-800' }}">
            Baru
        </a>
        <a href="{{ $historyTabUrl }}" role="tab" aria-current="{{ $activeTab === 'riwayat' ? 'page' : 'false' }}"
           class="inline-flex items-center justify-center rounded-t-lg border-b-2 px-4 py-3 text-xs font-bold transition {{ $activeTab === 'riwayat' ? 'border-[#0F4C3A] bg-[#0F4C3A]/5 text-[#0F4C3A]' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-800' }}">
            Riwayat
        </a>
    </div>

    <form method="GET" action="{{ route('admin.complaints.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
        <input type="hidden" name="tab" value="{{ $activeTab }}">

        <div class="relative flex-1 sm:max-w-xs">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari Pelapor / Isi Laporan..."
                   class="w-full h-9 pl-9 pr-3 text-xs sm:text-sm rounded-lg border border-slate-200 bg-white text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition">
        </div>

        @php
            $currentKategori = request('kategori');
            $selectedKategori = $kategoriLabels[$currentKategori] ?? null;
        @endphp
        <div class="relative shrink-0" x-data="{ kategoriOpen: false }" @click.away="kategoriOpen = false">
            <input type="hidden" name="kategori" x-ref="kategoriInput" value="{{ $currentKategori }}">

            <button type="button" @click="kategoriOpen = !kategoriOpen"
                class="w-full sm:w-auto h-9 px-3.5 inline-flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer shadow-2xs">
                <span class="truncate max-w-[180px]">{{ $selectedKategori ?? 'Semua Kategori' }}</span>
                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0"
                    :class="kategoriOpen ? 'rotate-180 text-[#0F4C3A]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="kategoriOpen" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                class="absolute left-0 mt-1.5 w-64 rounded-xl bg-white border border-slate-200 shadow-xl py-1 z-30 overflow-hidden text-xs max-h-60 overflow-y-auto custom-scrollbar">
                <button type="button"
                    @click="$refs.kategoriInput.value = ''; kategoriOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ !request('kategori') ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Semua Kategori</span>
                    @if(!request('kategori'))
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                @foreach($kategoriLabels as $key => $label)
                    <button type="button"
                        @click="$refs.kategoriInput.value = '{{ $key }}'; kategoriOpen = false; $el.closest('form').submit()"
                        class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ $currentKategori === $key ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span class="truncate">{{ $label }}</span>
                        @if($currentKategori === $key)
                            <svg class="w-3.5 h-3.5 text-[#0F4C3A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        @if(request('search') || request('kategori'))
            <a href="{{ route('admin.complaints.index', ['tab' => $activeTab]) }}"
               class="h-9 inline-flex items-center justify-center px-2.5 text-xs text-slate-500 hover:text-slate-800 font-medium transition">
                Reset
            </a>
        @endif
    </form>

    {{-- 3. Data Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200/80">
                        <th scope="col" class="px-4 py-3 align-middle min-w-[180px]">Pelapor</th>
                        <th scope="col" class="w-36 px-4 py-3 align-middle whitespace-nowrap">No. WhatsApp</th>
                        <th scope="col" class="w-44 px-4 py-3 align-middle whitespace-nowrap">Kategori</th>
                        <th scope="col" class="px-4 py-3 align-middle min-w-[240px]">Isi Laporan</th>
                        <th scope="col" class="w-44 px-4 py-3 text-right align-middle whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($laporans as $lap)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3.5 align-middle">
                                <p class="font-semibold text-slate-900 text-xs sm:text-sm leading-snug">{{ $lap->nama }}</p>
                                <p class="mt-0.5 text-[11px] text-slate-400 tabular-nums">{{ $lap->created_at ? $lap->created_at->format('d/m/Y H:i') : '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                @if($lap->whatsapp_url)
                                    <a href="{{ $lap->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1 font-mono text-xs font-semibold text-[#0F4C3A] hover:underline"
                                       title="Hubungi {{ $lap->nama }} melalui WhatsApp">
                                        {{ $lap->no_whatsapp }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="font-mono text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                    {{ $lap->kategori_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 align-middle">
                                <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed">{{ $lap->isi_laporan }}</p>
                            </td>
                            <td class="px-4 py-3.5 align-middle text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.complaints.show', ['complaint' => $lap->id, 'tab' => $activeTab]) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-blue-600 hover:border-blue-200 hover:bg-slate-50 transition shadow-2xs"
                                       title="Lihat Detail Pengaduan">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </a>

                                    @if($activeTab === 'riwayat')
                                        <form method="POST" action="{{ route('admin.complaints.destroy', $lap->id) }}"
                                              onsubmit="return confirm('Hapus pengaduan yang sudah selesai?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-rose-200 bg-white text-rose-700 text-xs font-medium shadow-2xs transition hover:bg-rose-50 hover:border-rose-300"
                                                    title="Hapus Pengaduan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.9 12.1a2 2 0 01-2 1.9H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M9 7V4h6v3"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.complaints.complete', $lap->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-medium shadow-2xs transition active:scale-95 cursor-pointer"
                                                    title="Tandai Pengaduan Selesai">
                                                <svg class="w-3.5 h-3.5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span>Selesai</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-xs font-semibold text-slate-800">
                                    {{ $activeTab === 'riwayat' ? 'Belum ada riwayat pengaduan selesai' : 'Belum ada pengaduan warga' }}
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $activeTab === 'riwayat' ? 'Pengaduan yang ditandai selesai akan muncul di sini.' : 'Pengaduan baru dari warga akan muncul di tab ini.' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Summary & Pagination --}}
        @if($laporans->hasPages() || $laporans->total() > 0)
            <div class="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                <p>
                    Menampilkan <span class="font-medium text-slate-700">{{ $laporans->firstItem() ?? 0 }}</span> - <span class="font-medium text-slate-700">{{ $laporans->lastItem() ?? 0 }}</span> dari <span class="font-medium text-slate-700">{{ $laporans->total() }}</span> pengaduan
                </p>
                @if($laporans->hasPages())
                    <div class="shrink-0">
                        {{ $laporans->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
