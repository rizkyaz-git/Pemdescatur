<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriFotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'photos.required' => 'Pilih minimal satu foto dokumentasi.',
            'photos.array' => 'Format upload foto tidak valid.',
            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.mimes' => 'Format file yang didukung: jpeg, png, jpg, webp.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 4MB.',
            'caption.max' => 'Caption maksimal 255 karakter.',
        ];
    }
}
