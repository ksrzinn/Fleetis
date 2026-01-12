<?php

namespace App\Enums;

enum FreightStatus: string
{
    case PENDING_KM = 'pending_km';
    case PENDING_PAYMENT = 'pending_payment';
    case CLOSED = 'closed';
}
