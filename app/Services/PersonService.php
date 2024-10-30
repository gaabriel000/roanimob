<?php

namespace App\Services;

use App\Repositories\PersonRepository;

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

        return $this->contractRepository->create($request->all());
    }
}
