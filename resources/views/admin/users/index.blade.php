@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6 font-sans">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[20px] border border-[#E2E8F0] shadow-xs">
        <div>
            <h1 class="font-jakarta text-2xl font-bold text-[#0F172A]">Kelola Pengguna</h1>
            <p class="text-xs text-[#64748B] mt-1">Daftar pengguna dan manajemen peran (role) administrator website Desa Catur.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-[#0F4C3A] hover:bg-[#072C21] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[20px] border border-[#E2E8F0] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2E8F0]">
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4">Akses Menu</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9]">
                    @forelse($users as $u)
                        <tr class="hover:bg-[#F8FAFC]/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-[#0F4C3A] text-white font-bold text-xs flex items-center justify-center shrink-0 border border-[#E2E8F0]">
                                        @if($u->avatar_url)
                                            <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($u->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-[#0F172A] text-sm truncate">{{ $u->name }}</p>
                                            @if($u->id === auth()->id())
                                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-bold">Anda</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-[#64748B] truncate">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if($u->isSuperAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-600"></span>
                                        Super Admin
                                    </span>
                                @elseif($u->isAdminPemdes())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Admin Pemdes
                                    </span>
                                @elseif($u->isPpkOrmawa())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                        PPK Ormawa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $u->role_label }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-xs text-slate-600 max-w-xs">
                                    @if($u->isSuperAdmin())
                                        <span class="text-purple-700 font-semibold">Semua Fitur, Pengaturan & Kelola Pengguna</span>
                                    @elseif($u->isAdminPemdes())
                                        <span class="text-emerald-700 font-semibold">Profil Desa, Berita, Perangkat, Layanan Publik, Galeri</span>
                                    @elseif($u->isPpkOrmawa())
                                        <span class="text-amber-800 font-semibold">Dashboard, Berita & Pengumuman, PPK Ormawa</span>
                                    @else
                                        <span class="text-slate-500">Akses Terbatas</span>
                                    @endif
                                </p>
                            </td>

                            <td class="px-6 py-4 text-xs text-[#64748B] whitespace-nowrap">
                                {{ $u->created_at ? $u->created_at->translatedFormat('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" 
                                       class="p-2 text-slate-600 hover:text-[#0F4C3A] hover:bg-emerald-50 rounded-xl transition"
                                       title="Edit Pengguna">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna {{ $u->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition"
                                                    title="Hapus Pengguna">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-[#E2E8F0] bg-[#F8FAFC]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
