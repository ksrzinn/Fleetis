<?php

namespace App\Models;

use App\Enums\PayableAccountTypes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PayableAccount extends Model
{
    use HasUuids;

    protected $fillable = [
        'description',
        'total_value',
        'due_date',
        'installments',
        'is_recurring',
        'category',
        'status',
    ];

    protected $casts = [
        'total_value' => 'decimal:2',
        'due_date' => 'date',
        'installments' => 'integer',
        'is_recurring' => 'boolean',
        'status' => PayableAccountTypes::class,
    ];
}
