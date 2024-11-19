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

    public function createPersonAndAddress(array $data): array
    {
        $address_id = null;
        $data = Converter::convertKeysToSnakeCase($data);

        if (isset($data['address'])) {
            $address_data = $data['address'];

            if (isset($address_data['id'])) {
                $address_id = $address_data['id'];
                $person = $this->personRepository->createAndUpdateAddress($data, $address_data, $address_id);
            } else {
                $person = $this->personRepository->createWithAddress($data, $address_data);
            }
        } else {
            $person = $this->personRepository->create($data);
        }

        return Converter::convertKeysToCamelCase($person);
    }

    public function createAddress(array $address_data, array &$data): void
    {
        $address = $this->addressService->createAddress($address_data);
        $addressArray = $address;
        $data['address_id'] = $addressArray['id'];
    }

    public function delete($id)
    {
        $result = $this->personRepository->delete($id);

        if (!$result) {
            return response()->json('Person with ID was not found or was already removed: ' . $id, 404);
        }

        return response()->json('Person with ID was succesfully removed: ' . $id, 200);
    }

    public function update($id, $request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $person = $this->personRepository->update($id, $data);

        if (!$person) {
            return response()->json('Person not found with ID: ' . $id, 404);
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

    public function queryData(array $data): array
    {
        $query_relation = isset($data['include_address']) && $data['include_address'] === 'true' ? ['address'] : [];
        $per_page = isset($data['per_page']) ? $data['per_page'] : 10;
        $page = isset($data['page']) ? $data['page'] : 1;

        return $this->personRepository->findByAttributes($data, $query_relation, $per_page, $page);
    }
}
