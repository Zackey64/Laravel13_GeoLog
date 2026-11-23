<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'stationTotal' => \App\Models\Station::count(),
            'stationVisited' => \App\Models\Visit::whereNotNull('station_id')->count(),
            'cityTotal' => \App\Models\City::count(),
            'cityVisited' => \App\Models\Visit::whereNotNull('city_id')->count(),
        ]);
    }
}
