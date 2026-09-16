<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'kategori'    => ['required', 'string', 'in:infrastruktur,kependudukan,keamanan,lingkungan,layanan_publik,lainnya'],
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
            $no = preg_replace('/\s+/', '', $this->input('no_whatsapp'));

            if (str_starts_with($no, '+62')) {
                $no = '62' . substr($no, 3);
            } elseif (str_starts_with($no, '62')) {
                // sudah benar
            } elseif (str_starts_with($no, '0')) {
                $no = '62' . substr($no, 1);
            }

            $this->merge(['no_whatsapp' => $no]);
        }
    }
}
