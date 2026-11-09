<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'station_id' => null,
            'image_path' => null,
            'context' => fake()->optional()->sentence(),
        ];
    }
}
