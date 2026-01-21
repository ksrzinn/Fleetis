<?php

namespace App\Domain\Driver\Services;

use App\Models\Driver;

class CreateDriverService
{
    public function execute(array $data): Driver
    {
        return Driver::create($data);
    }
}
