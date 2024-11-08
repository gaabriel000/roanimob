<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use App\Validators\PersonValidator;
use App\Utils\CaseConverter;

class PersonService
{
    private PersonRepository $personRepository;
    private AddressService $addressService;

    public function __construct(PersonRepository $personRepository, AddressService $addressService)
    {
        $this->personRepository = $personRepository;
        $this->addressService = $addressService;
    }

    public function create($request)
    {
        $data = $request->all();
        $validator = new PersonValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], 400);
        }

        $this->createPersonAndAddress($data);
    }

    private function createPersonAndAddress($data)
    {
        $address_data = $data['address'];
        $address_id = $address_data['id'];

        if ($address_id) {
            $address = $this->addressService->query(['id' => $address_id]);
        } else {
            $address = $this->addressService->create($address_data);
        }

        $data['address_id'] = $address->id;

        $data = CaseConverter::convertKeysToSnakeCase($data);
        $person = $this->personRepository->create($data);

        $person = CaseConverter::convertKeysToCamelCase($person);
        return response()->json($person, 201);
    }

    public function delete($request)
    {
        $data = CaseConverter::convertKeysToSnakeCase($request->all());
        $person = $this->personRepository->delete($data);

        if (!$person) {
            return response()->json(404);
        }

        return response()->json(200);
    }

    public function update($request)
    {
        $data = CaseConverter::convertKeysToSnakeCase($request->all());
        $person = $this->personRepository->update($data);

        if (!$person) {
            return response()->json(404);
        }

        $person = CaseConverter::convertKeysToCamelCase($person);
        return response()->json($person, 200);
    }

    public function query($request)
    {
        $data = CaseConverter::convertKeysToSnakeCase($request->all());
        $person = $this->queryData($data);

        if ($person) {
            $person = CaseConverter::convertKeysToCamelCase($person);
            return response()->json($person, 200);
        } else {
            return response()->json($person, 404);
        }
    }

    private function queryData($data)
    {
        return $this->personRepository->findByAttributes($data);
    }
}
