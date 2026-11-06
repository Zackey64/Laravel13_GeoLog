<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Station::query()->with('city.prefecture')->ordered();
        if ($request->filled('prefecture')) {
            $query->where('prefectures.id', $request->prefecture);
        }
        $stations = $query->paginate(150)->withQueryString();

        $prefectures = Prefecture::orderBy('code')->get();

        return view('stations.index', compact('stations', 'prefectures'));
    }

    public function show(Station $station): View
    {
        return view('stations.show', compact('station'));
    }
}
