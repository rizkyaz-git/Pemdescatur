<?php

namespace App\Http\Requests;

use App\Helpers\WhatsappHelper;
use App\Models\LetterTemplate;
use Illuminate\Foundation\Http\FormRequest;

class StoreLetterRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === 'lainnya') {
                        return;
                    }
                    if (!LetterTemplate::where('id', $value)->exists()) {
                        $fail('Jenis surat yang dipilih tidak valid.');
                    }
                }
            ],
            'form_data.nama'                => ['required', 'string', 'max:255'],
            'form_data.nik'                 => ['required', 'string', 'regex:/^\d{16}$/'],
            'form_data.telepon'             => ['required', 'string', 'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'form_data.keperluan'           => ['required', 'string', 'min:10', 'max:1000'],
            'form_data.jenis_surat_lainnya' => ['nullable', 'string', 'max:255', 'required_if:template_id,lainnya'],
        ];
    }

    public function messages(): array
    {
        return [
            'template_id.required'                     => 'Jenis surat wajib dipilih.',
            'form_data.nama.required'                  => 'Nama lengkap wajib diisi.',
            'form_data.nama.max'                       => 'Nama lengkap maksimal 255 karakter.',
            'form_data.nik.required'                   => 'NIK wajib diisi.',
            'form_data.nik.regex'                      => 'NIK harus terdiri dari 16 digit angka.',
            'form_data.telepon.required'               => 'Nomor WhatsApp wajib diisi.',
            'form_data.telepon.regex'                  => 'Format nomor WhatsApp tidak valid. Contoh: 08123456789 atau +6281234567890.',
            'form_data.keperluan.required'             => 'Keperluan/keterangan permohonan wajib diisi.',
            'form_data.keperluan.min'                  => 'Keperluan minimal 10 karakter.',
            'form_data.keperluan.max'                  => 'Keperluan maksimal 1.000 karakter.',
            'form_data.jenis_surat_lainnya.required_if' => 'Nama/jenis surat lainnya wajib diisi jika memilih opsi Lainnya.',
            'form_data.jenis_surat_lainnya.max'         => 'Nama jenis surat maksimal 255 karakter.',
        ];
    }

    /**
     * Normalisasi nomor WhatsApp ke format 62xxxxxxxxxx sebelum validasi.
     * Memakai WhatsappHelper yang sama dengan pengaduan warga.
     */
    protected function prepareForValidation(): void
    {
        $formData = $this->input('form_data', []);

        if (!empty($formData['telepon'])) {
            $formData['telepon'] = WhatsappHelper::normalize($formData['telepon']) ?? $formData['telepon'];
            $this->merge(['form_data' => $formData]);
        }
    }
}
