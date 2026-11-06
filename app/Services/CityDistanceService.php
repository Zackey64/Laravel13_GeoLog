<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\City;

class CityDistanceService
{
    public function getCities($latitude, $longitude, $radius): array
    {
        return City::query()
            ->with('prefecture')
            ->selectRaw(
                'cities.*, ST_Distance_Sphere(
                    POINT(longitude, latitude),
                    POINT(?, ?)
                ) AS distance',
                [$longitude, $latitude]
            )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();
    }
}