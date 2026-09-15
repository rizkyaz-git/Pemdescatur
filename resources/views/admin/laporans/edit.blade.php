@extends('layouts.admin')
@section('title', 'Perbarui Laporan')
@section('content')
    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold">Perbarui Laporan</h1>
        <form method="POST" action="{{ route('admin.laporans.update', $laporan) }}" class="mt-6 space-y-4">@csrf
            @method('PUT')<select name="status"
                class="w-full rounded border-slate-300">@foreach(\App\Models\Laporan::STATUSES as $status)
                    <option value="{{ $status }}" @selected(old('status', $laporan->status) === $status)>
                        {{ str($status)->replace('_', ' ')->title() }}
                </option>@endforeach
            </select><textarea name="isi_tanggapan" rows="6" class="w-full rounded border-slate-300"
                placeholder="Tanggapan baru (opsional)">{{ old('isi_tanggapan') }}</textarea>@error('isi_tanggapan')
                <p class="text-red-600">{{ $message }}</p>@enderror<button
                class="rounded bg-[#0A3D29] px-5 py-2 text-white">Simpan</button>
        </form>
    </div>
@endsection