<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Validators\AddressValidator;
use App\Utils\CaseConverter;

class AddressService
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->AddressRepository = $addressRepository;
    }

    public function create($request)
    {
        $data = $request->all();
        $validator = new AddressValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], 400);
        }

        $this->createAddress($data);
    }

    private function createAddress($data)
    {
        $data = CaseConverter::convertKeysToSnakeCase($data);
        $address = $this->addressRepository->create($data);

        $address = CaseConverter::convertKeysToCamelCase($address);
        return response()->jon($address, 201);
    }

    public function delete($request)
    {
        $data = CaseConverter::convertKeysToSnakeCase($request->all());
        $address = $this->addressRepository->delete($data);

        if (!$address) {
            return response()->json(404);
        }

        return response()->json(200);
    }

    public function update($request)
    {
        $data = CaseConverter::convertKeysToSnakeCase($request->all());
        $address = $this->addressRepository->update($data);

        if (!$address) {
            return response()->json(404);
        }

        $address = CaseConverter::convertKeysToCamelCase($address);
        return response()->json($address, 200);
    }

    public function query($request)
    {
        $data = CaseConverter::convertKeysToSnakeCase($request->all());
        $address = $this->queryData($data);

        if ($address) {
            $address = CaseConverter::convertKeysToCamelCase($address);
            return response()->json($address, 200);
        } else {
            return response()->json($address, 404);
        }
    }

    private function queryData($data)
    {
        return $this->addressRepository->findByAttributes($data);
    }
}
