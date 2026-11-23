<?php

namespace App\Http\Controllers;

use App\Actions\City\IndexAction;
use App\Actions\City\ShowAction;
use App\Http\Requests\CityIndexRequest;
use App\Models\City;
use App\Models\Prefecture;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(
        CityIndexRequest $request,
        IndexAction $indexAction,
    ): View {
        $filters = $request->validated();
        $result = $indexAction->execute($filters);

        $prefectures = Prefecture::orderBy('code')->get();

        return view('cities.index', [
            ...$result,
            'prefectures' => $prefectures,
        ]);
    }

    public function show(
        City $city,
        ShowAction $showAction,
    ): View {
        $result = $showAction->execute($city);

        return view('cities.show', [
            ...$result,
            'city' => $city,
        ]);
    }
}
