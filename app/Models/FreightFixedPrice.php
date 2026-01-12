<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FreightFixedPrice extends Model
{
    use HasUuids;

    protected $fillable = [
        'region_id',
        'description',
        'fixed_value',
        'average_km',
        'valid_from',
        'valid_until',
        'active',
    ];

    protected $casts = [
        'fixed_value' => 'decimal:2',
        'average_km' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'active' => 'boolean',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
