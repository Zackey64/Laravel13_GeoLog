<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StationController::class, 'index'])
    ->name('stations.index');

Route::get('/stations', [StationController::class, 'index'])
    ->name('stations.index');
Route::get('/stations/{station}', [StationController::class, 'show'])
    ->name('stations.show');

Route::get('/cities', [CityController::class, 'index'])
    ->name('cities.index');
Route::get('/cities/{city}', [CityController::class, 'show'])
    ->name('cities.show');
