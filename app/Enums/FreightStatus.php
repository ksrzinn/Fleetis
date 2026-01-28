<?php

namespace App\Enums;

enum FreightStatus: string
{
    case PENDING_KM = 'pending_km';
    case PENDING_PAYMENT = 'pending_payment';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_KM      => 'Quilômetragem Pendente',
            self::PENDING_PAYMENT      => 'Pagamento Pendente',
            self::CLOSED => 'Encerrado',
        };
    }
}
