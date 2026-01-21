<?php

namespace App\Http\Controllers;

use App\Domain\Driver\Services\CreateDriverService;
use App\Domain\Driver\Services\DeleteDriverService;
use App\Domain\Driver\Services\UpdateDriverService;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverController extends Controller
{

    public function index()
    {
        return Inertia::render('Drivers/Index');
    }

    public function fetchDrivers(){
        $drivers = Driver::orderBy('name', 'asc')->get();
        return response()->json([
            'data' => $drivers
        ]);
    }
    /**
     * Método que cria um registro de motorista no sistema utilizando o StoreDriverRequest e o CreateDriverService
     *
     * @param StoreDriverRequest $request
     * @param CreateDriverService $service
     *
     * @return JsonResponse
     */
    public function store(StoreDriverRequest $request,CreateDriverService $service): JsonResponse
    {
        return response()->json([
            'data' => $service->execute($request->validated())
        ], 201);
    }

    /**
     * Método que atualiza um registro de motorista.
     *
     * @param App\Domain\Driver\Services\UpdateDriverService $service
     * @param string $id
     * @param App\Http\Requests\UpdateDriverRequest $request
     *
     * @return Illuminate\Http\JsonResponse
     */

    public function update(UpdateDriverRequest $request, string $id, UpdateDriverService $service): JsonResponse
    {
        return response()->json([
            'data' => $service->execute($id, $request->validated())
        ], 201);
    }

    /**
     * Método que remove um registro de motorista.
     *
     * @param string $id
     * @param App\Domain\Driver\Services\DeleteDriverService $service
     *
     * @return Illuminate\Http\JsonResponse
     */

    public function destroy(string $id, DeleteDriverService $service): JsonResponse
    {
        $service->execute($id);

        return response()->json([
            'msg' => 'Motorista removido com sucesso.'
        ], 201);
    }
}
