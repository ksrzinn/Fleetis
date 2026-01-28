<?php

namespace App\Enums;

enum FreightType: string
{
    case FIXED = 'fixed';
    case KM = 'km';


    public function label(): string
    {
        return match ($this) {
            self::FIXED      => 'Fixo',
            self::KM => 'Tarifa',
        };
    }
}
