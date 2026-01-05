<?php

namespace App\Domain\Freight\Services;

class FreightCalculatorService
{
    public function calculateByKm(float $km, float $pricePerKm): float
    {
        return round($km * $pricePerKm, 2);
    }
}
