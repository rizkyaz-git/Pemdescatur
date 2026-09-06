@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">📄 Detail Permohonan Surat</h1>
            <p class="text-xs text-gray-500 mt-1">Nomor Tiket: <strong class="font-mono text-emerald-800">{{ $request->ticket_number }}</strong></p>
        </div>
        <a href="{{ route('admin.letter-requests.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 space-y-4">
                <h3 class="font-bold text-base text-gray-900 border-b border-gray-100 pb-3">Informasi Permohonan</h3>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase">Jenis Surat</p>
                        <p class="font-bold text-gray-800">{{ $request->template ? ($request->template->title ?? $request->template->name) : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase">Tanggal Pengajuan</p>
                        <p class="font-bold text-gray-800">{{ $request->created_at ? $request->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase">Nama Pemohon</p>
                        <p class="font-bold text-gray-800">{{ $request->user ? $request->user->name : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase">Email Pemohon</p>
                        <p class="font-bold text-gray-800">{{ $request->user ? $request->user->email : '-' }}</p>
                    </div>
                </div>

                @if($request->form_data)
                    <div class="pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold uppercase mb-2">Data Form Yang Diisi Pemohon</p>
                        <div class="bg-gray-50 p-4 rounded-lg text-xs font-mono overflow-x-auto space-y-1">
                            @if(is_array($request->form_data))
                                @foreach($request->form_data as $key => $val)
                                    <p><strong class="text-gray-700">{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</p>
                                @endforeach
                            @else
                                <pre>{{ json_encode($request->form_data, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            @if($request->result_file_path)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-emerald-900">📄 File Hasil Surat Telah Diunggah</p>
                        <p class="text-xs text-emerald-700 mt-0.5">Surat hasil dalam format PDF siap diunduh warga.</p>
                    </div>
                    <a href="{{ asset('storage/' . $request->result_file_path) }}" target="_blank" class="bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                        ⬇️ Unduh PDF Surat
                    </a>
                </div>
            @endif
        </div>

        <!-- Action Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 space-y-4">
                <h3 class="font-bold text-base text-gray-900 border-b border-gray-100 pb-3">Status Permohonan</h3>
                
                <div>
                    @if($request->status === 'pending')
                        <span class="inline-block px-3 py-1.5 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Menunggu Review Admin</span>
                    @elseif($request->status === 'approved')
                        <span class="inline-block px-3 py-1.5 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Disetujui</span>
                    @else
                        <span class="inline-block px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-800">Ditolak</span>
                    @endif
                </div>

                @if($request->admin_notes)
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-xs">
                        <p class="font-bold text-gray-700 mb-1">Catatan Admin:</p>
                        <p class="text-gray-600">{{ $request->admin_notes }}</p>
                    </div>
                @endif

                <div class="pt-2">
                    <a href="{{ route('admin.letter-requests.edit', $request->id) }}" class="block w-full text-center bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-bold py-2.5 rounded-lg shadow-sm transition">
                        ⚡ Ubah Status / Upload Surat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
