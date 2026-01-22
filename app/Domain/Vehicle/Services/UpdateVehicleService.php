<?php

namespace App\Domain\Vehicle\Services;

use App\Models\Vehicle;

class UpdateVehicleService
{
    public function execute(string $id, array $data): Vehicle
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($data);

        return $vehicle;
    }
}
