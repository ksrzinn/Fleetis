<?php

use App\Http\Controllers\FixedFreightTableController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'freights', 'as' => 'freights.'], function () {
    Route::post('/storeKm', [\App\Http\Controllers\FreightController::class, 'storeKm'])->name('storeKm');
    Route::post('/storeFixed', [\App\Http\Controllers\FreightController::class, 'storeFixed'])->name('storeFixed');
});

Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
    Route::get('/getAllRegions', [\App\Http\Controllers\RegionController::class, 'getAllRegions'])->name('getAllRegions');
});

Route::group(['prefix' => 'fixedFreights', 'as' => 'fixedFreights.'], function () {
    Route::post('/store', [FixedFreightTableController::class, 'fixedFreightTableStore'])->name('fixedFreightTableStore');
    Route::delete('/destroy/{id}', [FixedFreightTableController::class, 'fixedFreightTableDestroy'])->name('fixedFreightTableDestroy');
    Route::get('/getFixedFreights', [FixedFreightTableController::class, 'getFixedFreights'])->name('getFixedFreights');
});
