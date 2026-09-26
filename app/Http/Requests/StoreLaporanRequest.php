<?php
namespace App\Http\Requests;

use App\Helpers\WhatsappHelper;
use App\Models\Laporan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'        => ['required', 'string', 'max:255'],
            'no_whatsapp' => ['required', 'string', 'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'kategori'    => ['required', 'string', Rule::in(Laporan::kategoriList())],
            'isi_laporan' => ['required', 'string', 'min:10', 'max:2000'],
            'lampiran'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'           => 'Nama wajib diisi.',
            'no_whatsapp.required'    => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'       => 'Format nomor WhatsApp tidak valid. Contoh: 08123456789 atau +6281234567890.',
            'kategori.required'       => 'Kategori pengaduan wajib dipilih.',
            'kategori.in'             => 'Kategori yang dipilih tidak tersedia.',
            'isi_laporan.required'    => 'Isi laporan wajib diisi.',
            'isi_laporan.min'         => 'Isi laporan minimal 10 karakter.',
            'isi_laporan.max'         => 'Isi laporan maksimal 2.000 karakter.',
            'lampiran.mimes'          => 'Lampiran hanya boleh berformat JPG, JPEG, PNG, atau PDF.',
            'lampiran.max'            => 'Ukuran lampiran maksimal 5 MB.',
        ];
    }

    /**
     * Normalisasi nomor WhatsApp ke format 62xxxxxxxxxx sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('no_whatsapp')) {
            $this->merge([
                'no_whatsapp' => WhatsappHelper::normalize($this->input('no_whatsapp')) ?? $this->input('no_whatsapp'),
            ]);
        }
    }
}
