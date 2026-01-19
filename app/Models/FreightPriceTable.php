<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FreightPriceTable extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'region_id',
        'price_per_km',
    ];

    protected $casts = [
        'price_per_km' => 'decimal:2',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
