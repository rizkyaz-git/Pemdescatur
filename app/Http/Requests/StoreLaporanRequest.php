<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => trim((string) $this->input('nama')),
            'email' => strtolower(trim((string) $this->input('email'))),
            'nik' => preg_replace('/\D/', '', (string) $this->input('nik')),
            'isi_laporan' => trim(strip_tags((string) $this->input('isi_laporan'))),
        ]);
    }
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:2', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'kategori' => ['required', 'string', Rule::in(config('pengaduan.categories'))],
            'isi_laporan' => ['required', 'string', 'min:10', 'max:5000'],
            'lampiran' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png,pdf', 'mimetypes:image/jpeg,image/png,application/pdf'],
        ];
    }
}
