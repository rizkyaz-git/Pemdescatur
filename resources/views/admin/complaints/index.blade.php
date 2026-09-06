@extends('layouts.admin')

@section('title', 'Pengaduan & Aspirasi Warga')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">📢 Pengaduan & Aspirasi Warga</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola laporan pengaduan, kritik, dan keluhan masyarakat Desa Catur.</p>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari Judul / Isi Laporan..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div>
                <select name="category_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Baru / Belum Ditanggapi</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai / Ditanggapi</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    🔍 Filter
                </button>
                @if(request('search') || request('category_id') || request('status'))
                    <a href="{{ route('admin.complaints.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-2 rounded-lg transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">No. Tiket</th>
                        <th class="p-4">Pelapor</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Judul Pengaduan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($complaints as $cmp)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 font-mono font-bold text-gray-900">{{ $cmp->ticket_number }}</td>
                            <td class="p-4">
                                <p class="font-semibold text-gray-900">{{ $cmp->user ? $cmp->user->name : ($cmp->is_anonymous ? 'Anonim' : '-') }}</p>
                                <p class="text-xs text-gray-500">{{ $cmp->created_at ? $cmp->created_at->format('d/m/Y H:i') : '' }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">
                                    {{ $cmp->category ? $cmp->category->name : '-' }}
                                </span>
                            </td>
                            <td class="p-4 font-semibold text-gray-800 max-w-xs truncate">{{ $cmp->title }}</td>
                            <td class="p-4">
                                @if($cmp->status === 'new')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Baru</span>
                                @elseif($cmp->status === 'processing')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Diproses</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.complaints.show', $cmp->id) }}" class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    👁️ Detail
                                </a>
                                <a href="{{ route('admin.complaints.edit', $cmp->id) }}" class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    💬 Tanggapi
                                </a>
                                <form action="{{ route('admin.complaints.destroy', $cmp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan pengaduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Belum ada laporan pengaduan masuk.
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
@endsection
