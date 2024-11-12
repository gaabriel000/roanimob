<?php

namespace App\Http\Controllers;

use App\Services\AddressService;

class AddressController extends BaseController
{
    public function __construct(AddressService $addressService)
    {
        parent::__construct($addressService);
    }
}
