@extends('layouts.admin')

@section('title', 'Template Surat Siap Cetak')

@section('content')
<div class="space-y-5">
    {{-- 1. Page Header & Primary Action --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">File Template Surat Siap Cetak</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Kelola dokumen template surat resmi desa yang dapat diunduh dan dicetak mandiri oleh warga.</p>
        </div>
        <div class="shrink-0 self-start sm:self-auto">
            <a href="{{ route('admin.letter-templates.create') }}" 
               class="inline-flex items-center gap-1.5 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Template Baru</span>
            </a>
        </div>
    </div>

    {{-- 2. Data Table Card (Harmonisasi dengan Kelola Berita) --}}
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200/80">
                        <th scope="col" class="px-4 py-3 align-middle min-w-[240px]">Nama Template Surat</th>
                        <th scope="col" class="w-48 px-4 py-3 align-middle whitespace-nowrap">File Siap Cetak</th>
                        <th scope="col" class="px-4 py-3 align-middle">Keterangan &amp; Syarat</th>
                        <th scope="col" class="w-36 px-4 py-3 text-right align-middle whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($templates as $template)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3.5 align-middle">
                                <a href="{{ route('admin.letter-templates.edit', $template->id) }}" 
                                   class="font-semibold text-slate-900 hover:text-[#0F4C3A] text-xs sm:text-sm block transition-colors">
                                    {{ $template->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                @if($template->has_file)
                                    <a href="{{ $template->file_url }}" target="_blank" download
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-[#0F4C3A] hover:bg-emerald-100 border border-emerald-200/70 text-xs font-medium transition shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        <span>{{ $template->file_extension }}</span>
                                        <span class="text-[10px] text-slate-500 font-normal">({{ $template->file_size_formatted }})</span>
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[11px] font-medium rounded-md bg-amber-50 text-amber-800 border border-amber-200/60">
                                        Belum Ada File
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 align-middle">
                                <div class="max-w-md text-xs space-y-0.5">
                                    @if($template->description)
                                        <p class="font-medium text-slate-800 truncate">{{ $template->description }}</p>
                                    @endif
                                    @if($template->requirements)
                                        <p class="text-[11px] text-slate-500 truncate">Syarat: {{ $template->requirements }}</p>
                                    @endif
                                    @if(!$template->description && !$template->requirements)
                                        <span class="text-slate-400 italic">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3.5 align-middle text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.letter-templates.edit', $template->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-slate-700 hover:text-[#0F4C3A] hover:border-[#0F4C3A]/30 hover:bg-slate-50 transition shadow-2xs"
                                       title="Edit Template">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin.letter-templates.destroy', $template->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template surat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-slate-200 bg-white text-xs font-medium text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition shadow-2xs cursor-pointer"
                                                title="Hapus Template">
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-xs font-semibold text-slate-800">Belum ada file template surat</p>
                                <p class="text-xs text-slate-400 mt-0.5">Unggah dokumen template surat pertama melalui tombol di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Summary & Pagination --}}
        @if(method_exists($templates, 'hasPages') && ($templates->hasPages() || $templates->total() > 0))
            <div class="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                <p>
                    Menampilkan <span class="font-medium text-slate-700">{{ $templates->firstItem() ?? 0 }}</span> - <span class="font-medium text-slate-700">{{ $templates->lastItem() ?? 0 }}</span> dari <span class="font-medium text-slate-700">{{ $templates->total() }}</span> template
                </p>
                @if($templates->hasPages())
                    <div class="shrink-0">
                        {{ $templates->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
