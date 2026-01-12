<?php

namespace App\Enums;

enum PayableAccountTypes: string
{
    case OPEN = 'open';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
}
