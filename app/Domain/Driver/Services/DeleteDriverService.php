<?php

namespace App\Domain\Driver\Services;

use App\Models\Driver;

class DeleteDriverService
{
    public function execute(string $id): void
    {
        Driver::findOrFail($id)->delete();
    }
}
