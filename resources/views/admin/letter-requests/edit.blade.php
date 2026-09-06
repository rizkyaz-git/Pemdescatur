@extends('layouts.admin')

@section('title', 'Proses Permohonan Surat')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">⚡ Proses Permohonan Surat</h1>
            <p class="text-xs text-gray-500 mt-1">Tiket: <strong class="font-mono text-emerald-800">{{ $request->ticket_number }}</strong></p>
        </div>
        <a href="{{ route('admin.letter-requests.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.letter-requests.update', $request->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Keputusan Status Permohonan <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-semibold @error('status') border-red-500 @enderror">
                    <option value="approved" {{ old('status', $request->status) == 'approved' ? 'selected' : '' }}>✅ Setujui Permohonan (Approved)</option>
                    <option value="rejected" {{ old('status', $request->status) == 'rejected' ? 'selected' : '' }}>❌ Tolak Permohonan (Rejected)</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_notes" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Catatan Admin / Pesan Keterangan Ke Warga
                </label>
                <textarea name="admin_notes" id="admin_notes" rows="3"
                    placeholder="Contoh: Surat telah ditandatangani Kepala Desa dan siap diunduh."
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('admin_notes') border-red-500 @enderror">{{ old('admin_notes', $request->admin_notes) }}</textarea>
                @error('admin_notes')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="result_file_path" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Upload File Surat Hasil / Ttd Digital (PDF)
                </label>
                <input type="file" name="result_file_path" id="result_file_path" accept=".pdf"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm bg-gray-50 @error('result_file_path') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format PDF, maksimal ukuran 5MB.</p>
                @if($request->result_file_path)
                    <p class="text-xs text-emerald-700 mt-1">✓ File saat ini: <code>{{ $request->result_file_path }}</code></p>
                @endif
                @error('result_file_path')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.letter-requests.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold shadow-sm transition">
                    💾 Simpan Keputusan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
