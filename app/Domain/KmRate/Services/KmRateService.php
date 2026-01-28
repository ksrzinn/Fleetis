<?php

namespace App\Domain\KmRate\Services;

use App\Models\KmRate;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class KmRateService
{
    public function store (array $data): KmRate
    {
        return DB::transaction(function () use ($data) {

            if($data['active'] === true) {
                $this->disabledCurrentActive(
                    $data['region_id'],
                    $data['vehicle_type_id']
                );
            }
            return KmRate::create($data);
        });
    }

    public function update (string $id, array $data): KmRate
    {
        return DB::transaction(function () use ($id, $data) {
            $kmRate = KmRate::findOrFail($id);

            if ($data['active'] === true) {
                $this->disabledCurrentActive(
                    $data['region_id'],
                    $data['vehicle_type_id'],
                    $kmRate->id,
                );
            }

            $kmRate->update($data);

            return $kmRate;
        });
    }

    protected function disabledCurrentActive(string $region_id, string $vehicleTypeId, ?string $ignoreId=null): void
    {
        KmRate::where('region_id', $region_id)
            ->where('vehicle_type_id', $vehicleTypeId)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->update(['active' => false]);
    }

    public function getActivePrice(string $region_id, string $vehicleTypeId): KmRate
    {
        $price = KmRate::where('region_id', $region_id)
            ->where('vehicle_type_id', $vehicleTypeId)
            ->where('active', true)
            ->first();

        if (!$price) {
            throw new RuntimeException(
                'Não existe preço por KM ativo para esta região e tipo de veículo.'
            );
        }
        return $price;
    }
}
