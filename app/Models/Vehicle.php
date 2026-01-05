<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Vehicle extends Model
{
    use HasUuid;

    protected $fillable = [
        'plate',
        'type',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
