@extends('layouts.admin')
@section('title', 'Laporan Privat Warga')
@section('content')
    <div class="space-y-5">
        <h1 class="text-2xl font-bold">Laporan Privat Warga</h1>
        <div class="bg-white rounded border overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-3">Pelapor</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Status</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>@foreach($laporans as $laporan)
                    <tr class="border-b">
                        <td class="p-3">{{ $laporan->pelapor->nama }}</td>
                        <td class="p-3">{{ $laporan->kategori }}</td>
                        <td class="p-3">{{ $laporan->status }}</td>
                        <td class="p-3"><a class="underline" href="{{ route('admin.laporans.show', $laporan) }}">Buka</a>
                        </td>
                </tr>@endforeach
                </tbody>
            </table>
        </div>{{ $laporans->links() }}
    </div>
@endsection