<?php
namespace App\Http\Requests;
use App\Models\Laporan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateLaporanRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->isAdmin() ?? false; }
    protected function prepareForValidation(): void { $this->merge(['isi_tanggapan' => trim(strip_tags((string) $this->input('isi_tanggapan')))]); }
    public function rules(): array { return ['status' => ['required', Rule::in(Laporan::STATUSES)], 'isi_tanggapan' => ['nullable', 'string', 'max:5000']]; }
}
