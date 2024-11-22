<?php

namespace App\Services;

use App\Repositories\PropertyRepository;
use App\Services\AddressService;

class PropertyService
{
    protected $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }
}
