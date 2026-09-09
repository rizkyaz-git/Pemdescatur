@extends('layouts.admin')

@section('title', 'Detail Pengaduan Warga')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/60 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <span>Aspirasi & Transparansi Publik</span>
            </div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Detail Laporan Pengaduan</h1>
            <p class="text-xs text-[#64748B] mt-1">Tiket: <strong class="font-mono text-[#0F4C3A] tabular-nums font-bold">{{ $complaint->ticket_number }}</strong></p>
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl border border-[#E2E8F0] transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                        {{ $complaint->category ? $complaint->category->name : 'Kategori Umum' }}
                    </span>
                    <span class="text-xs text-slate-500 tabular-nums">
                        {{ $complaint->created_at ? $complaint->created_at->format('d F Y, H:i') : '-' }} WIB
                    </span>
                </div>

                <h2 class="font-jakarta font-bold text-xl text-[#0F172A]">{{ $complaint->title }}</h2>

                <div class="text-sm text-slate-700 bg-[#F8FAFC] p-4 rounded-xl border border-[#E2E8F0] leading-relaxed">
                    <p class="whitespace-pre-line">{{ $complaint->description }}</p>
                </div>

                @if($complaint->location)
                    <div class="flex items-center gap-2 text-xs text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-[#E2E8F0]">
                        <svg class="w-4 h-4 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span><strong>Lokasi:</strong> {{ $complaint->location }}</span>
                    </div>
                @endif

                @if($complaint->attachment_path)
                    <div class="pt-3 border-t border-[#F1F5F9]">
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-2">Lampiran Bukti Foto:</p>
                        <a href="{{ asset('storage/' . $complaint->attachment_path) }}" target="_blank" class="inline-block group">
                            <img src="{{ asset('storage/' . $complaint->attachment_path) }}" alt="Lampiran Foto" class="max-h-64 rounded-xl border border-[#E2E8F0] shadow-xs group-hover:opacity-90 transition">
                        </a>
                    </div>
                @endif
            </div>

            <!-- Admin Response Card if already answered -->
            @if($complaint->admin_response)
                <div class="bg-emerald-50/70 border border-emerald-200 rounded-[20px] p-6 space-y-2">
                    <div class="flex items-center justify-between border-b border-emerald-200/80 pb-2">
                        <h3 class="font-jakarta font-bold text-sm text-emerald-900">Tanggapan Resmi Pemerintah Desa</h3>
                        <span class="text-xs text-emerald-700 tabular-nums">{{ $complaint->responded_at ? \Carbon\Carbon::parse($complaint->responded_at)->format('d/m/Y H:i') : '' }}</span>
                    </div>
                    <p class="text-sm text-emerald-900 whitespace-pre-line leading-relaxed">{{ $complaint->admin_response }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Info Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 space-y-4">
                <h3 class="font-jakarta font-bold text-base text-[#0F172A] border-b border-[#F1F5F9] pb-3">Informasi Pelapor</h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Identitas Pelapor</p>
                        <p class="font-bold text-[#0F172A] text-sm mt-1">
                            @if($complaint->is_anonymous)
                                <span class="text-slate-500 font-medium">Anonim (Dirahasiakan Warga)</span>
                            @else
                                {{ $complaint->user ? $complaint->user->name : 'Warga Umum' }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Status Penanganan</p>
                        <div class="mt-1.5">
                            @if($complaint->status === 'new')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                    <span>Laporan Baru</span>
                                </span>
                            @elseif($complaint->status === 'processing')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-800 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span>Dalam Penanganan</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-[#DCFCE7] text-[#15803D]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                                    <span>Selesai Ditanggapi</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#F1F5F9]">
                    <a href="{{ route('admin.complaints.edit', $complaint->id) }}" class="inline-flex items-center justify-center gap-2 w-full bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold py-2.5 rounded-xl shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>Berikan Tanggapan / Update Status</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
