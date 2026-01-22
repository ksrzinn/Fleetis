<?php

namespace App\Http\Controllers;

use App\Domain\Vehicle\Services\UpdateVehicleService;
use App\Domain\Vehicle\Services\CreateVehicleService;
use App\Domain\Vehicle\Services\DeleteVehicleService;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index() {
        return Inertia::render('Vehicles/Index');
    }

    public function fetchVehicles(): JsonResponse
    {
        $vehicles = Vehicle::orderBy('plate', 'asc')->with('baseRegion', 'vehicleType')->get();

        return response()->json([
            'data' => $vehicles,
        ], 201);
    }

    public function store(StoreVehicleRequest $request, CreateVehicleService $service): JsonResponse
    {
        $vehicle = $service->execute($request->validated());

        return response()->json([
            'data' => $vehicle
        ], 201);
    }

    public function update(StoreVehicleRequest $request, string $id, UpdateVehicleService $service): JsonResponse
    {

        $vehicle = $service->execute($id, $request->validated());
        return response()->json([
            'data' => $vehicle
        ], 201);
    }

    public function destroy(string $id, DeleteVehicleService $service): JsonResponse
    {
        $service->execute($id);

        return response()->json([
            'msg' => 'Veículo removido com sucesso.'
        ]);
    }
}
