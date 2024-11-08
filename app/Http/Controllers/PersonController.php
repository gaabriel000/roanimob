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

    public function create(Request $request)
    {
        return $this->personService->create($request);
    }

    public function delete(Request $request)
    {
        return $this->personService->delete($request);
    }

    public function update(Request $request)
    {
        return $this->personService->update($request);
    }

    public function query(Request $request)
    {
        return $this->personService->query($request);
    }
}
