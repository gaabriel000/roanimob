<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use App\Validators\PersonValidator;

class PersonService
{
    private PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function create($request)
    {
        $validator = new PersonValidator();
        $validationResult = $validator->validate($request->all());

        if (!$validationResult['valid']) {
            return response()->json($validationResult['errors'], 400);
        }

        $person = $this->personRepository->create($request->all());
        return response()->json($person, 201);
    }
}
