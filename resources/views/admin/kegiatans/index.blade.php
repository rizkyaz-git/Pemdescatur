@extends('layouts.admin')

@section('title', 'Kelola Kegiatan PPK Ormawa')

@section('content')
<div class="space-y-6">

    <!-- Flash Alert Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Top Card / Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#D9B85C]/20 text-[#7A5A00] border border-[#D9B85C]/30">PPKO Catur Cerdas</span>
                <span class="text-xs text-gray-500">• 5 Pojok Pemberdayaan</span>
            </div>
            <h3 class="font-serif font-bold text-xl text-gray-900 mt-1">Daftar Kegiatan & Dokumentasi</h3>
            <p class="text-xs text-gray-500 mt-0.5">Kelola agenda, dokumentasi foto galeri, dan rilis kegiatan PPK Ormawa Desa Catur.</p>
        </div>
        <a href="{{ route('admin.kegiatans.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Kegiatan Baru</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <form method="GET" action="{{ route('admin.kegiatans.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul kegiatan..." class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 px-3 py-2">
            </div>
            <div class="sm:col-span-4">
                <select name="pojok_id" class="w-full text-xs rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 px-3 py-2">
                    <option value="">Semua Pojok Pemberdayaan</option>
                    @foreach($pojoks as $p)
                        <option value="{{ $p->id }}" {{ request('pojok_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold py-2 px-3 rounded-lg transition">
                    Filter
                </button>
                @if(request()->filled('q') || request()->filled('pojok_id'))
                    <a href="{{ route('admin.kegiatans.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium py-2 px-3 rounded-lg transition flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Kegiatan -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="p-4">Thumbnail</th>
                        <th class="p-4">Judul & Pojok</th>
                        <th class="p-4">Tanggal Pelaksanaan</th>
                        <th class="p-4 text-center">Foto Galeri</th>
                        <th class="p-4">Dibuat Oleh</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kegiatans as $kegiatan)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="p-4">
                                @if($kegiatan->thumbnail)
                                    <img src="{{ asset('storage/' . $kegiatan->thumbnail) }}" alt="{{ $kegiatan->judul }}" class="w-14 h-12 rounded-lg object-cover border border-gray-200 shadow-2xs">
                                @else
                                    <div class="w-14 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs font-medium border border-dashed border-slate-300">
                                        No Image
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 max-w-sm">
                                <a href="{{ route('admin.kegiatans.show', $kegiatan) }}" class="font-bold text-gray-900 hover:text-[#0d631b] transition block leading-snug line-clamp-2">
                                    {{ $kegiatan->judul }}
                                </a>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $kegiatan->pojok->nama ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-xs text-gray-600 whitespace-nowrap">
                                <span class="font-medium text-gray-900">{{ $kegiatan->tanggal_kegiatan->translatedFormat('d M Y') }}</span>
                                <span class="block text-[11px] text-gray-400 mt-0.5">{{ $kegiatan->tanggal_kegiatan->diffForHumans() }}</span>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.kegiatans.show', $kegiatan) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $kegiatan->galeri_fotos_count > 0 ? 'bg-blue-50 text-blue-700 hover:bg-blue-100' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }} transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $kegiatan->galeri_fotos_count }} Foto</span>
                                </a>
                            </td>
                            <td class="p-4 text-xs text-gray-600 whitespace-nowrap">
                                <span class="font-medium text-gray-800">{{ $kegiatan->creator->name ?? 'Admin' }}</span>
                                <span class="block text-[11px] text-gray-400">{{ $kegiatan->creator->role_label ?? '' }}</span>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('admin.kegiatans.show', $kegiatan) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-md transition">
                                    <span>Kelola Galeri</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                                <a href="{{ route('admin.kegiatans.edit', $kegiatan) }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold px-2 py-1.5 rounded-md hover:bg-blue-50 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kegiatans.destroy', $kegiatan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini? Semua foto galeri terkait juga akan dihapus permanen.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold px-2 py-1.5 rounded-md hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">Belum ada kegiatan PPKO</h4>
                                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Mulai tambahkan kegiatan pemberdayaan masyarakat dan dokumentasikan melalui galeri foto.</p>
                                <a href="{{ route('admin.kegiatans.create') }}" class="inline-flex items-center gap-1.5 mt-4 bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2 rounded-lg transition shadow-xs">
                                    <span>+ Tambah Kegiatan Pertama</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kegiatans->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $kegiatans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
