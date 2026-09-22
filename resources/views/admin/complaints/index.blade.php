@extends('layouts.admin')

@section('title', 'Pengaduan & Aspirasi Warga')

@section('content')
<div class="space-y-5">
    {{-- 1. Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Pengaduan &amp; Aspirasi Warga</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola dan tindaklanjuti laporan pengaduan dari warga Desa Catur.</p>
        </div>
    </div>

    {{-- 2. Compact Filter Toolbar (Harmonisasi dengan Kelola Berita) --}}
    <form method="GET" action="{{ route('admin.complaints.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
        <!-- Search Input (Enter to Search) -->
        <div class="relative flex-1 sm:max-w-xs">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari nama / isi laporan..." 
                   class="w-full h-9 pl-9 pr-3 text-xs sm:text-sm rounded-lg border border-slate-200 bg-white text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-1 focus:ring-[#0F4C3A] focus:border-[#0F4C3A] transition">
        </div>

        <!-- Dropdown Kategori Gaya Navbar -->
        @php
            $labelKategoris = [
                'infrastruktur'  => 'Infrastruktur & Fasilitas',
                'kependudukan'   => 'Administrasi & Kependudukan',
                'keamanan'       => 'Keamanan & Ketertiban',
                'lingkungan'     => 'Lingkungan & Kebersihan',
                'layanan_publik' => 'Layanan Publik',
                'lainnya'        => 'Lainnya',
            ];
        @endphp
        <div class="relative shrink-0" x-data="{ kategoriOpen: false }" @click.away="kategoriOpen = false">
            <input type="hidden" name="kategori" x-ref="kategoriInput" value="{{ request('kategori') }}">
            
            <button type="button" @click="kategoriOpen = !kategoriOpen"
                class="w-full sm:w-auto h-9 px-3.5 inline-flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer shadow-2xs">
                <span>
                    {{ request('kategori') && isset($labelKategoris[request('kategori')]) ? $labelKategoris[request('kategori')] : (request('kategori') ? ucfirst(str_replace('_', ' ', request('kategori'))) : 'Semua Kategori') }}
                </span>
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
                class="absolute left-0 mt-1.5 w-56 rounded-xl bg-white border border-slate-200 shadow-xl py-1 z-30 overflow-hidden text-xs max-h-60 overflow-y-auto custom-scrollbar">
                
                <button type="button" 
                    @click="$refs.kategoriInput.value = ''; kategoriOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ !request('kategori') ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Semua Kategori</span>
                    @if(!request('kategori'))
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                @foreach($kategoris as $k)
                    <button type="button" 
                        @click="$refs.kategoriInput.value = '{{ $k }}'; kategoriOpen = false; $el.closest('form').submit()"
                        class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('kategori') === $k ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>{{ $labelKategoris[$k] ?? ucfirst($k) }}</span>
                        @if(request('kategori') === $k)
                            <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Dropdown Status Gaya Navbar -->
        <div class="relative shrink-0" x-data="{ statusOpen: false }" @click.away="statusOpen = false">
            <input type="hidden" name="status" x-ref="statusInput" value="{{ request('status') }}">
            
            <button type="button" @click="statusOpen = !statusOpen"
                class="w-full sm:w-auto h-9 px-3.5 inline-flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer shadow-2xs">
                <span>
                    @if(request('status') === 'baru')
                        Baru
                    @elseif(request('status') === 'diproses')
                        Sedang Diproses
                    @elseif(request('status') === 'selesai')
                        Selesai
                    @elseif(request('status') === 'ditolak')
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
                    @click="$refs.statusInput.value = 'baru'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'baru' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Baru</span>
                    @if(request('status') === 'baru')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                <button type="button" 
                    @click="$refs.statusInput.value = 'diproses'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'diproses' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Sedang Diproses</span>
                    @if(request('status') === 'diproses')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                <button type="button" 
                    @click="$refs.statusInput.value = 'selesai'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'selesai' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Selesai</span>
                    @if(request('status') === 'selesai')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>

                <button type="button" 
                    @click="$refs.statusInput.value = 'ditolak'; statusOpen = false; $el.closest('form').submit()"
                    class="w-full flex items-center justify-between px-3.5 py-2 text-left transition {{ request('status') === 'ditolak' ? 'bg-[#0F4C3A]/5 text-[#0F4C3A] font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>Ditolak</span>
                    @if(request('status') === 'ditolak')
                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>
            </div>
        </div>

        @if(request('search') || request('kategori') || request('status'))
            <div class="flex items-center shrink-0">
                <a href="{{ route('admin.complaints.index') }}" 
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
                        <th scope="col" class="px-4 py-3 align-middle min-w-[180px]">Pelapor</th>
                        <th scope="col" class="w-36 px-4 py-3 align-middle whitespace-nowrap">No. WhatsApp</th>
                        <th scope="col" class="w-44 px-4 py-3 align-middle whitespace-nowrap">Kategori</th>
                        <th scope="col" class="px-4 py-3 align-middle min-w-[240px]">Isi Laporan</th>
                        <th scope="col" class="w-32 px-4 py-3 align-middle whitespace-nowrap">Status</th>
                        <th scope="col" class="w-44 px-4 py-3 text-right align-middle whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($laporans as $lap)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3.5 align-middle">
                                <p class="font-semibold text-slate-900 text-xs sm:text-sm">{{ $lap->nama }}</p>
                                <p class="text-[11px] text-slate-400 tabular-nums mt-0.5">{{ $lap->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap font-mono text-xs text-slate-600">
                                {{ $lap->no_whatsapp }}
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                    {{ $labelKategoris[$lap->kategori] ?? ucfirst(str_replace('_', ' ', $lap->kategori)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 align-middle">
                                <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed">{{ $lap->isi_laporan }}</p>
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                @if($lap->status === 'baru')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        <span>Baru</span>
                                    </span>
                                @elseif($lap->status === 'diproses')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-800 border border-amber-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Diproses</span>
                                    </span>
                                @elseif($lap->status === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>Selesai</span>
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
                                    <a href="{{ route('admin.complaints.show', $lap->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-blue-600 hover:border-blue-200 hover:bg-slate-50 transition shadow-2xs"
                                       title="Lihat Detail Laporan">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                    <a href="{{ route('admin.complaints.edit', $lap->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-medium shadow-2xs transition active:scale-95 cursor-pointer"
                                       title="Tanggapi Pengaduan">
                                        <svg class="w-3.5 h-3.5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span>Tanggapi</span>
                                    </a>
                                    <form action="{{ route('admin.complaints.destroy', $lap->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan pengaduan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition shadow-2xs cursor-pointer"
                                                title="Hapus Laporan">
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-xs font-semibold text-slate-800">Belum ada pengaduan warga</p>
                                <p class="text-xs text-slate-400 mt-0.5">Semua laporan pengaduan dan aspirasi dari warga akan ditampilkan di sini.</p>
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
