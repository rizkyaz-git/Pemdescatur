@extends('layouts.admin')

@section('title', 'Proses Permohonan Surat')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.letter-requests.index') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Proses Permohonan Surat</h1>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.letter-requests.update', $request->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Keputusan Status Permohonan <span class="text-rose-500">*</span>
                </label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 font-semibold @error('status') border-rose-500 @enderror">
                    <option value="approved" {{ old('status', $request->status) == 'approved' ? 'selected' : '' }}>Setujui Permohonan (Approved)</option>
                    <option value="rejected" {{ old('status', $request->status) == 'rejected' ? 'selected' : '' }}>Tolak Permohonan (Rejected)</option>
                    <option value="pending" {{ old('status', $request->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Review)</option>
                </select>
                @error('status')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_notes" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Catatan Verifikator / Pesan Keterangan Ke Warga
                </label>
                <textarea name="admin_notes" id="admin_notes" rows="3"
                    placeholder="Contoh: Surat keterangan telah ditandatangani Kepala Desa dan siap diunduh."
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 @error('admin_notes') border-rose-500 @enderror">{{ old('admin_notes', $request->admin_notes) }}</textarea>
                @error('admin_notes')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2 p-5 bg-[#F8FAFC] rounded-2xl border border-[#E2E8F0]">
                <label for="result_file_path" class="block text-[13px] font-semibold text-[#1E293B] mb-1">
                    Upload Berkas Surat Hasil / TTD Resmi (PDF)
                </label>
                <input type="file" name="result_file_path" id="result_file_path" accept=".pdf"
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0F4C3A] hover:file:bg-emerald-100 cursor-pointer @error('result_file_path') border-rose-500 @enderror">
                <p class="text-[11px] text-slate-500">Format PDF, maksimal ukuran 5MB.</p>
                @if($request->result_file_path)
                    <div class="mt-2 flex items-center gap-2 text-xs text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Berkas saat ini: <code class="font-mono text-[11px]">{{ basename($request->result_file_path) }}</code></span>
                    </div>
                @endif
                @error('result_file_path')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                <a href="{{ route('admin.letter-requests.index') }}" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Keputusan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
