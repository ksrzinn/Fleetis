<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\FixedFreightPriceController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

