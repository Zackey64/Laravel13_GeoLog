<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StationIndexRequest extends FormRequest
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
            'visited_status' => ['nullable', 'string', 'in:visited,not_visited'],
            'sort' => ['nullable', 'string', 'in:code,name,distance'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
