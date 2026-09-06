@extends('layouts.admin')

@section('title', 'Tanggapi Pengaduan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">💬 Tanggapi Pengaduan Warga</h1>
            <p class="text-xs text-gray-500 mt-1">Tiket: <strong class="font-mono text-emerald-800">{{ $complaint->ticket_number }}</strong></p>
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-lg transition">
            ⬅️ Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
        <!-- Summary of Complaint -->
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6 space-y-2">
            <span class="text-xs font-bold text-gray-500 uppercase">Subjek Pengaduan:</span>
            <p class="font-bold text-base text-gray-900">{{ $complaint->title }}</p>
            <p class="text-xs text-gray-600 line-clamp-3">{{ $complaint->description }}</p>
        </div>

        <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Status Penanganan Pengaduan <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-semibold @error('status') border-red-500 @enderror">
                    <option value="new" {{ old('status', $complaint->status) == 'new' ? 'selected' : '' }}>🔴 Baru / Belum Ditanggapi</option>
                    <option value="processing" {{ old('status', $complaint->status) == 'processing' ? 'selected' : '' }}>🟡 Sedang Ditindaklanjuti (Processing)</option>
                    <option value="resolved" {{ old('status', $complaint->status) == 'resolved' ? 'selected' : '' }}>🟢 Selesai Ditanggapi (Resolved)</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_response" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Tanggapan / Jawaban Resmi Pemerintah Desa
                </label>
                <textarea name="admin_response" id="admin_response" rows="6"
                    placeholder="Tuliskan tindak lanjut atau tanggapan resmi dari Pemerintah Desa Catur..."
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('admin_response') border-red-500 @enderror">{{ old('admin_response', $complaint->admin_response) }}</textarea>
                @error('admin_response')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.complaints.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-semibold shadow-sm transition">
                    💾 Simpan Tanggapan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
