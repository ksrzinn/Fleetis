<?php

namespace App\Domain\Vehicle\Services;

use App\Models\Vehicle;

class DeleteVehicleService
{
    public function execute(string $id): void
    {
        Vehicle::findOrFail($id)->delete();
    }
}
