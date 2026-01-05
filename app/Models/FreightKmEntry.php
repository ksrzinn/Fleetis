<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class FreightKmEntry extends Model
{
    use HasUuid;

    protected $fillable = [
        'freight_id',
        'km',
        'notes',
    ];

    protected $casts = [
        'km' => 'decimal:2',
    ];

    public function freight()
    {
        return $this->belongsTo(Freight::class);
    }
}
