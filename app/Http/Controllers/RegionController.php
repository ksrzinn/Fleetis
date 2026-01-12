<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getAllRegions(): JsonResponse
    {
        $regions = Region::select('uf', 'id')->distinct()->orderBy('uf')->get();

        return response()->json(['data' => $regions]);

    }
}
