<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\FixedFreightPriceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'freights', 'as' => 'freights.'], function () {
    Route::post('/storeKm', [\App\Http\Controllers\FreightController::class, 'storeKm'])->name('storeKm');
    Route::post('/storeFixed', [\App\Http\Controllers\FreightController::class, 'storeFixed'])->name('storeFixed');
});

Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
    Route::get('/getAllRegions', [\App\Http\Controllers\RegionController::class, 'getAllRegions'])->name('getAllRegions');
});

Route::group(['prefix' => 'fixedFreights', 'as' => 'fixedFreights.'], function () {
    Route::post('/store', [FixedFreightPriceController::class, 'fixedFreightPriceStore'])->name('fixedFreightPriceStore');
    Route::delete('/destroy/{id}', [FixedFreightPriceController::class, 'fixedFreightDestroy'])->name('fixedFreightDestroy');
    Route::get('/getFixedFreights', [FixedFreightPriceController::class, 'getFixedFreights'])->name('getFixedFreights');
});


Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::get('/me', function () {
        return request()->user();
    });
});

