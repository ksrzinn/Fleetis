<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasUuids;

    protected $fillable = [
        'vehicle_id',
        'maintenance_type_id',
        'value',
        'date',
        'notes',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function type()
    {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id');
    }
}

