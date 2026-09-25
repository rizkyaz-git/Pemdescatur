@extends('layouts.admin')

@section('title', 'Detail Laporan Pengaduan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.complaints.index') }}"
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali ke daftar pengaduan"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Detail Laporan Pengaduan</h1>
    </div>

    <!-- Info Pelapor -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6">
        <h2 class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-4">Informasi Pelapor</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">Nama</dt>
                <dd class="font-semibold text-[#0F172A] mt-0.5">{{ $complaint->nama }}</dd>
            </div>
            <div>
                <dt class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">No. WhatsApp</dt>
                <dd class="font-mono font-semibold text-[#0F172A] mt-0.5">
                    @if($complaint->no_whatsapp)
                        <a href="https://wa.me/{{ $complaint->no_whatsapp }}" target="_blank" rel="noopener noreferrer"
                           class="text-green-700 hover:underline inline-flex items-center gap-1">
                            {{ $complaint->no_whatsapp }}
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @else
                        <span class="text-slate-400">-</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">Kategori</dt>
                <dd class="mt-0.5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                        {{ ucfirst(str_replace('_', ' ', $complaint->kategori)) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">Status</dt>
                <dd class="mt-0.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border {{ $complaint->status_badge_class }}">
                        {{ $complaint->status_label }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">Tanggal Masuk</dt>
                <dd class="text-slate-700 mt-0.5 tabular-nums">
                    {{ optional($complaint->created_at)->format('d F Y, H:i') ?? '-' }}
                    @if($complaint->created_at) WIB @endif
                </dd>
            </div>
        </dl>
    </div>

    <!-- Isi Laporan -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6">
        <h2 class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-3">Isi Laporan</h2>
        <p class="text-sm text-slate-800 leading-relaxed whitespace-pre-line">{{ $complaint->isi_laporan }}</p>

        @if($complaint->lampiran)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-2">Lampiran</p>
                @php
                    $ext = strtolower(pathinfo($complaint->lampiran, PATHINFO_EXTENSION));
                @endphp
                @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                    <a href="{{ asset('storage/' . $complaint->lampiran) }}" target="_blank">
                        <img src="{{ asset('storage/' . $complaint->lampiran) }}"
                             alt="Lampiran pengaduan" class="max-h-60 rounded-lg border border-slate-200 object-cover">
                    </a>
                @else
                    <a href="{{ asset('storage/' . $complaint->lampiran) }}" target="_blank"
                       class="inline-flex items-center gap-2 text-xs font-semibold text-blue-700 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Lihat Lampiran PDF
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Catatan Admin -->
    @if($complaint->catatan_admin)
        <div class="bg-green-50 rounded-[20px] border border-green-200 p-6">
            <h2 class="text-[11px] font-bold text-green-700 uppercase tracking-wider mb-3">Catatan / Tanggapan Admin</h2>
            <p class="text-sm text-green-900 leading-relaxed whitespace-pre-line">{{ $complaint->catatan_admin }}</p>
        </div>
    @endif

    <!-- Action Button -->
    <div class="flex justify-end">
        <a href="{{ route('admin.complaints.edit', $complaint->id) }}"
           class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Tanggapi / Ubah Status
        </a>
    </div>
</div>
@endsection
