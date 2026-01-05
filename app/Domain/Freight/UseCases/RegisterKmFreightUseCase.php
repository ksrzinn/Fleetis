<?php

use App\Domain\Freight\Services\FreightCalculatorService;
use App\Domain\Freight\Services\FreightPriceResolverService;
use App\Models\Freight;
use App\Models\FreightKmEntry;
use Illuminate\Support\Facades\DB;

class RegisterKmFreightUseCase
{
    public function __construct(
        private FreightPriceResolverService $priceResolver,
        private FreightCalculatorService $calculator
    ) {}

    public function execute(array $data): Freight
    {
        return DB::transaction(function () use ($data) {
            $pricePerKm = $this->priceResolver->getPricePerKm($data['region_id']);
            $totalValue = $this->calculator->calculateByKm(
                $data['km'],
                $pricePerKm
            );

            $freight = Freight::create([
                'driver_id' => $data['driver_id'],
                'vehicle_id' => $data['vehicle_id'],
                'region_id' => $data['region_id'],
                'freight_type' => 'km',
                'total_price' => $totalValue,
                'closed_at' => $data['reference_date']
            ]);

            FreightKmEntry::create([
                'freight_id' => $freight->id,
                'km' => $data['km'],
            ]);
        });
    }
}
