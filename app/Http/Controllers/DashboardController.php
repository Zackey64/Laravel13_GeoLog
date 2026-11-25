<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Prefecture;
use App\Models\Station;
use App\Models\Visit;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 全国の進捗
        $totalCities = City::count();
        $visitedCities = City::hasVisits()->count();

        $totalStations = Station::count();
        $visitedStations = Station::hasVisits()->count();

        $cityProgress = $totalCities > 0
            ? round($visitedCities / $totalCities * 100, 1)
            : 0;

        $stationProgress = $totalStations > 0
            ? round($visitedStations / $totalStations * 100, 1)
            : 0;

        // 都道府県別の進捗
        $prefectures = Prefecture::query()
            ->withCount([
                'cities',
                'cities as visited_cities_count' => fn ($query) => $query->hasVisits(),
                'stations',
                'stations as visited_stations_count' => fn ($query) => $query->hasVisits(),
            ])
            ->get()
            ->map(function ($prefecture) {
                $prefecture->city_progress = $prefecture->cities_count > 0
                    ? round(
                        $prefecture->visited_cities_count / $prefecture->cities_count * 100,
                        1
                    )
                    : 0;

                $prefecture->station_progress = $prefecture->stations_count > 0
                    ? round(
                        $prefecture->visited_stations_count / $prefecture->stations_count * 100,
                        1
                    )
                    : 0;

                return $prefecture;
            })
            ->values();

        // 市町村ランキング
        $cityRanking = $prefectures
            ->sortByDesc('city_progress')
            ->values();

        // 道の駅ランキング
        $stationRanking = $prefectures
            ->sortByDesc('station_progress')
            ->values();

        // 直近の来訪記録
        $visits = Visit::with(['station', 'city'])
            ->latest('updated_at')->take(6)->get();

        return view('dashboard.index', compact(
            'totalCities',
            'visitedCities',
            'totalStations',
            'visitedStations',
            'cityProgress',
            'stationProgress',
            'cityRanking',
            'stationRanking',
            'visits'
        ));
    }
}
