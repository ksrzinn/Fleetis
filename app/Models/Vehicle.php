<?php

namespace App\Models;

use App\Models\Freight;
use App\Models\FuelEntry;
use App\Models\Maintenance;
use App\Models\Region;
use App\Models\Tire;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasUuids;

    protected $fillable = [
        'plate',
        'type',
        'model',
        'year',
        'current_km',
        'base_region_id',
        'status',
        'oil_change_km',
    ];

    protected $casts = [
        'year' => 'integer',
        'current_km' => 'integer',
        'oil_change_km' => 'integer',
    ];

    public function baseRegion()
    {
        return $this->belongsTo(Region::class, 'base_region_id');
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
}

