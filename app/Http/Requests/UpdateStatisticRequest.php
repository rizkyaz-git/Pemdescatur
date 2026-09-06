<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatisticRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:100'],
            'unit' => ['nullable', 'string', 'max:50'],
            'period' => ['required', 'string', 'max:50'],
            'order' => ['required', 'integer', 'min:0'],
        ];
    }
}
