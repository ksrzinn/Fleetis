<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    use HasUuids;

    protected $fillable = [
        'description',
        'notes',
    ];

    public $timestamps = false;

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
