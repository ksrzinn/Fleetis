<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\KmRate;
use App\Models\FreightFixedPrice;
use App\Models\Freight;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Region extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'uf'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'base_region_id');
    }

    public function kmRates()
    {
        return $this->hasMany(KmRate::class);
    }

    public function freightFixedPrices()
    {
        return $this->hasMany(FreightFixedPrice::class);
    }

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
