<?php

namespace App\Http\Controllers;

use App\Services\PropertyService;

class PropertyController extends BaseController
{
    public function __contruct(PropertyService $propertyService)
    {
        parent::__contruct($propertyService);
    }
}
