<?php

namespace App\Enums;

enum DriverBonusType: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';
    case NONE = 'none';

    public function label(): string
    {
        return match ($this) {
            self::NONE       => 'Nenhum',
            self::FIXED      => 'Fixo',
            self::PERCENTAGE => 'Percentual',
        };
    }
}
