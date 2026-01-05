<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Freight extends Model
{
    use HasUuid;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'region_id',
        'freight_type',
        'total_km',
        'total_price',
        'closed_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'closed_at' => 'date',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function kmEntry()
    {
        return $this->hasOne(FreightKmEntry::class);
    }
}
