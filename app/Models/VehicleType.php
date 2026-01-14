<?php

namespace App\Models;

use App\Enums\VehicleType as EnumsVehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleType extends Model
{
    use HasFactory;

    protected $table = 'vehicle_types';

    protected $fillable = [
        'name',
        'type',
        'description',
        'truck_axles',
        'oil_change_km',
    ];

    protected $casts = [
        'type' => EnumsVehicleType::class,
        'active' => 'boolean',
        'truck_axles' => 'integer',
        'oil_change_km' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Relationships (preparado pro futuro)
    |--------------------------------------------------------------------------
    */

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators / Accessors
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->name) {
                $model->name = trim($model->name);
            }
        });
    }
}
