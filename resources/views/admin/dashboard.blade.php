@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan Admin')

@section('content')

<div class="space-y-8">
    
    <!-- Top Greeting Banner -->
    <div class="bg-gradient-to-r from-[#0d631b] to-[#0a4f15] text-white p-6 sm:p-8 rounded-2xl shadow-md border-b-4 border-[#fea619]">
        <h2 class="font-serif text-2xl sm:text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-emerald-100 text-sm mt-1">
            Panel Kelola Website Profil Desa Catur, Sambi, Boyolali. Gunakan menu sidebar untuk memperbarui data desa.
        </p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.residents.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4 hover:border-emerald-500 transition">
            <div class="w-12 h-12 bg-emerald-100 text-[#0d631b] rounded-xl flex items-center justify-center text-2xl font-bold">
                👥
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Total Penduduk</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['residents_count'] ?? 0 }} Jiwa</h3>
            </div>
        </a>

        <a href="{{ route('admin.families.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4 hover:border-emerald-500 transition">
            <div class="w-12 h-12 bg-teal-100 text-teal-800 rounded-xl flex items-center justify-center text-2xl font-bold">
                👨‍👩‍👧‍👦
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Kartu Keluarga</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['families_count'] ?? 0 }} KK</h3>
            </div>
        </a>

        <a href="{{ route('admin.letter-requests.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4 hover:border-emerald-500 transition">
            <div class="w-12 h-12 bg-amber-100 text-amber-800 rounded-xl flex items-center justify-center text-2xl font-bold">
                📨
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Surat Pending</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['pending_letters_count'] ?? 0 }} Permohonan</h3>
            </div>
        </a>

        <a href="{{ route('admin.complaints.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4 hover:border-emerald-500 transition">
            <div class="w-12 h-12 bg-rose-100 text-rose-800 rounded-xl flex items-center justify-center text-2xl font-bold">
                📢
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Pengaduan Baru</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['new_complaints_count'] ?? 0 }} Laporan</h3>
            </div>
        </a>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-[#0d631b] rounded-xl flex items-center justify-center text-2xl font-bold">
                📰
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Total Berita</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['news_count'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-[#855300] rounded-xl flex items-center justify-center text-2xl font-bold">
                🏛️
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Perangkat Desa</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['officials_count'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-800 rounded-xl flex items-center justify-center text-2xl font-bold">
                📊
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Item Statistik</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['statistics_count'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 text-purple-800 rounded-xl flex items-center justify-center text-2xl font-bold">
                🖼️
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Foto Galeri</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $stats['galleries_count'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Latest News Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-serif text-lg font-bold text-gray-800">Berita Terbaru yang Diterbitkan</h3>
            <a href="{{ route('admin.news.create') }}" class="bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                + Tambah Berita Baru
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">Judul</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal Publikasi</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($latestNews as $news)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-900 max-w-xs truncate">{{ $news->title }}</td>
                            <td class="p-4 text-xs font-medium text-gray-600">{{ $news->category }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $news->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($news->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-gray-500">{{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.news.edit', $news->id) }}" class="text-blue-600 hover:underline font-semibold text-xs">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada data berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
