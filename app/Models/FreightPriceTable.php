<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class FreightPriceTable extends Model
{
    use HasUuid;

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
