<?php

namespace App\Domain\Freight\UseCases;

use App\Domain\Freight\Services\FreightPriceResolverService;
use App\Models\Freight;
use Illuminate\Support\Facades\DB;

class RegisterFixedFreightUseCase
{
    public function __construct(
        private FreightPriceResolverService $priceResolver
    ) {}

    public function execute(array $data): Freight
    {
        return DB::transaction(function () use ($data){
            $fixedPrice = $this->priceResolver->getFixedPrice(
                $data['freight_fixed_price_table_id']
            );

            return Freight::create([
                'driver_id' => $data['driver_id'],
                'vehicle_id' => $data['vehicle_id'],
                'region_id' => $data['region_id'],
                'freight_type' => 'fixed',
                'total_price' => $fixedPrice,
            ]);
        });
    }
}
