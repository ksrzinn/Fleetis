<?php

namespace App\Http\Controllers;

use App\Domain\KmRate\Services\KmRateService;
use App\Http\Requests\StoreKmRateRequest;
use App\Models\KmRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use Inertia\Inertia;

class KmRateController extends Controller
{
    public function __construct(
        protected KmRateService $service
    ) {}

    public function index(){
        return Inertia::render('KmRates/Index');
    }

    public function store(StoreKmRateRequest $request): JsonResponse
    {
        $rate = $this->service->store($request->validated());

        return response()->json([
            'data' => $rate,
            'msg' => 'Taxa de Km criada com sucesso.'
        ], 200);
    }

    public function update(StoreKmRateRequest $request, string $id): JsonResponse
    {
        $rate = $this->service->update($id, $request->validated());

        return response()->json([
            'data' => $rate,
            'msg' => 'Taxa de Km atualizada com sucesso.'
        ], 200);
    }

    public function destroy(KmRate $rate): JsonResponse
    {
        $rate->delete();

        return response()->json([
            'msg' => 'Taxa de Km deletada com sucesso.'
        ], 200);
    }

    public function fetchKmRates(): JsonResponse
    {
        $kmrs = KmRate::with('region', 'vehicleType')->orderBy('id')->get();

        return response()->json(['data' => $kmrs], 200);
    }
}
