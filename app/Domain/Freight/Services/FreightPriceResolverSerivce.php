<?php

namespace App\Domain\Freight\Services;

use App\Models\FreightPriceTable;
use App\Models\FreightFixedPriceTable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FreightPriceResolverService
{
    public function getPricePerKm(string $regionId): float
    {
        $price = FreightPriceTable::query()
            ->where('region_id', $regionId)
            ->first();

        if (! $price) {
            throw new ModelNotFoundException('Sem preço por KM ativo para essa região.');
        }

        return (float) $price->price_per_km;
    }

    public function getFixedPrice(string $fixedPriceTableId): float
    {
        $table = FreightFixedPriceTable::query()
            ->where('id', $fixedPriceTableId)
            ->first();

        if (! $table) {
            throw new ModelNotFoundException('Frete fixo não encontrado na tabela.');
        }

        return (float) $table->fixed_price;
    }
}
