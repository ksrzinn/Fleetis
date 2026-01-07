<?php

namespace App\Http\Controllers;

use App\Domain\Freight\UseCases\RegisterFixedFreightUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RegisterKmFreightUseCase;
use StoreFixedFreightRequest;
use StoreKmFreightRequest;

class FreightController extends Controller
{
    public function storeKm(StoreKmFreightRequest $request, RegisterKmFreightUseCase $registerKm): JsonResponse
    {
        $freight = $registerKm->execute($request->validated());
        return response()->json([
            'data' => $freight
        ], 201);
    }

    public function storeFixed(
        StoreFixedFreightRequest $request,
        RegisterFixedFreightUseCase $registerFixed
    ): JsonResponse {
        $freight = $registerFixed->execute($request->validated());
        return response()->json([
            'data' => $freight
        ], 201);
    }
}
