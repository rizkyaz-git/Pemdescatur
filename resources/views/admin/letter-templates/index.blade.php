@extends('layouts.admin')

@section('title', 'Template Surat Desa')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">📑 Template Surat Layanan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola jenis dan format template surat administrasi desa.</p>
        </div>
        <a href="{{ route('admin.letter-templates.create') }}" class="inline-flex items-center gap-2 bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
            ➕ Tambah Template Baru
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Kode Surat</th>
                        <th class="p-4">Nama Template</th>
                        <th class="p-4">Keterangan / Persyaratan</th>
                        <th class="p-4">Total Permohonan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($templates as $template)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 font-mono font-bold text-emerald-700">{{ $template->code }}</td>
                            <td class="p-4 font-semibold text-gray-900">{{ $template->title ?? $template->name }}</td>
                            <td class="p-4 text-xs text-gray-600 max-w-sm truncate">{{ $template->description ?? '-' }}</td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    📩 {{ $template->requests_count }} Pemohon
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.letter-templates.edit', $template->id) }}" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    ✏️ Edit Format
                                </a>
                                <form action="{{ route('admin.letter-templates.destroy', $template->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template surat ini?')">
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
                                Belum ada template surat. Klik tombol <strong>Tambah Template Baru</strong> di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($templates->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
