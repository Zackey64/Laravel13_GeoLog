<?php

namespace App\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'context' => ['nullable', 'string', 'max:255'],
            'station_id' => [
                'nullable',
                'required_without:city_id',
                'prohibits:city_id',
                'exists:stations,id',
            ],
            'city_id' => [
                'nullable',
                'required_without:station_id',
                'exists:cities,id',
            ],
            'image_path' => ['nullable', 'image', 'max:10240'],
        ];
    }
}
