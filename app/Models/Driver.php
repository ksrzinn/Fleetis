<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Driver extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'phone',
        'cpf',
        'cnh',
        'cnh_type',
        'salary',
        'bonus_type',
        'bonus_value',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'bonus_value' => 'decimal:2',
    ];

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }

    public function fuelEntries()
    {
        return $this->hasMany(FuelEntry::class);
    }
}

