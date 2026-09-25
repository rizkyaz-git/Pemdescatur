@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.letter-requests.index', ['tab' => request('tab') === 'riwayat' ? 'riwayat' : 'baru']) }}"
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
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-[#E2E8F0] bg-white shadow-xs p-5 sm:p-6">
                <h2 class="border-b border-[#F1F5F9] pb-3 font-jakarta text-base font-bold text-[#0F172A]">Informasi Pemohon</h2>

                <dl class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 text-sm sm:grid-cols-2">
                    <div class="min-w-0">
                        <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Nama Lengkap</dt>
                        <dd class="mt-1 break-words font-semibold text-[#0F172A]">
                            {{ data_get($request->form_data, 'nama', data_get($request->form_data, 'nama_pemohon', '-')) }}
                        </dd>
                    </div>

                    <div class="min-w-0">
                        <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">NIK</dt>
                        <dd class="mt-1 break-words font-mono text-slate-700">{{ data_get($request->form_data, 'nik', '-') }}</dd>
                    </div>

                    <div class="min-w-0">
                        <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Nomor WhatsApp Aktif</dt>
                        <dd class="mt-1 break-words font-mono text-slate-700">{{ data_get($request->form_data, 'telepon', '-') }}</dd>
                    </div>

                    <div class="min-w-0">
                        <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Jenis Surat</dt>
                        <dd class="mt-1 break-words font-semibold text-[#0F172A]">
                            @if(data_get($request->form_data, 'jenis_surat_lainnya'))
                                {{ data_get($request->form_data, 'jenis_surat_lainnya') }}
                            @else
                                {{ $request->template ? ($request->template->title ?? $request->template->name) : '-' }}
                            @endif
                        </dd>
                    </div>

                    <div class="min-w-0 sm:col-span-2">
                        <dt class="text-[11px] font-bold uppercase tracking-wider text-[#64748B]">Keperluan / Keterangan Permohonan</dt>
                        <dd class="mt-1 whitespace-pre-line break-words leading-relaxed text-slate-700">{{ data_get($request->form_data, 'keperluan', '-') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div>
            <div class="rounded-2xl border border-[#E2E8F0] bg-white shadow-xs p-5 sm:p-6">
                <h2 class="border-b border-[#F1F5F9] pb-3 font-jakarta text-base font-bold text-[#0F172A]">Status Pengerjaan</h2>

                <div class="mt-5">
                    @if($request->isCompleted())
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                            Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                            Belum Selesai
                        </span>

                        <form method="POST" action="{{ route('admin.letter-requests.complete', $request->id) }}" class="mt-5">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0F4C3A] px-4 py-2.5 text-xs font-bold text-white shadow-xs transition hover:bg-[#072C21] active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Tandai sebagai Selesai</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
