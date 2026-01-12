<?php

namespace App\Domain\Freight\Services;

class FreightCalculatorService
{
    public function calculateKmTraveled(int $kmStart, int $kmEnd): int
    {
        if ($kmEnd < $kmStart) {
            throw new \DomainException('KM final não pode ser menor que KM inicial.');
        }

        return $kmEnd - $kmStart;
    }

    public function calculateByKm(int $kmTraveled, float $pricePerKm): float
    {
        return round($kmTraveled * $pricePerKm, 2);
    }
}
