<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FreightKmEntry extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'freight_id',
        'km',
    ];

    protected $casts = [
        'km' => 'decimal:2',
    ];

    public function freight()
    {
        return $this->belongsTo(Freight::class);
    }
}
