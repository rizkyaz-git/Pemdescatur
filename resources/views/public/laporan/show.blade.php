@extends('layouts.public')

@section('title', 'Detail Laporan Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Detail dan rekam jejak tanggapan resmi laporan pengaduan Anda oleh Pemerintah Desa Catur.')

@section('content')
<div class="bg-white min-h-screen py-8 sm:py-12 border-b border-slate-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Breadcrumbs & Back Navigation --}}
        <div class="space-y-3">
            <x-breadcrumbs :items="[
                ['label' => 'BERANDA', 'url' => route('home')],
                ['label' => 'Pengaduan Warga', 'url' => route('warga.complaint.index')],
                ['label' => 'Laporan Saya', 'url' => route('pelapor.laporan.index')],
                ['label' => 'Detail Laporan']
            ]" />

            <div class="flex items-center gap-3.5 pt-1">
                <a href="{{ route('pelapor.laporan.index') }}"
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0 active:scale-95"
                   title="Kembali ke Daftar Laporan Saya" aria-label="Kembali">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-[#20332A] tracking-tight">
                        Detail Laporan Pengaduan
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Laporan ID: <span class="font-mono font-semibold text-slate-700">#{{ substr($laporan->id, 0, 8) }}</span> • Diajukan pada {{ $laporan->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>

        {{-- Status Config --}}
        @php
            $statusConfig = match($laporan->status) {
                'pending_verification' => ['label' => 'Menunggu Verifikasi Email', 'bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200/80', 'desc' => 'Periksa email Anda untuk mengonfirmasi laporan ini.'],
                'diterima' => ['label' => 'Laporan Telah Diterima', 'bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200/80', 'desc' => 'Laporan telah diverifikasi dan masuk dalam antrean telaah perangkat desa.'],
                'diproses' => ['label' => 'Sedang Ditindaklanjuti', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-800', 'border' => 'border-indigo-200/80', 'desc' => 'Pemerintah desa sedang melakukan koordinasi dan penanganan teknis di lapangan.'],
                'selesai' => ['label' => 'Selesai & Ditanggapi', 'bg' => 'bg-[#EAF1E8]', 'text' => 'text-[#0A3D29]', 'border' => 'border-[#DCE6DA]', 'desc' => 'Penanganan laporan telah tuntas dan solusi telah diberikan.'],
                'ditolak' => ['label' => 'Ditolak / Tidak Sesuai', 'bg' => 'bg-rose-50', 'text' => 'text-rose-800', 'border' => 'border-rose-200/80', 'desc' => 'Laporan belum dapat ditindaklanjuti karena tidak memenuhi kriteria pelaporan.'],
                default => ['label' => str($laporan->status)->replace('_', ' ')->title(), 'bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'desc' => ''],
            };
        @endphp

        {{-- Status Card --}}
        <div class="p-4 sm:p-5 rounded-2xl border {{ $statusConfig['bg'] }} {{ $statusConfig['border'] }} flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Status Terkini</span>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-current {{ $statusConfig['text'] }}"></span>
                    <h3 class="font-serif font-bold text-base sm:text-lg {{ $statusConfig['text'] }}">
                        {{ $statusConfig['label'] }}
                    </h3>
                </div>
                <p class="text-xs {{ $statusConfig['text'] }} opacity-90">
                    {{ $statusConfig['desc'] }}
                </p>
            </div>

            <div class="shrink-0">
                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-white/80 border border-slate-200/70 text-slate-700">
                    Kategori: {{ $laporan->kategori }}
                </span>
            </div>
        </div>

        {{-- Isi Laporan Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 sm:p-7 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h2 class="font-serif font-bold text-sm sm:text-base text-slate-900">
                    Uraian Pengaduan Warga
                </h2>
                <span class="text-xs text-slate-400">
                    {{ $laporan->created_at->translatedFormat('d M Y') }}
                </span>
            </div>

            <div class="text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line bg-slate-50/50 p-4 sm:p-5 rounded-xl border border-slate-200/60 font-sans">
                {{ $laporan->isi_laporan }}
            </div>

            {{-- Lampiran Berkas if any --}}
            @if($laporan->lampiran)
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider block mb-2">
                        Lampiran Dokumen / Foto Bukti
                    </span>
                    <a href="{{ route('pelapor.laporan.attachment', $laporan->id) }}"
                       class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 text-xs sm:text-sm font-semibold transition shadow-xs">
                        <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh Berkas Lampiran</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- Tanggapan Resmi Pemdes Section --}}
        <div class="space-y-3">
            <h2 class="font-serif font-bold text-lg text-slate-900">
                Tanggapan Resmi Pemerintah Desa Catur
            </h2>

            @forelse($laporan->tanggapans as $tanggapan)
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-3 border-l-4 border-l-[#0A3D29]">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#0A3D29]"></span>
                            <h3 class="font-serif font-bold text-xs sm:text-sm text-slate-900">
                                {{ $tanggapan->admin->name ?? 'Pemerintah Desa Catur' }}
                            </h3>
                        </div>
                        <span class="text-[11px] text-slate-400">
                            {{ $tanggapan->created_at->translatedFormat('d F Y, H:i') }} WIB
                        </span>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line pt-1">
                        {{ $tanggapan->isi_tanggapan }}
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 rounded-2xl border border-slate-200/70 p-6 text-center space-y-2">
                    <div class="w-10 h-10 mx-auto rounded-full bg-white text-slate-400 flex items-center justify-center border border-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-serif font-bold text-sm text-slate-800">Menunggu Tanggapan Resmi</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Laporan Anda telah tercatat dan sedang dalam antrean verifikasi oleh Pemerintah Desa Catur. Anda akan menerima pembaruan berkala.
                    </p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
