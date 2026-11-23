<?php

namespace App\Http\Controllers;

use App\Actions\Station\IndexAction;
use App\Actions\Station\ShowAction;
use App\Http\Requests\StationIndexRequest;
use App\Models\Prefecture;
use App\Models\Station;
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
        ShowAction $showAction,
    ): View {
        $result = $showAction->execute($station);

        return view('stations.show', [
            ...$result,
            'station' => $station,
        ]);
    }
}
