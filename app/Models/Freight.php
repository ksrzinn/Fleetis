<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Freight extends Model
{
    use HasUuids;

    protected $fillable = [
        'vehicle_id',
        'trailer_id',
        'driver_id',
        'region_id',
        'freight_type',
        'status',
        'freight_fixed_price_id',
        'date',
        'km_start',
        'km_end',
        'km_traveled',
        'fixed_value_snapshot',
        'km_rate_snapshot',
        'total_value',
    ];

    protected $casts = [
        'date' => 'date',
        'km_start' => 'integer',
        'km_end' => 'integer',
        'km_traveled' => 'integer',
        'fixed_value_snapshot' => 'decimal:2',
        'km_rate_snapshot' => 'decimal:2',
        'total_value' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Vehicle::class, 'trailer_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function fixedPrice()
    {
        return $this->belongsTo(FreightFixedPrice::class, 'freight_fixed_price_id');
    }
}
