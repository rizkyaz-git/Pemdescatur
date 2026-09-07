@extends('layouts.admin')

@section('title', 'Kelola 5 Pojok & Kurikulum PPKO')

@section('content')
<div class="space-y-6">

    <!-- Flash Alert Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Top Card / Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#D9B85C]/20 text-[#7A5A00] border border-[#D9B85C]/30">PPKO Catur Cerdas</span>
                <span class="text-xs text-gray-500">• 5 Pilar Pemberdayaan</span>
            </div>
            <h3 class="font-serif font-bold text-xl text-gray-900 mt-1">Kelola Pojok & Kurikulum Pembelajaran</h3>
            <p class="text-xs text-gray-500 mt-0.5">Kelola narasi pilar, kurikulum/modul yang dapat diunduh warga, serta integrasi kegiatan tiap Pojok.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kegiatans.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
                <span>Kelola Kegiatan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="{{ route('public.ppko') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#0d631b] hover:bg-emerald-800 text-white text-xs font-bold transition shadow-xs">
                <span>Lihat di Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- Table of 5 Pojoks -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="p-4 w-12 text-center">No</th>
                        <th class="p-4">Nama Pilar Pojok</th>
                        <th class="p-4">Deskripsi Program</th>
                        <th class="p-4 text-center">Kegiatan</th>
                        <th class="p-4">Kurikulum / Modul Terunggah</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pojoks as $index => $pojok)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="p-4 text-center font-mono font-bold text-gray-400">
                                0{{ $index + 1 }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="font-bold text-gray-900 block text-sm">{{ $pojok->nama }}</span>
                                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 inline-block mt-1">
                                    Pilar 0{{ $index + 1 }}
                                </span>
                            </td>
                            <td class="p-4 max-w-md">
                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                    {{ $pojok->deskripsi_singkat }}
                                </p>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $pojok->kegiatans_count > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $pojok->kegiatans_count }} Agenda
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($pojok->kurikulums->count() > 0)
                                    <div class="space-y-1">
                                        @foreach($pojok->kurikulums->take(2) as $kuri)
                                            <div class="flex items-center gap-1.5 text-xs text-gray-800 font-medium">
                                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                                <span class="truncate max-w-[200px]" title="{{ $kuri->judul }}">{{ $kuri->judul }}</span>
                                                <span class="text-[10px] text-gray-400">({{ $kuri->formatted_file_size }})</span>
                                            </div>
                                        @endforeach
                                        @if($pojok->kurikulums->count() > 2)
                                            <span class="text-[11px] text-gray-400 font-semibold">+{{ $pojok->kurikulums->count() - 2 }} file lainnya</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada kurikulum</span>
                                @endif
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.pojoks.edit', $pojok) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-[#0d631b] hover:bg-emerald-800 px-3 py-1.5 rounded-lg transition shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span>Kelola Kurikulum</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
