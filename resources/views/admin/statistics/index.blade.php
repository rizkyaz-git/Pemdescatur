@extends('layouts.admin')

@section('title', 'Kelola Data Statistik')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Kelola Data Statistik Desa</h3>
            <p class="text-xs text-gray-500 mt-1">Kelola data kependudukan, perkebunan kopi, luas lahan, dan APBDes Desa Catur.</p>
        </div>
        <a href="{{ route('admin.statistics.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition">
            + Tambah Item Statistik
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Label Indikator</th>
                        <th class="p-4">Nilai (Value)</th>
                        <th class="p-4">Satuan</th>
                        <th class="p-4">Periode</th>
                        <th class="p-4">Urutan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($statistics as $st)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-900 text-xs">
                                <span class="bg-emerald-50 text-[#0d631b] px-2.5 py-1 rounded-md border border-emerald-200">
                                    {{ $st->category }}
                                </span>
                            </td>
                            <td class="p-4 font-medium text-gray-800">{{ $st->label }}</td>
                            <td class="p-4 font-serif font-bold text-base text-[#0d631b]">{{ $st->value }}</td>
                            <td class="p-4 text-xs text-gray-500">{{ $st->unit ?? '-' }}</td>
                            <td class="p-4 text-xs font-semibold text-gray-600">{{ $st->period }}</td>
                            <td class="p-4 text-xs font-mono font-bold text-gray-700">{{ $st->order }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.statistics.edit', $st->id) }}" class="text-blue-600 hover:underline text-xs font-bold">Edit</a>
                                <form action="{{ route('admin.statistics.destroy', $st->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data statistik ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">Belum ada data statistik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
