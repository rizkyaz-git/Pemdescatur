@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">
    <!-- 1. Page Header (Standard Admin Typography & Spacing) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-1">
        <div>
            <h1 class="font-jakarta font-extrabold text-2xl text-slate-900 tracking-tight">Kelola Pengguna</h1>
            <p class="text-xs text-[#64748B] mt-1 font-medium">Daftar pengguna dan manajemen peran administrator website Desa Catur.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
           class="inline-flex items-center gap-1.5 bg-[#0B6B52] hover:bg-[#07513F] text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-2xs transition shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- 2. Data Table Card (Standard Admin Table: Radius 12px, Border #DDE5E1) -->
    <div class="bg-white rounded-[12px] border border-[#DDE5E1] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F7F9F8] text-[#607089] text-[11px] font-bold uppercase tracking-wider border-b border-[#DDE5E1]">
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Peran (Role)</th>
                        <th class="px-4 py-3">Akses Menu</th>
                        <th class="px-4 py-3">Terdaftar</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9] text-slate-700 bg-white">
                    @forelse($users as $u)
                        <tr class="hover:bg-[#F7F9F8] transition-colors">
                            <td class="px-4 py-3.5 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full overflow-hidden bg-[#0F4C3A] text-white font-bold text-xs flex items-center justify-center shrink-0 border border-[#DDE5E1]">
                                        @if($u->avatar_url)
                                            <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($u->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <p class="font-semibold text-[#10233F] text-xs truncate">{{ $u->name }}</p>
                                            @if($u->id === auth()->id())
                                                <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded font-semibold border border-slate-200/60">Anda</span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-[#607089] truncate mt-0.5">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3.5 align-middle whitespace-nowrap">
                                @if($u->isSuperAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-800 border border-slate-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                                        Super Admin
                                    </span>
                                @elseif($u->isAdminPemdes())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#E6F4EE] text-[#0F4C3A] border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Admin Pemdes
                                    </span>
                                @elseif($u->isPpkOrmawa())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                        PPK Ormawa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $u->role_label }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 align-middle">
                                <p class="text-xs text-[#607089] max-w-xs leading-relaxed font-normal">
                                    @if($u->isSuperAdmin())
                                        Semua Fitur, Pengaturan Situs & Kelola Pengguna
                                    @elseif($u->isAdminPemdes())
                                        Profil Desa, Berita, Perangkat, Layanan Publik, Galeri
                                    @elseif($u->isPpkOrmawa())
                                        Dashboard, Berita & Pengumuman, PPK Ormawa
                                    @else
                                        Akses Terbatas
                                    @endif
                                </p>
                            </td>

                            <td class="px-4 py-3.5 align-middle text-xs text-[#607089] tabular-nums whitespace-nowrap">
                                {{ $u->created_at ? $u->created_at->translatedFormat('d M Y') : '-' }}
                            </td>

                            <td class="px-4 py-3.5 align-middle text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" 
                                       class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-[#DDE5E1] text-xs font-semibold text-[#0F4C3A] hover:bg-[#F4F6F5] hover:border-[#0F4C3A]/30 transition shadow-2xs"
                                       title="Edit Pengguna">
                                        <svg class="w-3.5 h-3.5 text-[#0F4C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna {{ $u->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 h-7 px-2.5 rounded-lg border border-rose-200 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition shadow-2xs cursor-pointer"
                                                    title="Hapus Pengguna">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-xs font-semibold text-[#10233F]">Tidak ada data pengguna</p>
                                <p class="text-[11px] text-[#607089] mt-0.5">Tambahkan administrator sistem melalui tombol di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-4 py-3 border-t border-[#DDE5E1] bg-[#F7F9F8]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
