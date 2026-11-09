<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Collection;

class CityDistanceService
{
    public function getCities(
        float $latitude,
        float $longitude,
        int $radius,
    ): Collection {

        // 都市を取得するクエリを作成
        $cities = City::query()
            ->with('prefecture')
            ->selectRaw(
                'cities.*, ST_Distance_Sphere(
                POINT(longitude, latitude),
                POINT(?, ?)
            ) AS distance',
                [$longitude, $latitude]
            )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        return $cities->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();
    }
}
