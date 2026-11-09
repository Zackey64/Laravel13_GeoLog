<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\VisitController;
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

Route::get('/visits/create', [VisitController::class, 'create'])
    ->name('visits.create');
Route::post('/visits', [VisitController::class, 'store'])
    ->name('visits.store');
Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])
    ->name('visits.edit');
Route::put('/visits/{visit}', [VisitController::class, 'update'])
    ->name('visits.update');
Route::delete('/visits/{visit}', [VisitController::class, 'destroy'])
    ->name('visits.destroy');
