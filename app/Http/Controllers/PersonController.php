<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    private PersonService $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function query()
    {
        return 'welcome';
    }

    public function create(Request $request)
    {
        return $this->personService->create($request);
    }

    public function update(Request $request)
    {
        return 'update';
    }

    public function delete()
    {
        return 'delete';
    }
}
