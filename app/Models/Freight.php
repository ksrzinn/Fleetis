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
        'type',
        'total_value',
        'reference_date',
    ];

    protected $casts = [
        'total_value' => 'decimal:2',
        'reference_date' => 'date',
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
