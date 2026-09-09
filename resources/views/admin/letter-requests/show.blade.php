@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.letter-requests.index') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Detail Permohonan Surat</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 space-y-5">
                <h3 class="font-jakarta font-bold text-base text-[#0F172A] border-b border-[#F1F5F9] pb-3">Informasi Permohonan</h3>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Jenis Surat</p>
                        <p class="font-semibold text-[#0F172A] mt-1">{{ $request->template ? ($request->template->title ?? $request->template->name) : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Tanggal Pengajuan</p>
                        <p class="font-semibold text-[#0F172A] tabular-nums mt-1">{{ $request->created_at ? $request->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Nama Pemohon</p>
                        <p class="font-semibold text-[#0F172A] mt-1">{{ $request->user ? $request->user->name : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Email Pemohon</p>
                        <p class="font-mono text-xs text-slate-700 mt-1">{{ $request->user ? $request->user->email : '-' }}</p>
                    </div>
                </div>

                @if($request->form_data)
                    <div class="pt-4 border-t border-[#F1F5F9]">
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-2">Data Form Yang Diisi Pemohon</p>
                        <div class="bg-[#F8FAFC] border border-[#E2E8F0] p-4 rounded-xl text-xs font-mono overflow-x-auto space-y-1.5">
                            @if(is_array($request->form_data))
                                @foreach($request->form_data as $key => $val)
                                    <p><strong class="text-[#0F4C3A]">{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</p>
                                @endforeach
                            @else
                                <pre>{{ json_encode($request->form_data, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            @if($request->result_file_path)
                <div class="bg-emerald-50/70 border border-emerald-200 rounded-[20px] p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <p class="text-sm font-bold text-emerald-900">File Surat Hasil Telah Diterbitkan</p>
                        </div>
                        <p class="text-xs text-emerald-700 mt-1">Dokumen surat resmi (PDF) telah diunggah dan siap diunduh oleh warga pemohon.</p>
                    </div>
                    <a href="{{ asset('storage/' . $request->result_file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Unduh PDF Surat</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Action Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 space-y-4">
                <h3 class="font-jakarta font-bold text-base text-[#0F172A] border-b border-[#F1F5F9] pb-3">Status Verifikasi</h3>
                
                <div>
                    @if($request->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-amber-50 text-amber-800 border border-amber-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            <span>Menunggu Review</span>
                        </span>
                    @elseif($request->status === 'approved')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-[#DCFCE7] text-[#15803D]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                            <span>Disetujui</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>Ditolak</span>
                        </span>
                    @endif
                </div>

                @if($request->admin_notes)
                    <div class="bg-[#F8FAFC] p-3.5 rounded-xl border border-[#E2E8F0] text-xs">
                        <p class="font-bold text-slate-700 mb-1">Catatan Verifikator:</p>
                        <p class="text-slate-600 leading-relaxed">{{ $request->admin_notes }}</p>
                    </div>
                @endif

                <div class="pt-2">
                    <a href="{{ route('admin.letter-requests.edit', $request->id) }}" class="inline-flex items-center justify-center gap-2 w-full bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold py-2.5 rounded-xl shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Ubah Status / Upload Surat</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
