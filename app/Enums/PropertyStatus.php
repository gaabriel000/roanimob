<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case OPEN = 'Disponível';
    case RENTED = 'Alugada';
    case CONTRACT = 'Contrato';
    case DISABLED = 'Indisponível';
}
