@extends('layouts.admin')

@section('title', 'Kelola Menu Navigasi')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Kelola Menu Navigasi Publik (FR-22, FR-23)</h3>
            <p class="text-xs text-gray-500 mt-1">Atur label, urutan tampil, serta aktifkan/nonaktifkan menu tanpa mengubah kode.</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition">
            + Tambah Menu Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Label Menu</th>
                        <th class="p-4">URL / Route Target</th>
                        <th class="p-4">Urutan (Order)</th>
                        <th class="p-4">Visibilitas (Show/Hide)</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($menus as $m)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-900">
                                {{ $m->label }}
                                @if($m->is_external)
                                    <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded ml-1">Eksternal ↗</span>
                                @endif
                            </td>
                            <td class="p-4 font-mono text-xs text-gray-600">{{ $m->slug_or_url }}</td>
                            <td class="p-4 text-xs font-mono font-bold text-gray-700">{{ $m->order }}</td>
                            <td class="p-4">
                                <form action="{{ route('admin.menus.toggle', $m->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 text-xs font-bold rounded-full transition {{ $m->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        {{ $m->is_active ? '✓ Aktif (Tampil)' : '✕ Sembunyi (Nonaktif)' }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.menus.edit', $m->id) }}" class="text-blue-600 hover:underline text-xs font-bold">Edit</a>
                                <form action="{{ route('admin.menus.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus menu navigasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada item menu navigasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
