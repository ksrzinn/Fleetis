<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model
{
    use HasFactory;

    /**
     * UUID como primary key
     */
    protected $keyType = 'string';

    /**
     * Não auto-incrementável
     */
    public $incrementing = false;

    /**
     * Cast padrão do ID
     */
    protected $casts = [
        'id' => 'string',
    ];
}
