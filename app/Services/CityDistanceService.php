<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CityDistanceService
{
    /*
     * 指定された緯度・経度からの距離で都市を取得する
     */
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

    /*
     * 指定された緯度・経度からの距離で都市を並び替える
     */
    public function orderByDistance(
        Builder $query,
        float $latitude,
        float $longitude,
    ): Builder {
        return $query
            ->selectRaw(
                'ST_Distance_Sphere(
                POINT(cities.longitude, cities.latitude),
                POINT(?, ?)
            ) AS distance',
                [$longitude, $latitude]
            )
            ->whereNotNull('cities.latitude')
            ->whereNotNull('cities.longitude')
            ->orderBy('distance');
    }
}
