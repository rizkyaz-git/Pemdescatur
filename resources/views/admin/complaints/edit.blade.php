@extends('layouts.admin')

@section('title', 'Tanggapi Pengaduan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3.5">
        <a href="{{ route('admin.complaints.index') }}" 
           class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] hover:bg-slate-50 hover:border-slate-300 text-slate-700 flex items-center justify-center transition shadow-xs shrink-0"
           title="Kembali"
           aria-label="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Tanggapi Pengaduan Warga</h1>
    </div>

    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs p-6 sm:p-8">
        <!-- Summary of Complaint -->
        <div class="bg-[#F8FAFC] p-4 rounded-xl border border-[#E2E8F0] mb-6 space-y-2">
            <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Subjek Pengaduan:</span>
            <p class="font-bold text-base text-[#0F172A]">{{ $complaint->title }}</p>
            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ $complaint->description }}</p>
        </div>

        <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Status Penanganan Pengaduan <span class="text-rose-500">*</span>
                </label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2.5 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 font-semibold @error('status') border-rose-500 @enderror">
                    <option value="new" {{ old('status', $complaint->status) == 'new' ? 'selected' : '' }}>Baru / Belum Ditanggapi</option>
                    <option value="processing" {{ old('status', $complaint->status) == 'processing' ? 'selected' : '' }}>Sedang Ditindaklanjuti (Processing)</option>
                    <option value="resolved" {{ old('status', $complaint->status) == 'resolved' ? 'selected' : '' }}>Selesai Ditanggapi (Resolved)</option>
                </select>
                @error('status')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_response" class="block text-[13px] font-semibold text-[#1E293B] mb-1.5">
                    Tanggapan / Jawaban Resmi Pemerintah Desa
                </label>
                <textarea name="admin_response" id="admin_response" rows="6"
                    placeholder="Tuliskan tindak lanjut atau tanggapan resmi dari Pemerintah Desa Catur..."
                    class="w-full px-4 py-3 rounded-xl border border-[#E2E8F0] focus:ring-2 focus:ring-[#0F4C3A]/20 focus:border-[#0F4C3A] text-sm bg-[#F8FAFC]/40 text-slate-900 leading-relaxed @error('admin_response') border-rose-500 @enderror">{{ old('admin_response', $complaint->admin_response) }}</textarea>
                @error('admin_response')
                    <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#F1F5F9]">
                <a href="{{ route('admin.complaints.index') }}" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Tanggapan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
