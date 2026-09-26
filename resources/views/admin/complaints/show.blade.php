@extends('layouts.admin')

@section('title', 'Detail Pengaduan Warga')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.complaints.index', ['tab' => request('tab') === 'riwayat' ? 'riwayat' : 'baru']) }}"
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali ke daftar pengaduan"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Detail Pengaduan Warga</h1>
    </div>

    {{-- Informasi pengaduan (read-only) --}}
    <div class="rounded-2xl border border-[#E2E8F0] bg-white shadow-xs p-5 sm:p-6">
        <h2 class="border-b border-[#F1F5F9] pb-3 font-jakarta text-base font-bold text-[#0F172A]">Informasi Pengaduan</h2>

        <dl class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 text-sm sm:grid-cols-2">
            <div class="min-w-0">
                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Nama Pelapor</dt>
                <dd class="mt-1 break-words font-semibold text-[#0F172A]">{{ $complaint->nama }}</dd>
            </div>

            <div class="min-w-0">
                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Nomor WhatsApp</dt>
                <dd class="mt-1 break-words font-mono text-slate-700">
                    @if($complaint->whatsapp_url)
                        <a href="{{ $complaint->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1 font-semibold text-[#0F4C3A] hover:underline"
                           title="Hubungi {{ $complaint->nama }} melalui WhatsApp">
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

            <div class="min-w-0">
                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Kategori</dt>
                <dd class="mt-1 break-words font-medium text-[#0F172A]">{{ $complaint->kategori_label }}</dd>
            </div>

            <div class="min-w-0">
                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Tanggal Masuk</dt>
                <dd class="mt-1 break-words text-slate-700 tabular-nums">
                    {{ $complaint->created_at ? $complaint->created_at->format('d/m/Y H:i') : '-' }}
                </dd>
            </div>

            <div class="min-w-0 sm:col-span-2">
                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Isi Laporan</dt>
                <dd class="mt-1 whitespace-pre-line break-words leading-relaxed text-slate-700">{{ $complaint->isi_laporan }}</dd>
            </div>

            @if($complaint->lampiran)
                <div class="min-w-0 sm:col-span-2">
                    <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Lampiran</dt>
                    <dd class="mt-2">
                        @php
                            $extension = strtolower(pathinfo($complaint->lampiran, PATHINFO_EXTENSION));
                        @endphp
                        @if(in_array($extension, ['jpg', 'jpeg', 'png'], true))
                            <a href="{{ asset('storage/' . $complaint->lampiran) }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('storage/' . $complaint->lampiran) }}"
                                     alt="Lampiran pengaduan {{ $complaint->nama }}"
                                     class="max-h-60 rounded-lg border border-slate-200 object-cover">
                            </a>
                        @else
                            <a href="{{ asset('storage/' . $complaint->lampiran) }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 text-xs font-semibold text-blue-700 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Lihat Lampiran
                            </a>
                        @endif
                    </dd>
                </div>
            @endif
        </dl>
    </div>

    {{-- Aksi: satu-satunya langkah workflow setelah menghubungi pelapor via WhatsApp --}}
    <div class="flex justify-end">
        @if($complaint->isCompleted())
            <span class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs font-bold text-emerald-800">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                Pengaduan ini sudah selesai
            </span>
        @else
            <form method="POST" action="{{ route('admin.complaints.complete', $complaint->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] px-4 py-2.5 text-xs font-bold text-white shadow-xs transition active:scale-95 cursor-pointer"
                        title="Tandai pengaduan ini selesai">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Tandai sebagai Selesai</span>
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
