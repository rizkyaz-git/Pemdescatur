@extends('layouts.admin')

@section('title', 'Detail Pengaduan Warga')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">📢 Detail Laporan Pengaduan</h1>
            <p class="text-xs text-gray-500 mt-1">Tiket: <strong class="font-mono text-emerald-800">{{ $complaint->ticket_number }}</strong></p>
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-800">
                        📁 {{ $complaint->category ? $complaint->category->name : 'Kategori Umum' }}
                    </span>
                    <span class="text-xs text-gray-500 font-medium">
                        🕒 {{ $complaint->created_at ? $complaint->created_at->format('d F Y, H:i') : '-' }} WIB
                    </span>
                </div>

                <h2 class="font-bold text-xl text-gray-900">{{ $complaint->title }}</h2>

                <div class="prose prose-sm text-gray-700 max-w-none bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="whitespace-pre-line">{{ $complaint->description }}</p>
                </div>

                @if($complaint->location)
                    <div class="flex items-center gap-2 text-xs text-gray-600">
                        <span>📍 <strong>Lokasi Kejadian:</strong> {{ $complaint->location }}</span>
                    </div>
                @endif

                @if($complaint->attachment_path)
                    <div class="pt-3 border-t border-gray-100">
                        <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Lampiran Bukti Foto:</p>
                        <a href="{{ asset('storage/' . $complaint->attachment_path) }}" target="_blank" class="inline-block group">
                            <img src="{{ asset('storage/' . $complaint->attachment_path) }}" alt="Lampiran Foto" class="max-h-64 rounded-xl border border-gray-300 shadow-xs group-hover:opacity-90 transition">
                        </a>
                    </div>
                @endif
            </div>

            <!-- Admin Response Card if already answered -->
            @if($complaint->admin_response)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 space-y-2">
                    <div class="flex items-center justify-between border-b border-emerald-200 pb-2">
                        <h3 class="font-bold text-sm text-emerald-900">💬 Tanggapan Resmi Pemerintah Desa</h3>
                        <span class="text-xs text-emerald-700">{{ $complaint->responded_at ? \Carbon\Carbon::parse($complaint->responded_at)->format('d/m/Y H:i') : '' }}</span>
                    </div>
                    <p class="text-sm text-emerald-800 whitespace-pre-line">{{ $complaint->admin_response }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Info Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 space-y-4">
                <h3 class="font-bold text-base text-gray-900 border-b border-gray-100 pb-3">Informasi Pelapor</h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-gray-500 font-semibold uppercase">Nama Pelapor</p>
                        <p class="font-bold text-gray-800 text-sm">
                            @if($complaint->is_anonymous)
                                🕵️ Anonim (Disembunyikan)
                            @else
                                {{ $complaint->user ? $complaint->user->name : 'Warga Umum' }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-semibold uppercase">Status Laporan</p>
                        <div class="mt-1">
                            @if($complaint->status === 'new')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Laporan Baru</span>
                            @elseif($complaint->status === 'processing')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Dalam Penanganan</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Selesai Ditanggapi</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.complaints.edit', $complaint->id) }}" class="block w-full text-center bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-bold py-2.5 rounded-lg shadow-sm transition">
                        💬 Berikan Tanggapan / Update Status
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
