<?php

namespace App\Models;

use App\Enums\DriverBonusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Driver extends BaseModel
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
        'bonus_type' => DriverBonusType::class,
    ];

    protected $appends = [
        'bonus_type_label'
    ];

    /**
     * Relationships
     */

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }

    public function fuelEntries()
    {
        return $this->hasMany(FuelEntry::class);
    }

    /**
     * Accessors
     */

    public function getBonusTypeLabelAttribute(): string
    {
        return $this->bonus_type?->label() ?? '';
    }
}

