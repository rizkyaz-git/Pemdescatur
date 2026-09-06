@extends('layouts.admin')

@section('title', 'Permohonan Surat Warga')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="font-serif text-2xl font-bold text-gray-800">📨 Permohonan Surat Warga</h1>
            <p class="text-xs text-gray-500 mt-1">Daftar masuk dan status permohonan surat administrasi dari warga desa.</p>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <form method="GET" action="{{ route('admin.letter-requests.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari Tiket / Nama Pemohon..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div>
                <select name="template_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm">
                    <option value="">-- Semua Jenis Surat --</option>
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" {{ request('template_id') == $tpl->id ? 'selected' : '' }}>
                            {{ $tpl->title ?? $tpl->name }} ({{ $tpl->code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 text-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    🔍 Filter
                </button>
                @if(request('search') || request('template_id') || request('status'))
                    <a href="{{ route('admin.letter-requests.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-2 rounded-lg transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="p-4">No. Tiket</th>
                        <th class="p-4">Pemohon</th>
                        <th class="p-4">Jenis Surat</th>
                        <th class="p-4">Tgl Pengajuan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 font-mono font-bold text-gray-900">{{ $req->ticket_number }}</td>
                            <td class="p-4">
                                <p class="font-semibold text-gray-900">{{ $req->user ? $req->user->name : '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $req->user ? $req->user->email : '' }}</p>
                            </td>
                            <td class="p-4">
                                <span class="font-semibold text-emerald-800">{{ $req->template ? ($req->template->title ?? $req->template->name) : '-' }}</span>
                            </td>
                            <td class="p-4 text-xs text-gray-600">
                                {{ $req->created_at ? $req->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="p-4">
                                @if($req->status === 'pending')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Menunggu Review</span>
                                @elseif($req->status === 'approved')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Disetujui</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.letter-requests.show', $req->id) }}" class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    👁️ Detail
                                </a>
                                <a href="{{ route('admin.letter-requests.edit', $req->id) }}" class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    ⚡ Proses
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Belum ada permohonan surat masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
