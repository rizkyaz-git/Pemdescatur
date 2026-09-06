@extends('layouts.admin')

@section('title', 'Kelola Perangkat Desa')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Struktur & Data Perangkat Desa</h3>
            <p class="text-xs text-gray-500 mt-1">Kelola nama, jabatan, foto, urutan, serta atasan/hierarki organisasi perangkat desa (FR-20).</p>
        </div>
        <a href="{{ route('admin.officials.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition">
            + Tambah Perangkat Desa
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Foto</th>
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">Jabatan</th>
                        <th class="p-4">Atasan (Hierarki)</th>
                        <th class="p-4">Urutan (Order)</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($officials as $off)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                @if($off->photo_path)
                                    <img src="{{ asset('storage/' . $off->photo_path) }}" class="w-10 h-10 rounded-full object-cover border border-emerald-600">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-[#0d631b] font-bold text-xs flex items-center justify-center border border-emerald-300">
                                        {{ strtoupper(substr($off->name, 0, 2)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-gray-900">{{ $off->name }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-amber-50 text-[#855300] border border-amber-200">
                                    {{ $off->position }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-gray-600">
                                {{ $off->parent ? $off->parent->position . ' (' . $off->parent->name . ')' : '— (Root Utama)' }}
                            </td>
                            <td class="p-4 text-xs font-mono font-bold text-gray-700">{{ $off->order }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.officials.edit', $off->id) }}" class="text-blue-600 hover:underline text-xs font-bold">Edit</a>
                                <form action="{{ route('admin.officials.destroy', $off->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Belum ada data perangkat desa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
