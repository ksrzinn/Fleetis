<?php

namespace App\Domain\Freight\Services;

use App\Models\FreightFixedPrice;
use App\Models\KmRate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FreightPriceResolverService
{
    public function resolveKmRate(string $regionId, Carbon $date): float
    {
        $rate = KmRate::query()
            ->where('region_id', $regionId)
            ->where('active', true)
            ->where('valid_from', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', $date);
            })
            ->orderByDesc('valid_from')
            ->first();

        if (! $rate) {
            throw new ModelNotFoundException('Sem tarifa de KM ativa para essa região.');
        }

        return (float) $rate->price_per_km;
    }

    public function resolveFixedPrice(string $fixedPriceId): float
    {
        $price = FreightFixedPrice::query()
            ->where('id', $fixedPriceId)
            ->first();

        if (! $price) {
            throw new ModelNotFoundException('Frete fixo não encontrado.');
        }

        return (float) $price->fixed_value;
    }
}
