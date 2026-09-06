@extends('layouts.admin')

@section('title', 'Kelola Titik Peta & Lokasi')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Pengaturan Titik Koordinat Peta (FR-21)</h3>
            <p class="text-xs text-gray-500 mt-1">Atur titik lokasi Kantor Desa Catur dan tempat penting pada peta publik.</p>
        </div>
        <a href="{{ route('admin.locations.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition">
            + Tambah Titik Lokasi
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Thumbnail</th>
                        <th class="p-4">Nama Titik / Fasilitas</th>
                        <th class="p-4">Latitude</th>
                        <th class="p-4">Longitude</th>
                        <th class="p-4">Tag Kategori</th>
                        <th class="p-4">Status Utama</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($locations as $loc)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                @if($loc->image)
                                    <img src="{{ asset('storage/' . $loc->image) }}" alt="{{ $loc->name }}" class="w-14 h-11 object-cover rounded-lg shadow-2xs border border-gray-200">
                                @else
                                    <div class="w-14 h-11 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                        🖼️ Default
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-gray-900">
                                {{ $loc->name }}
                                @if($loc->description)
                                    <p class="text-xs text-gray-500 font-normal mt-0.5">{{ $loc->description }}</p>
                                @endif
                            </td>
                            <td class="p-4 text-xs font-mono font-semibold text-gray-700">{{ $loc->latitude }}</td>
                            <td class="p-4 text-xs font-mono font-semibold text-gray-700">{{ $loc->longitude }}</td>
                            <td class="p-4">
                                @if($loc->is_umkm)
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-900 border border-amber-200">🛍️ UMKM Desa</span>
                                @elseif($loc->is_education)
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-900 border border-purple-200">🎓 Pendidikan</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-800 border border-blue-200">📍 Destinasi</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($loc->is_primary)
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">⭐ Utama</span>
                                @else
                                    <span class="text-xs text-gray-400">Sekunder</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.locations.edit', $loc->id) }}" class="text-blue-600 hover:underline text-xs font-bold">Edit / Pilih di Peta</a>
                                <form action="{{ route('admin.locations.destroy', $loc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus titik lokasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada titik lokasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
