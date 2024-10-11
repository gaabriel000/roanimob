<?php

namespace App\Enums;

enum ContractStatus: string
{
    case ACTIVE = 'Ativo';
    case FINISHED = 'Finalizado';
    case RENEW = 'Renovado';
    case CANCELLED = 'Cancelado';
}
