<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class KmRate extends Model
{
    use HasUuids;

    protected $fillable = [
        'region_id',
        'price_per_km',
        'valid_from',
        'valid_until',
        'active',
    ];

    protected $casts = [
        'price_per_km' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'active' => 'boolean',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

