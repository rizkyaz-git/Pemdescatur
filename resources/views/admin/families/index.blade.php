@extends('layouts.admin')

@section('title', 'Data Kartu Keluarga (KK)')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">👨‍👩‍👧‍👦 Data Kartu Keluarga</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola data Kartu Keluarga (KK) dan jumlah anggota keluarga Desa Catur.</p>
        </div>
        <a href="{{ route('admin.families.create') }}" class="inline-flex items-center gap-2 bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
            ➕ Tambah KK Baru
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">No. Kartu Keluarga</th>
                        <th class="p-4">Kepala Keluarga</th>
                        <th class="p-4">Alamat Rumah</th>
                        <th class="p-4">Anggota Keluarga</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($families as $family)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 font-mono font-bold text-gray-900">{{ $family->kk_number }}</td>
                            <td class="p-4 font-semibold text-gray-800">{{ $family->head_of_family }}</td>
                            <td class="p-4 text-xs text-gray-600 max-w-xs truncate">{{ $family->address }}</td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    👥 {{ $family->residents ? $family->residents->count() : $family->total_members }} Jiwa
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.families.edit', $family->id) }}" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.families.destroy', $family->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data KK ini beserta seluruh anggota keluarganya?')">
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
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Belum ada data Kartu Keluarga. Klik tombol <strong>Tambah KK Baru</strong> di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($families->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $families->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
