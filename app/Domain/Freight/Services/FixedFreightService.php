<?php

namespace App\Domain\Freight\Services;

use App\Enums\FreightStatus;
use App\Enums\FreightType;
use App\Models\Freight;
use App\Models\FreightFixedPrice;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class FixedFreightService
{
    /**
     * Criação de frete fixo
     */
    public function store(array $data): Freight
    {
        return DB::transaction(function () use ($data) {

            $vehicle = Vehicle::findOrFail($data['vehicle_id']);
            $fixedPrice = FreightFixedPrice::findOrFail($data['freight_fixed_price_id']);

            $kmStart = $vehicle->current_km;
            $kmEnd = $kmStart + $fixedPrice->average_km;

            $freight = Freight::create([
                'vehicle_id' => $vehicle->id,
                'trailer_id' => $data['trailer_id'] ?? null,
                'driver_id' => $data['driver_id'],
                'region_id' => $data['region_id'],
                'freight_type' => FreightType::FIXED,
                'freight_fixed_price_id' => $fixedPrice->id,
                'date' => $data['date'],
                'km_start' => $kmStart,
                'km_end' => $kmEnd,

                // SNAPSHOTS 🔥
                'fixed_value_snapshot' => $fixedPrice->value,
                'total_value' => $fixedPrice->value,

                'status' => FreightStatus::CLOSED,
            ]);

            // Atualiza KM do veículo
            $vehicle->update([
                'current_km' => $kmEnd,
            ]);

            return $freight;
        });
    }

    /**
     * Edição manual de frete fixo
     */
    public function update(Freight $freight, array $data): Freight
    {
        if ($freight->freight_type !== FreightType::FIXED) {
            throw new RuntimeException('Este frete não é do tipo fixo.');
        }

        $freight->update([
            'driver_id' => $data['driver_id'] ?? $freight->driver_id,
            'trailer_id' => $data['trailer_id'] ?? $freight->trailer_id,
            'date' => $data['date'] ?? $freight->date,
        ]);

        return $freight;
    }
}
