@extends('layouts.admin')

@section('title', 'Data Penduduk (NIK)')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">👥 Data Penduduk</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola data seluruh penduduk Desa Catur berdasarkan NIK dan Kartu Keluarga.</p>
        </div>
        <a href="{{ route('admin.residents.create') }}" class="inline-flex items-center gap-2 bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
            ➕ Tambah Penduduk
        </a>
    </div>

    <!-- Search Card -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <form method="GET" action="{{ route('admin.residents.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari berdasarkan NIK, Nama Penduduk, atau No. KK..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold px-5 py-2 rounded-lg transition">
                🔍 Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.residents.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition text-center flex items-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">NIK</th>
                        <th class="p-4">Nama Penduduk</th>
                        <th class="p-4">No. KK / Kepala Keluarga</th>
                        <th class="p-4">Gender</th>
                        <th class="p-4">Tempat / Tgl Lahir</th>
                        <th class="p-4">Hubungan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($residents as $resident)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 font-mono font-bold text-gray-900">{{ $resident->nik }}</td>
                            <td class="p-4 font-semibold text-gray-800">{{ $resident->name }}</td>
                            <td class="p-4 text-xs">
                                <p class="font-mono text-gray-800">{{ $resident->family ? $resident->family->kk_number : '-' }}</p>
                                <p class="text-gray-500 text-[11px]">{{ $resident->family ? $resident->family->head_of_family : '-' }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $resident->gender === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $resident->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-gray-600">
                                {{ $resident->birth_place }}, {{ \Carbon\Carbon::parse($resident->birth_date)->format('d/m/Y') }}
                            </td>
                            <td class="p-4 text-xs text-gray-600">
                                {{ $resident->relationship_to_head ?? 'Anggota' }}
                            </td>
                            <td class="p-4">
                                @if($resident->status === 'hidup')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Hidup</span>
                                @elseif($resident->status === 'meninggal')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Meninggal</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Pindah</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.residents.edit', $resident->id) }}" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.residents.destroy', $resident->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penduduk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-500">
                                Belum ada data penduduk. Klik tombol <strong>Tambah Penduduk</strong> di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($residents->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $residents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
