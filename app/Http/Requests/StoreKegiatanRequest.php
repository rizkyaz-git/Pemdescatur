<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pojok_id' => ['required', 'exists:pojoks,id'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'tanggal_kegiatan' => ['required', 'date'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'pojok_id.required' => 'Pojok Pemberdayaan wajib dipilih.',
            'pojok_id.exists' => 'Pojok yang dipilih tidak valid.',
            'judul.required' => 'Judul kegiatan wajib diisi.',
            'judul.max' => 'Judul kegiatan maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi kegiatan wajib diisi.',
            'tanggal_kegiatan.required' => 'Tanggal kegiatan wajib diisi.',
            'tanggal_kegiatan.date' => 'Format tanggal kegiatan tidak valid.',
            'thumbnail.image' => 'Thumbnail harus berupa file gambar.',
            'thumbnail.mimes' => 'Format thumbnail yang didukung: jpeg, png, jpg, webp.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 4MB.',
        ];
    }
}
