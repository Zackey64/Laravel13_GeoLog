<?php

namespace App\Actions\Station;

use App\Models\Station;
use App\Services\CityDistanceService;
use App\Services\StationDistanceService;

class ShowAction
{
    public function __construct(
        private CityDistanceService $cityDistanceService,
        private StationDistanceService $stationDistanceService,
    ) {}

    public function execute(Station $station): array
    {
        $station->load('city.prefecture');
        $visits = $station->visits;

        // 付近の道の駅（最大10件）を取得
        $nearbyStations = $this->stationDistanceService->getStations(
            $station->latitude,
            $station->longitude,
            20000,
        )->reject(fn ($nearbyStation) => $nearbyStation->id === $station->id)->take(10);

        // 付近の市町村（最大10件）を取得
        $nearbyCities = $this->cityDistanceService->getCities(
            $station->latitude,
            $station->longitude,
            20000,
        )->reject(fn ($nearbyCity) => $nearbyCity->id === $station->city->id)->take(10);

        return [
            'visits' => $visits,
            'nearbyStations' => $nearbyStations,
            'nearbyCities' => $nearbyCities,
        ];
    }
}
