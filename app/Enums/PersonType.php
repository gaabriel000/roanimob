<?php

namespace App\Enums;

enum PersonType: string
{
    case OWNER = 'Proprietário';
    case TENANT = 'Inquilino';
}
