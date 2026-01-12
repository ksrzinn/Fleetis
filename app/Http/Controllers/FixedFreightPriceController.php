<?php

namespace App\Http\Controllers;

use App\Models\FreightFixedPrice;
use App\Http\Requests\FreightFixedPriceRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FixedFreightPriceController extends Controller
{
    public function fixedFreightIndex()
    {
        return Inertia::render('Freights/FixedFreights/Index');
    }

    public function fixedFreightPriceStore(FreightFixedPriceRequest $request)
    {
        $freight = FreightFixedPrice::create($request->validated());
    }

    public function getFixedFreights(){
        $freights = FreightFixedPrice::with('region')->orderBy('id', 'desc')->get();
        return response()->json(['data' => $freights]);
    }
}
