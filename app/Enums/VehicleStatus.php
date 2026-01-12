<?php

namespace App\Enums;

enum VehicleStatus: string
{
    case ACTIVE = 'active';
    case MAINTENANCE = 'maintenance';
    case SOLD = 'sold';
}
