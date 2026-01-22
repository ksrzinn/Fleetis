<?php

namespace App\Models;

use App\Enums\VehicleStatus;
use App\Models\Freight;
use App\Models\FuelEntry;
use App\Models\Maintenance;
use App\Models\Region;
use App\Models\Tire;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'plate',
        'vehicle_type_id',
        'model',
        'year',
        'current_km',
        'region_id',
        'status',
        'oil_change_km',
    ];

    protected $casts = [
        'year' => 'integer',
        'current_km' => 'integer',
        'oil_change_km' => 'integer',
        'status' => VehicleStatus::class,
    ];

    protected $appends =[
        'status_label'
    ];

    public function baseRegion()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }

    public function trailerFreights()
    {
        return $this->hasMany(Freight::class, 'trailer_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function tires()
    {
        return $this->hasMany(Tire::class);
    }

    public function fuelEntries()
    {
        return $this->hasMany(FuelEntry::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    /**
     * Accessors
     */

    public function getStatusLabelAttribute(): String
    {
        return $this->status?->label() ?? '';
    }
}

