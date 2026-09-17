@extends('layouts.admin')

@section('title', 'Pengaduan & Aspirasi Warga')

@section('content')
<div class="space-y-5">
    <!-- 1. Page Header (Standard Admin Typography & Spacing) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-1">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Pengaduan & Aspirasi Warga</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola dan tindaklanjuti laporan pengaduan dari warga Desa Catur.</p>
        </div>
    </div>

    <!-- 2. Compact Filter Toolbar (Height ~40px, Radius 8px, Border #DDE5E1) -->
    <div class="bg-white p-3 sm:p-3.5 rounded-[12px] border border-[#DDE5E1] shadow-2xs">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
            <!-- Search Input (5 cols) -->
            <div class="sm:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / isi laporan..."
                    class="w-full h-10 pl-9 pr-3.5 rounded-lg border border-[#DDE5E1] focus:ring-1 focus:ring-[#0B6B52] focus:border-[#0B6B52] text-xs bg-white text-[#10233F]">
            </div>

            <!-- Kategori Select (3 cols) -->
            <div class="sm:col-span-3">
                <select name="kategori" class="w-full h-10 px-3 rounded-lg border border-[#DDE5E1] focus:ring-1 focus:ring-[#0B6B52] focus:border-[#0B6B52] text-xs bg-white text-[#10233F]">
                    <option value="">Semua Kategori</option>
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
                    @foreach($kategoris as $k)
                        <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                            {{ $labelKategoris[$k] ?? ucfirst($k) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Select (2 cols) -->
            <div class="sm:col-span-2">
                <select name="status" class="w-full h-10 px-3 rounded-lg border border-[#DDE5E1] focus:ring-1 focus:ring-[#0B6B52] focus:border-[#0B6B52] text-xs bg-white text-[#10233F]">
                    <option value="">Semua Status</option>
                    <option value="baru"     {{ request('status') == 'baru'     ? 'selected' : '' }}>Baru</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai"  {{ request('status') == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak"  {{ request('status') == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Actions (2 cols) -->
            <div class="sm:col-span-2 flex gap-1.5">
                <button type="submit" class="flex-1 h-10 bg-[#0B6B52] hover:bg-[#07513F] text-white text-xs font-semibold px-3 rounded-lg transition shadow-2xs inline-flex items-center justify-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>
                @if(request('search') || request('kategori') || request('status'))
                    <a href="{{ route('admin.complaints.index') }}" class="h-10 bg-white hover:bg-slate-50 text-[#607089] border border-[#DDE5E1] text-xs font-semibold px-2.5 rounded-lg transition shadow-2xs flex items-center justify-center" title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 3. Data Table Card (Standard Admin Table: Radius 12px, Border #DDE5E1) -->
    <div class="bg-white rounded-[12px] border border-[#DDE5E1] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F7F9F8] text-[#607089] text-[11px] font-bold uppercase tracking-wider border-b border-[#DDE5E1]">
                        <th class="px-4 py-3">Pelapor</th>
                        <th class="px-4 py-3">No. WhatsApp</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Isi Laporan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9] text-slate-700 bg-white">
                    @forelse($laporans as $lap)
                        <tr class="hover:bg-[#F7F9F8] transition-colors">
                            <td class="px-4 py-3 align-middle">
                                <p class="font-semibold text-[#10233F] text-xs">{{ $lap->nama }}</p>
                                <p class="text-[11px] text-[#607089] tabular-nums mt-0.5">{{ $lap->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-4 py-3 align-middle font-mono text-xs text-slate-700">{{ $lap->no_whatsapp }}</td>
                            <td class="px-4 py-3 align-middle">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                    {{ $labelKategoris[$lap->kategori] ?? ucfirst(str_replace('_', ' ', $lap->kategori)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <p class="text-xs text-[#607089] max-w-xs line-clamp-2 leading-relaxed">{{ $lap->isi_laporan }}</p>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[11px] font-semibold rounded-full border {{ $lap->status_badge_class }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $lap->status === 'baru' ? 'animate-pulse' : '' }} bg-current opacity-70"></span>
                                    <span>{{ $lap->status_label }}</span>
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.complaints.show', $lap->id) }}" 
                                       class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-[#DDE5E1] text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                    <a href="{{ route('admin.complaints.edit', $lap->id) }}" 
                                       class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg bg-[#0B6B52] hover:bg-[#07513F] text-white text-xs font-semibold shadow-2xs transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span>Tanggapi</span>
                                    </a>
                                    <form action="{{ route('admin.complaints.destroy', $lap->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus laporan pengaduan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 h-7 px-2 rounded-lg border border-rose-200 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition shadow-2xs cursor-pointer"
                                                title="Hapus Laporan">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-xs font-semibold text-[#10233F]">Belum ada pengaduan</p>
                                <p class="text-[11px] text-[#607089] mt-0.5">Belum ada laporan pengaduan yang masuk saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporans->hasPages())
            <div class="px-4 py-3 border-t border-[#DDE5E1] bg-[#F7F9F8]">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
