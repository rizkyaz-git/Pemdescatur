@extends('layouts.public')

@section('title', 'Pengaduan Warga Online - Desa Catur')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Top Banner -->
        <div class="bg-gradient-to-r from-[#0d631b] to-[#0a4f15] text-white p-8 rounded-xl shadow-md border-b-4 border-[#fea619] flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-xs font-semibold tracking-wider uppercase mb-2">
                    Layanan Aspirasi & Pengaduan Warga (Bebas Akses)
                </span>
                <h1 class="font-serif text-3xl font-bold">📢 Portal Pengaduan & Aspirasi Warga</h1>
                <p class="text-emerald-100 text-sm mt-1 max-w-2xl">
                    Sampaikan laporan, keluhan fasilitas umum, atau aspirasi Anda secara terbuka kepada Pemerintah Desa Catur. Bebas diakses tanpa wajib login!
                </p>
            </div>
            <div>
                <a href="{{ route('warga.complaint.create') }}" class="inline-flex items-center gap-2 bg-[#fea619] hover:bg-amber-600 text-gray-900 font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                    ✍️ Buat Laporan Pengaduan
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-xl shadow-xs flex items-center justify-between">
                <p class="text-sm font-medium text-emerald-800">✅ {{ session('success') }}</p>
            </div>
        @endif

        <!-- Form Pencarian Ticket / Judul Pengaduan -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
            <form action="{{ route('warga.complaint.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ $search ?? '' }}" 
                           placeholder="Cek laporan dengan Nomor Tiket (Contoh: PGD-202609-00001) atau kata kunci judul..."
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm">
                    <svg class="w-5 h-5 absolute left-3.5 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs uppercase tracking-wider transition">
                    🔍 Cek Status Laporan
                </button>
            </form>
        </div>

        <!-- List Pengaduan -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="font-serif text-xl font-bold text-gray-800">Daftar Laporan Pengaduan Warga</h2>
                @if(!empty($search))
                    <a href="{{ route('warga.complaint.index') }}" class="text-xs font-bold text-emerald-800 hover:underline">
                        Reset Pencarian
                    </a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                            <th class="p-4">No. Tiket</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Judul Pengaduan</th>
                            <th class="p-4">Tanggal Pengaduan</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($complaints as $cmp)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="p-4 font-mono font-bold text-gray-900">{{ $cmp->ticket_number }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">
                                        {{ $cmp->category ? $cmp->category->name : '-' }}
                                    </span>
                                </td>
                                <td class="p-4 font-semibold text-gray-800 max-w-xs truncate">{{ $cmp->title }}</td>
                                <td class="p-4 text-xs text-gray-600">
                                    {{ $cmp->created_at ? $cmp->created_at->format('d F Y, H:i') : '-' }}
                                </td>
                                <td class="p-4">
                                    @if($cmp->status === 'new')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">🔴 Baru</span>
                                    @elseif($cmp->status === 'processing')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">🟡 Diproses</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">🟢 Selesai</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('warga.complaint.show', $cmp->id) }}" class="inline-flex items-center gap-1 bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2 rounded-xl transition">
                                        👁️ Lihat Tanggapan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-500">
                                    <p class="text-3xl mb-2">📢</p>
                                    <p class="font-semibold text-base text-gray-800">Tidak ada pengaduan ditemukan.</p>
                                    <p class="text-xs text-gray-500 mt-1">Gunakan pencarian di atas atau klik <strong>Buat Laporan Pengaduan</strong>.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($complaints->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $complaints->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
