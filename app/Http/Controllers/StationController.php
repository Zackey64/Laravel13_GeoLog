<?php

namespace App\Http\Controllers;

use App\Actions\Station\IndexAction;
use App\Http\Requests\StationIndexRequest;
use App\Models\Prefecture;
use App\Models\Station;
use App\Services\CityDistanceService;
use App\Services\StationDistanceService;
use Illuminate\View\View;

class StationController extends Controller
{
    public function index(
        StationIndexRequest $request,
        IndexAction $indexAction,
    ): View {
        $filters = $request->validated();
        $result = $indexAction->execute($filters);

        $prefectures = Prefecture::orderBy('code')->get();

        return view('stations.index', [
            ...$result,
            'prefectures' => $prefectures,
        ]);
    }

    public function show(
        Station $station,
        CityDistanceService $cityDistanceService,
        StationDistanceService $stationDistanceService,
    ): View {
        $station->load('city.prefecture');
        $visits = $station->visits;

        // 付近の道の駅（最大５件）を取得
        $nearbyStations = $stationDistanceService->getStations(
            $station->latitude,
            $station->longitude,
            50000,
        )->reject(fn ($nearbyStation) => $nearbyStation->id === $station->id)->take(5);

        // 付近の市町村（最大５件）を取得
        $nearbyCities = $cityDistanceService->getCities(
            $station->latitude,
            $station->longitude,
            50000,
        )->reject(fn ($nearbyCity) => $nearbyCity->id === $station->city->id)->take(5);

        return view('stations.show', compact('station', 'visits', 'nearbyCities', 'nearbyStations'));
    }
}
