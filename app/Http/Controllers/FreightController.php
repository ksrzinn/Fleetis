<?php

namespace App\Http\Controllers;

use App\Domain\Freight\Services\FixedFreightService;
use App\Http\Requests\Freight\StoreFixedFreightRequest;
use App\Http\Requests\Freight\UpdateFixedFreightRequest;
use App\Models\Freight;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class FreightController extends Controller
{
    public function __construct(
        protected FixedFreightService $fixedFreightService
    ) {}

    public function index()
    {
        return Inertia::render('Freights/Index');
    }

    public function fetchFreights(): JsonResponse
    {
        $freights = Freight::fixed()
            ->with(
                [
                    'vehicle',
                    'driver',
                    'region',
                    'fixedPrice',
                ]
            )
            ->latest()
            ->get();

        return response()->json($freights);
    }

    public function storeFixed(StoreFixedFreightRequest $request): JsonResponse
    {
        $freight = $this->fixedFreightService->store(
            $request->validated()
        );

        return response()->json([
            'message' => 'Frete fixo lançado com sucesso.',
            'data' => $freight,
        ], 201);
    }

    public function updateFixed(
        UpdateFixedFreightRequest $request,
        Freight $freight
    ): JsonResponse {
        $freight = $this->fixedFreightService->update(
            $freight,
            $request->validated()
        );

        return response()->json([
            'message' => 'Frete fixo atualizado com sucesso.',
            'data' => $freight,
        ]);
    }

    public function destroy(Freight $freight): JsonResponse
    {
        $freight->delete();

        return response()->json([
            'message' => 'Frete removido com sucesso.',
        ]);
    }
}
