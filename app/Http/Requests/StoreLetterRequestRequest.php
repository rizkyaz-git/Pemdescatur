<?php

namespace App\Http\Requests;

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
            'template_id'          => ['required', 'exists:letter_templates,id'],
            'form_data.nama'       => ['required', 'string', 'max:255'],
            'form_data.nik'        => ['required', 'string', 'regex:/^\d{16}$/'],
            'form_data.telepon'    => ['required', 'string', 'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'form_data.keperluan'  => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'template_id.required'         => 'Jenis surat wajib dipilih.',
            'template_id.exists'           => 'Jenis surat yang dipilih tidak tersedia.',
            'form_data.nama.required'      => 'Nama lengkap wajib diisi.',
            'form_data.nama.max'           => 'Nama lengkap maksimal 255 karakter.',
            'form_data.nik.required'       => 'NIK wajib diisi.',
            'form_data.nik.regex'          => 'NIK harus terdiri dari 16 digit angka.',
            'form_data.telepon.required'   => 'Nomor WhatsApp wajib diisi.',
            'form_data.telepon.regex'      => 'Format nomor WhatsApp tidak valid. Contoh: 08123456789 atau +6281234567890.',
            'form_data.keperluan.required' => 'Keperluan/keterangan permohonan wajib diisi.',
            'form_data.keperluan.min'      => 'Keperluan minimal 10 karakter.',
            'form_data.keperluan.max'      => 'Keperluan maksimal 1.000 karakter.',
        ];
    }

    /**
     * Normalisasi nomor WhatsApp ke format 62xxxxxxxxxx sebelum validasi.
     * Mengikuti pola identik StoreLaporanRequest.
     */
    protected function prepareForValidation(): void
    {
        $formData = $this->input('form_data', []);

        if (!empty($formData['telepon'])) {
            $no = preg_replace('/\s+/', '', $formData['telepon']);

            if (str_starts_with($no, '+62')) {
                $no = '62' . substr($no, 3);
            } elseif (str_starts_with($no, '62')) {
                // sudah benar
            } elseif (str_starts_with($no, '0')) {
                $no = '62' . substr($no, 1);
            }

            $formData['telepon'] = $no;
            $this->merge(['form_data' => $formData]);
        }
    }
}
