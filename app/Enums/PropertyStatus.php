<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case OPEN = 'Livre';
    case RENTED = 'Alugada';
    case RESERVED = 'Reservada';
    case BLOCKED = 'Bloqueada';
}
