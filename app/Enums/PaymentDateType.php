<?php

namespace App\Enums;

enum PaymentDateType: string
{
    case AHEAD = 'Adiantado';
    case RETROACTIVE = 'Retroativo';
}
