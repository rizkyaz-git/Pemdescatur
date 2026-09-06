@extends('layouts.public')

@section('title', 'Detail Tanggapan Pengaduan - Desa Catur')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl font-bold text-gray-900">📢 Detail Pengaduan & Tanggapan</h1>
                <p class="text-xs text-gray-500 mt-1">Tiket: <strong class="font-mono text-emerald-800">{{ $complaint->ticket_number }}</strong></p>
            </div>
            <a href="{{ route('warga.complaint.index') }}" class="inline-flex items-center gap-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold px-4 py-2 rounded-xl transition">
                ⬅️ Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="px-3 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-800">
                    📁 {{ $complaint->category ? $complaint->category->name : 'Kategori Umum' }}
                </span>
                <span class="text-xs text-gray-500 font-medium">
                    🕒 {{ $complaint->created_at ? $complaint->created_at->format('d F Y, H:i') : '-' }} WIB
                </span>
            </div>

            <div>
                <h2 class="font-bold text-xl text-gray-900 mb-3">{{ $complaint->title }}</h2>
                <div class="prose prose-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="whitespace-pre-line">{{ $complaint->description }}</p>
                </div>
            </div>

            @if($complaint->attachment_path)
                <div>
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Lampiran Bukti Foto:</p>
                    <a href="{{ asset('storage/' . $complaint->attachment_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $complaint->attachment_path) }}" alt="Lampiran Pengaduan" class="max-h-64 rounded-xl border border-gray-300 shadow-xs hover:opacity-90 transition">
                    </a>
                </div>
            @endif

            <!-- Status Badge -->
            <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase">Status Penanganan:</span>
                <div>
                    @if($complaint->status === 'new')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">🔴 Laporan Baru (Menunggu Respon)</span>
                    @elseif($complaint->status === 'processing')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">🟡 Sedang Ditindaklanjuti</span>
                    @else
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">🟢 Selesai Ditanggapi</span>
                    @endif
                </div>
            </div>

            <!-- Admin Response -->
            @if($complaint->admin_response)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 space-y-2">
                    <div class="flex items-center justify-between border-b border-emerald-200 pb-2">
                        <h3 class="font-bold text-sm text-emerald-900">💬 Tanggapan Resmi Pemerintah Desa Catur</h3>
                        <span class="text-xs text-emerald-700">{{ $complaint->responded_at ? \Carbon\Carbon::parse($complaint->responded_at)->format('d/m/Y H:i') : '' }}</span>
                    </div>
                    <p class="text-sm text-emerald-800 whitespace-pre-line leading-relaxed">{{ $complaint->admin_response }}</p>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                    <p class="text-xs font-semibold text-amber-800">⏳ Laporan Anda telah diterima dan akan segera ditanggapi oleh tim Pemerintah Desa Catur.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
