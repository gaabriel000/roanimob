<?php

namespace App\Enums;

enum GuaranteeType: string
{
    case GUARANTOR = 'Avalista';
    case DEPOSIT = 'Caução';
}
