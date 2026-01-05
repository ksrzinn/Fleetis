<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Driver extends Model
{
    use HasUuid;

    protected $fillable = [
        'name',
        'document',
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
