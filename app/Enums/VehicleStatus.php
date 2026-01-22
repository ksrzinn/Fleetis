<?php

namespace App\Enums;

enum VehicleStatus: string
{
    case ACTIVE = 'active';
    case MAINTENANCE = 'maintenance';
    case SOLD = 'sold';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE        => 'Ativo',
            self::MAINTENANCE   => 'Manutenção',
            self::SOLD          => 'Vendido',
        };
    }
}
