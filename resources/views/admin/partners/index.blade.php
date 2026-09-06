@extends('layouts.admin')

@section('title', 'Kelola Logo Program & Mitra')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-xs border border-gray-200">
        <div>
            <h1 class="font-serif font-bold text-xl text-gray-900">Logo Program & Kemitraan Desa</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola logo instansi, program pemerintah, dan kemitraan yang ditampilkan pada running marquee halaman depan.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="inline-flex items-center gap-2 bg-[#0d631b] hover:bg-[#0a4d15] text-white font-semibold text-xs px-5 py-2.5 rounded-xl transition shadow-sm shrink-0">
            <span>+ Tambah Logo Program</span>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table List -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-200 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-16">Urutan</th>
                        <th class="px-6 py-4">Nama Program / Mitra</th>
                        <th class="px-6 py-4">Nama Tampilan (Marquee)</th>
                        <th class="px-6 py-4">Logo</th>
                        <th class="px-6 py-4">Tautan (URL)</th>
                        <th class="px-6 py-4 w-28 text-center">Status</th>
                        <th class="px-6 py-4 w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4 font-bold text-gray-500">{{ $partner->order }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $partner->name }}</td>
                            <td class="px-6 py-4 font-bold text-emerald-800">
                                {{ $partner->display_name ?? $partner->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if($partner->logo)
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-8 max-w-[120px] object-contain bg-gray-50 p-1 rounded border border-gray-200">
                                @else
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-500 rounded font-mono text-[11px] font-bold">TEXT LOGO</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-[11px]">
                                @if($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                        <span>{{ Str::limit($partner->url, 30) }}</span>
                                        <span>↗</span>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($partner->is_active)
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-[10px]">AKTIF</span>
                                @else
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full font-bold text-[10px]">DRAFT</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="inline-block px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold rounded-lg transition">Edit</a>
                                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus logo program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold rounded-lg transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                Belum ada logo program/mitra. Klik tombol "+ Tambah Logo Program" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
