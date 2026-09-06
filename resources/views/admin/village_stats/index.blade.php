@extends('layouts.admin')

@section('title', 'Kelola Statistik Infografis Profil Desa')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-start bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Statistik Infografis Profil Desa</h3>
            <p class="text-xs text-gray-500 mt-1">Data chart untuk halaman Profil Desa: mata pencaharian, APBDes, kondisi jalan, KB, dll.</p>
        </div>
        <a href="{{ route('admin.village-stats.create') }}" class="bg-[#0A3D29] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition shrink-0">
            + Tambah Data Statistik
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    @foreach($categories as $cat)
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-[#0A3D29] bg-[#EAF1E8] px-3 py-1 rounded-full border border-[#0A3D29]/20">{{ $cat->label }}</span>
                <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">{{ $cat->chart_type }} · {{ $cat->section }}</span>
                @if($cat->unit)<span class="text-[10px] text-gray-400">{{ $cat->unit }}</span>@endif
            </div>
            <span class="text-[10px] font-bold text-gray-400">{{ $cat->stats->count() }} data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-[10px] uppercase border-b border-gray-100">
                        <th class="px-4 py-2.5">Label</th>
                        <th class="px-4 py-2.5">Nilai</th>
                        <th class="px-4 py-2.5">Tahun</th>
                        <th class="px-4 py-2.5">Sub Grup</th>
                        <th class="px-4 py-2.5">Urutan</th>
                        <th class="px-4 py-2.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($cat->stats as $stat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5 text-xs font-semibold text-gray-900">{{ $stat->label }}</td>
                        <td class="px-4 py-2.5 text-xs font-bold font-serif text-[#0A3D29]">{{ number_format($stat->value, 2) }}</td>
                        <td class="px-4 py-2.5 text-xs text-gray-500">{{ $stat->year ?? '—' }}</td>
                        <td class="px-4 py-2.5 text-xs text-gray-500">{{ $stat->sub_group ?? '—' }}</td>
                        <td class="px-4 py-2.5 text-xs font-mono text-gray-600">{{ $stat->order }}</td>
                        <td class="px-4 py-2.5 text-right space-x-3">
                            <a href="{{ route('admin.village-stats.edit', $stat->id) }}" class="text-blue-600 hover:underline text-xs font-bold">Edit</a>
                            <form action="{{ route('admin.village-stats.destroy', $stat->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-4 text-center text-xs text-gray-400">Belum ada data untuk kategori ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

@endsection
