@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h3 class="font-serif font-bold text-xl text-gray-900">Galeri Foto Kegiatan Desa</h3>
            <p class="text-xs text-gray-500 mt-1">Upload dan kelola foto dokumentasi kegiatan Desa Catur.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-md transition">
            + Upload Foto Baru
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galleries as $gal)
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-gray-100 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $gal->image_path) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 space-y-1">
                        <h4 class="font-serif font-bold text-sm text-gray-900 line-clamp-1">{{ $gal->title }}</h4>
                        @if($gal->description)
                            <p class="text-xs text-gray-500 line-clamp-2">{{ $gal->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="p-4 pt-0 border-t border-gray-100 flex justify-between items-center text-xs">
                    <span class="text-gray-400">{{ $gal->published_at ? $gal->published_at->format('d/m/Y') : '' }}</span>
                    <div class="space-x-2">
                        <a href="{{ route('admin.galleries.edit', $gal->id) }}" class="text-blue-600 hover:underline font-bold">Edit</a>
                        <form action="{{ route('admin.galleries.destroy', $gal->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto galeri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 bg-white rounded-xl text-center text-gray-500 border border-gray-200">
                Belum ada foto galeri. Klik "+ Upload Foto Baru" untuk menambahkan.
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $galleries->links() }}
    </div>
</div>

@endsection
