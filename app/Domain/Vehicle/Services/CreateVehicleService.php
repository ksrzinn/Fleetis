<?php

namespace App\Domain\Vehicle\Services;

use App\Models\Vehicle;
use App\Models\Vehicles;

class CreateVehicleService
{
    public function execute(array $data): Vehicle
    {
        return Vehicle::create($data);
    }
}
