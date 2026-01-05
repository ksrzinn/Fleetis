<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Region extends Model
{
    use HasUuid;

    protected $fillable = [
        'name',
        'state',
        'city',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function freightPriceTables()
    {
        return $this->hasMany(FreightPriceTable::class);
    }

    public function freightFixedPriceTables()
    {
        return $this->hasMany(FreightFixedPriceTable::class);
    }

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
