<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:100'],
            'slug_or_url' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'is_external' => ['nullable', 'boolean'],
            'parent_id' => ['nullable', 'exists:menus,id'],
        ];
    }
}
