<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FixedFreightPriceController;
use App\Http\Controllers\FreightController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Dashboard');
// });

/**
 * Guest Routes
 */
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/webLogin', [WebAuthController::class, 'login'])->name('webLogin');

/**
 * Authenticated Routes
 */
Route::group(['middleware' => 'auth'],function (){

    /**
     * Get Authenticated User Route
     */

    Route::get('/getAuthenticatedUser', [WebAuthController::class, 'getAuthenticatedUser'])->name('getAuthenticatedUser');

    /**
     * Logout Route
     */

    Route::post('/logout', [WebAuthController::class, 'logout'])->name('web.logout');

    /**
     * Dashboard Route
     */

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Módulo de Fretes
     */

    Route::group(['prefix' => 'freights', 'as' => 'freights.'], function () {
        Route::get('/', [FreightController::class, 'index'])->name('index');

        /**
         * Módulo de lançamento de fretes
         */
        Route::post('/storeKm', [FreightController::class, 'storeKm'])->name('storeKm');
        Route::post('/storeFixed', [FreightController::class, 'storeFixed'])->name('storeFixed');

        /**
         * Módulos de Fretes Fixos
         */
        Route::group(['prefix' => 'fixedFreights', 'as' => 'fixedFreights.'], function () {
            Route::get('/', [FixedFreightPriceController::class, 'fixedFreightIndex'])->name('fixedFreightIndex');
            Route::post('/store', [FixedFreightPriceController::class, 'fixedFreightPriceStore'])->name('fixedFreightPriceStore');
            Route::delete('/destroy/{id}', [FixedFreightPriceController::class, 'fixedFreightDestroy'])->name('fixedFreightDestroy');
            Route::get('/getFixedFreights', [FixedFreightPriceController::class, 'getFixedFreights'])->name('getFixedFreights');
        });
    });

    /**
     * Módulo de Tipos de Veículos
     */

    Route::group(['prefix' => 'vehicleTypes', 'as' => 'vehicleTypes.'], function () {
        Route::get('/', [VehicleTypeController::class, 'index'])->name('index');
        Route::get('/fetchVehicleTypes', [VehicleTypeController::class, 'fetchVehicleTypes'])->name('fetchVehicleTypes');
        Route::post('/store', [VehicleTypeController::class, 'store'])->name('store');
        Route::post('/update/{id}', [VehicleTypeController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [VehicleTypeController::class, 'destroy'])->name('destroy');
    });

    /**
     * Módulo de Regiões
     */

    Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
        Route::get('/getAllRegions', [\App\Http\Controllers\RegionController::class, 'getAllRegions'])->name('getAllRegions');
    });

    /**
     * Módulo financeiro (WIP)
     */

    Route::group(['prefix' => 'financial', 'as' => 'financial.'], function () {
        Route::get('/', function () { return Inertia::render('Financial/Index'); })->name('index');
    });
});
