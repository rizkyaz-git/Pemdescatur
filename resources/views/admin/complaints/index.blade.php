@extends('layouts.admin')

@section('title', 'Pengaduan & Aspirasi Warga')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/60 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <span>Aspirasi & Transparansi Publik</span>
            </div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Pengaduan & Aspirasi Warga</h1>
            <p class="text-xs text-[#64748B] mt-1">Kelola laporan pengaduan, masukan, dan keluhan masyarakat Desa Catur secara responsif dan akuntabel.</p>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white p-4 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari Judul / Isi Laporan..." 
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs sm:text-sm bg-[#F8FAFC]/50">
            </div>
            <div>
                <select name="category_id" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs sm:text-sm bg-[#F8FAFC]/50 text-slate-700">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-xs sm:text-sm bg-[#F8FAFC]/50 text-slate-700">
                    <option value="">Semua Status Pengaduan</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Baru / Belum Ditanggapi</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai / Ditanggapi</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition inline-flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>
                @if(request('search') || request('category_id') || request('status'))
                    <a href="{{ route('admin.complaints.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3.5 py-2.5 rounded-xl transition flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                        <th class="px-5 py-3.5">No. Tiket</th>
                        <th class="px-5 py-3.5">Pelapor</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Judul Pengaduan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9]">
                    @forelse($complaints as $cmp)
                        <tr class="hover:bg-[#F8FAFC]/80 transition-colors">
                            <td class="px-5 py-4 font-mono font-bold text-xs text-[#0F172A] tabular-nums tracking-wide">
                                {{ $cmp->ticket_number }}
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-[#0F172A] text-xs sm:text-sm">
                                    {{ $cmp->user ? $cmp->user->name : ($cmp->is_anonymous ? 'Anonim (Warga)' : '-') }}
                                </p>
                                <p class="text-[11px] text-slate-500 tabular-nums">
                                    {{ $cmp->created_at ? $cmp->created_at->format('d/m/Y H:i') : '' }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $cmp->category ? $cmp->category->name : '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-[#0F172A] max-w-xs truncate text-xs sm:text-sm">{{ $cmp->title }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @if($cmp->status === 'new')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                        <span>Baru</span>
                                    </span>
                                @elseif($cmp->status === 'processing')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-800 border border-amber-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Diproses</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-[#DCFCE7] text-[#15803D]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                                        <span>Selesai</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right space-x-1.5">
                                <a href="{{ route('admin.complaints.show', $cmp->id) }}" class="inline-flex items-center gap-1 bg-white hover:bg-slate-50 text-slate-700 border border-[#E2E8F0] hover:border-blue-400 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Detail</span>
                                </a>
                                <a href="{{ route('admin.complaints.edit', $cmp->id) }}" class="inline-flex items-center gap-1 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xs transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>Tanggapi</span>
                                </a>
                                <form action="{{ route('admin.complaints.destroy', $cmp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan pengaduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200/80 text-xs font-semibold px-2 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                                <p class="text-xs font-medium">Belum ada laporan pengaduan masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($complaints->hasPages())
            <div class="p-4 border-t border-[#E2E8F0] bg-[#F8FAFC]">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
