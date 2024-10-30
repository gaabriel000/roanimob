<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Services\PersonService;
use App\Validators\PersonValidator;

class PersonController extends Controller
{
    private PersonService $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function create(Request $request)
    {
        $person = $this->personService->create($request);
        return response()->json($person, 201);
    }

    public function query()
    {
        return 'welcome';
    }

    public function delete()
    {
        return 'delete';
    }
}
