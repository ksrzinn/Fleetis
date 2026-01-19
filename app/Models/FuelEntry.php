<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FuelEntry extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'region_id',
        'date',
        'liters',
        'total_value',
        'gas_station',
    ];

    protected $casts = [
        'date' => 'date',
        'liters' => 'decimal:2',
        'total_value' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

