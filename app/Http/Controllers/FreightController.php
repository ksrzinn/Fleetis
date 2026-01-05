<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RegisterKmFreightUseCase;
use StoreKmFreightRequest;

class FreightController extends Controller
{
    public function storeKm(StoreKmFreightRequest $request, RegisterKmFreightUseCase $registerKm){
        $freight = $registerKm->execute($request->validated());
        return response()->json($freight, 201);
    }
}
