<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FixedFreightTableController;
use App\Http\Controllers\FreightController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Dashboard');
// });

/**
 * Guest Routes
 */
Route::get('/login', [LoginController::class, 'index'])->name('login');


/**
 * Authenticated Routes
 */

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'freights', 'as' => 'freights.'], function () {
    Route::get('/', [FreightController::class, 'index'])->name('index');
    Route::get('/store', [FreightController::class, 'store'])->name('store');
    Route::group(['prefix' => 'fixedFreights', 'as' => 'fixedFreights.'], function () {
        Route::get('/', [FixedFreightTableController::class, 'fixedFreightTableIndex'])->name('fixedFreightTableIndex');
    });
});

Route::group(['middleware' => 'auth'],function (){
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Módulo de Fretes
     */


    /**
     * Módulo financeiro (WIP)
     */

    Route::group(['prefix' => 'financial', 'as' => 'financial.'], function () {
        Route::get('/', function () { return Inertia::render('Financial/Index'); })->name('index');
    });
});
