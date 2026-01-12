<?php

namespace App\Http\Controllers;

use App\Models\FreightFixedPriceTable;
use App\Http\Requests\FreightFixedPriceTableRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FixedFreightTableController extends Controller
{
    public function fixedFreightTableIndex()
    {
        return Inertia::render('Freights/FixedFreights/Index');
    }

    public function fixedFreightTableStore(FreightFixedPriceTableRequest $request)
    {
        $freight = FreightFixedPriceTable::create($request->validated());
    }

    public function getFixedFreights(){
        $freights = FreightFixedPriceTable::with('region')->orderBy('id', 'desc')->get();
        return response()->json(['data' => $freights]);
    }
}
