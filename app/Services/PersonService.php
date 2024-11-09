<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use App\Services\AddressService;
use App\Utils\Converter;
use App\Validators\PersonValidator;

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

        $person = $this->createPersonAndAddress($data);
        return response()->json($person, 201);
    }

    public function createPersonAndAddress($data)
    {
        $addressArray = [];

        if (array_key_exists('address', $data)) {
            $address_data = $data['address'];
            $address_id = array_key_exists('id', $address_data) ? $address_data['id'] : null;

            if ($address_id) {
                $address = $this->addressService->queryData(['id' => $address_id]);
                $addressArray = $address[0];
                // update address
                $data['address_id'] = $addressArray['id'];
            } else {
                $address = $this->addressService->createAddress($address_data);
                $addressArray = $address;
                $data['address_id'] = $addressArray['id'];
            }
        }

        $data = Converter::convertKeysToSnakeCase($data);
        $person = $this->personRepository->create($data);

        if (isset($addressArray)) {
            $person['address'] = $addressArray;
        }

        return Converter::convertKeysToCamelCase($person);
    }

    public function delete($request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $person = $this->personRepository->delete($data);

        if (!$person) {
            return response()->json(404);
        }

        return response()->json(200);
    }

    public function update($request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $person = $this->personRepository->update($data);

        if (!$person) {
            return response()->json(404);
        }

        $person = Converter::convertKeysToCamelCase($person);
        return response()->json($person, 200);
    }

    public function query($request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $person = $this->queryData($data);

        if ($person) {
            $person = Converter::convertKeysToCamelCase($person);
            return response()->json($person, 200);
        } else {
            return response()->json($person, 404);
        }
    }

    public function queryData($data)
    {
        return $this->personRepository->findByAttributes($data);
    }
}
