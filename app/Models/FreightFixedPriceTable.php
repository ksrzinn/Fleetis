<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class FreightFixedPriceTable extends Model
{
    use HasUuid;

    protected $fillable = [
        'region_id',
        'description',
        'fixed_value',
        'average_km',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'fixed_value' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
