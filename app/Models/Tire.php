<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Tire extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'vehicle_id',
        'brand',
        'initial_km',
        'useful_life_km',
        'installed_at',
    ];

    protected $casts = [
        'initial_km' => 'integer',
        'useful_life_km' => 'integer',
        'installed_at' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
