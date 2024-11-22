<?php

namespace App\Http\Controllers;

use App\Services\PropertyService;

class PropertyController extends BaseController
{
    public function __construct(PropertyService $propertyService)
    {
        parent::__construct($propertyService);
    }
}
