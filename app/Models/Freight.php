<?php

namespace App\Models;

use App\Enums\FreightStatus;
use App\Enums\FreightType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Freight extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'vehicle_id',
        'trailer_id',
        'driver_id',
        'region_id',
        'freight_type',
        'freight_fixed_price_id',
        'date',
        'km_start',
        'km_end',
        'fixed_value_snapshot',
        'km_rate_snapshot',
        'total_value',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'km_start' => 'integer',
        'km_end' => 'integer',
        'fixed_value_snapshot' => 'decimal:2',
        'km_rate_snapshot' => 'decimal:2',
        'total_value' => 'decimal:2',
        'status' => FreightStatus::class,
        'freight_type' => FreightType::class,
    ];

    protected $appends = [
        'status_label',
        'freight_type_label'
    ];

    protected static function booted(): void
    {
        static::creating(function (Freight $freight) {
            if (! $freight->status) {
                $freight->status = FreightStatus::CLOSED;
            }
        });

        static::saving(function (Freight $freight) {
            if (
                $freight->freight_type === FreightType::KM &&
                $freight->km_start !== null &&
                $freight->km_end !== null
            ) {
                // $freight->km_traveled = $freight->km_end - $freight->km_start;
                return;
            }
        });
    }

    /* =======================
    |  Domain helpers
     ======================= */

    public function closeKmFreight(int $kmEnd): void
    {
        $this->km_end = $kmEnd;
        $this->status = FreightStatus::PENDING_PAYMENT;
        $this->save();
    }

    public function closeFixedFreight(): void
    {
        $this->status = FreightStatus::PENDING_PAYMENT;
        $this->save();
    }

    /* =======================
    |  Relationships
     ======================= */

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Vehicle::class, 'trailer_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function fixedPrice()
    {
        return $this->belongsTo(FreightFixedPrice::class, 'freight_fixed_price_id');
    }

    /* =======================
    |  Scopes
     ======================= */

    public function scopeFixed($query)
    {
        return $query->where('freight_type', FreightType::FIXED);
    }

    public function scopeKm($query)
    {
        return $query->where('freight_type', FreightType::KM);
    }

    public function scopePendingKm($query)
    {
        return $query->where('status', FreightStatus::PENDING_KM);
    }

    /**
     * Accessors
     */

    public function getFreightTypeLabelAttribute(): string
    {
        return $this->freight_type?->label() ?? '';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status?->label() ?? '';
    }
}
