<?php

namespace App\Domain\Driver\Services;

use App\Models\Driver;

class UpdateDriverService
{
    public function execute(string $id, array $data): Driver
    {
        $driver = Driver::findOrFail($id);
        $driver->update($data);

        return $driver;
    }
}
