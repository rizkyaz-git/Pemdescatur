@extends('layouts.admin')

@section('title', 'Kelola Berita & Pengumuman')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Daftar Berita & Pengumuman</h3>
            <p class="text-xs text-gray-500 mt-1">Kelola berita kegiatan, publikasi pertanian, dan pengumuman desa.</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition">
            + Tambah Berita Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Gambar</th>
                        <th class="p-4">Judul</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal Publish</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($newsList as $news)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                @if($news->image_path)
                                    <img src="{{ asset('storage/' . $news->image_path) }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-gray-900 max-w-sm">
                                <a href="{{ route('public.news.show', $news->slug) }}" target="_blank" class="hover:text-[#0d631b]">
                                    {{ $news->title }}
                                </a>
                            </td>
                            <td class="p-4 text-xs font-semibold text-gray-600">{{ $news->category }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $news->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($news->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-gray-500">{{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.news.edit', $news->id) }}" class="text-blue-600 hover:underline text-xs font-bold">Edit</a>
                                <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Belum ada berita. Klik tombol "+ Tambah Berita Baru" untuk menambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $newsList->links() }}
        </div>
    </div>
</div>

@endsection
