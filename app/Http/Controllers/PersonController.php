<?php

namespace App\Http\Controllers;

use App\Services\PersonService;

class PersonController extends BaseController
{
    public function __construct(PersonService $personService)
    {
        parent::__construct($personService);
    }
}
