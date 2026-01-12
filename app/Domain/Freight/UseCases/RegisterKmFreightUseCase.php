<?php

namespace App\Domain\Freight\UseCases;

use App\Enums\FreightType;
use App\Domain\Freight\Services\FreightCalculatorService;
use App\Domain\Freight\Services\FreightPriceResolverService;
use App\Models\Freight;
use Illuminate\Support\Facades\DB;
use DomainException;

class RegisterKmFreightUseCase
{
    public function __construct(
        private FreightPriceResolverService $priceResolver,
        private FreightCalculatorService $calculator
    ) {}

    public function execute(array $data): Freight
    {
        return DB::transaction(function () use ($data) {

            $this->validate($data);

            $pricePerKm = $this->priceResolver->resolveKmRate(
                $data['region_id'],
                $data['reference_date']
            );

            $totalValue = $this->calculator->calculateByKm(
                $data['km'],
                $pricePerKm
            );

            return Freight::create([
                'driver_id'    => $data['driver_id'],
                'vehicle_id'   => $data['vehicle_id'],
                'region_id'    => $data['region_id'],
                'freight_type' => FreightType::KM,
                'km'           => $data['km'],
                'total_price'  => $totalValue,
                'date'    => $data['reference_date'],
            ]);
        });
    }

    private function validate(array $data): void
    {
        $required = [
            'driver_id',
            'vehicle_id',
            'region_id',
            'km',
            'reference_date',
        ];

        foreach ($required as $field) {
            if (!array_key_exists($field, $data)) {
                throw new DomainException(
                    "Campo obrigatório não informado: {$field}"
                );
            }
        }

        if ($data['km'] <= 0) {
            throw new DomainException('KM deve ser maior que zero.');
        }
    }
}
