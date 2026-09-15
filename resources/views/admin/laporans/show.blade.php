@extends('layouts.admin')
@section('title', 'Detail Laporan')
@section('content')
    <div class="max-w-3xl space-y-5"><a class="underline" href="{{ route('admin.laporans.index') }}">Kembali</a>
        <h1 class="text-2xl font-bold">{{ $laporan->kategori }}</h1>
        <p><strong>Pelapor:</strong> {{ $laporan->pelapor->nama }} ({{ $laporan->pelapor->email }})</p>
        <p><strong>Status:</strong> {{ $laporan->status }}</p>
        <div class="whitespace-pre-line rounded border p-4">{{ $laporan->isi_laporan }}</div><a
            class="inline-block rounded bg-[#0A3D29] text-white px-4 py-2"
            href="{{ route('admin.laporans.edit', $laporan) }}">Perbarui laporan</a>
        <h2 class="text-lg font-bold">Riwayat tanggapan</h2>@foreach($laporan->tanggapans as $t)
        <div class="rounded border p-3 whitespace-pre-line">{{ $t->isi_tanggapan }}</div>@endforeach
    </div>
@endsection