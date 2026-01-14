<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleTypeRequest;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;

class VehicleTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleTypes/Index');
    }

    public function store(StoreVehicleTypeRequest $request):JsonResponse
    {
        try {
            $vt = VehicleType::updateOrCreate($request->validated());
            return response()->json(['data' => $vt], 200);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function fetchVehicleTypes():JsonResponse
    {
        $vt = VehicleType::orderBy('name', 'asc')->get();
        return response()->json(['data' => $vt]);
    }
}
