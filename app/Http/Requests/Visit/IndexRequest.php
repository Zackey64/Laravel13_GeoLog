<?php

namespace App\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string', 'max:100'],
            'prefecture_id' => ['nullable', 'integer', 'exists:prefectures,id'],
            'sort' => ['nullable', 'string', 'in:updated_at'],
        ];
    }
}
