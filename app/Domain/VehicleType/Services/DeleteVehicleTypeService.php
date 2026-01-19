<?php

namespace App\Domain\VehicleType\Services;

use App\Models\VehicleType;
use Illuminate\Validation\ValidationException;

class DeleteVehicleTypeService
{
    public function execute(string $id): void
    {
        $vehicleType = VehicleType::findOrFail($id);

        if ($vehicleType->vehicles()->exists()) {
            throw ValidationException::withMessages([
                'vehicle_type' => 'Não é possível excluir um tipo de veículo com veículos vinculados.'
            ]);
        }

        $vehicleType->delete();
    }
}
