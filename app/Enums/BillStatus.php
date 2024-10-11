<?php

namespace App\Enums;

enum BillStatus: string
{
    case OPEN = 'Aberto';
    case PAID = 'Pago';
    case LATE = 'Vencido';
    case CANCELLED = 'Cancelado';
}
