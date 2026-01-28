<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FixedFreightPriceController;
use App\Http\Controllers\FreightController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\KmRateController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use App\Models\KmRate;
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
        Route::post('/fixed', [FreightController::class, 'storeFixed'])->name('storeFixed');
        Route::put('/fixed/{freight}', [FreightController::class, 'updateFixed'])->name('updateFixed');
        Route::delete('/{freight}', [FreightController::class, 'destroy'])->name('destroy');
        Route::get('/fetchFreights', [FreightController::class, 'fetchFreights'])->name('fetchFreights');

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
     * Módulo de Taxa por Km
     */
    Route::group(['prefix' => 'kmRates', 'as' => 'kmRates.'], function (){
        Route::get('/', [KmRateController::class, 'index'])->name('index');
        Route::get('/fetchKmRates', [KmRateController::class, 'fetchKmRates'])->name('fetchKmRates');
        Route::post('/store', [KmRateController::class, 'store'])->name('store');
        Route::post('/update/{id}', [KmRateController::class, 'update'])->name('update');
        Route::delete('/destroy/{rate}', [KmRateController::class, 'destroy'])->name('destroy');
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
     * Módulo de Veículos
     */

    Route::group(['prefix' => 'vehicles', 'as' => 'vehicles.'], function (){
        Route::get('/', [VehicleController::class, 'index'])->name('index');
        Route::get('/fetchVehicles', [VehicleController::class, 'fetchVehicles'])->name('fetchVehicles');
        Route::post('/store', [VehicleController::class, 'store'])->name('store');
        Route::post('/update/{id}', [VehicleController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [VehicleController::class, 'destroy'])->name('destroy');
    });

    /**
     * Módulo de Motoristas
     */

    Route::group(['prefix' => 'drivers', 'as' => 'drivers.'], function (){
        Route::get('/', [DriverController::class, 'index'])->name('index');
        Route::get('/fetchDrivers', [DriverController::class, 'fetchDrivers'])->name('fetchDrivers');
        Route::post('/store', [DriverController::class, 'store'])->name('store');
        Route::post('/update/{id}', [DriverController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [DriverController::class, 'destroy'])->name('destroy');
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
