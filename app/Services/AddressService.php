<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Validators\AddressValidator;
use App\Utils\Converter;

class AddressService
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function create($request)
    {
        $data = $request->all();
        $validator = new AddressValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], 400);
        }

        $address = $this->createAddress($data);
        return response()->json($address, 201);
    }

    public function createAddress(array $data): array
    {
        $data = Converter::convertKeysToSnakeCase($data);
        $address = $this->addressRepository->create($data);

        return Converter::convertKeysToCamelCase($address);
    }

    public function delete($id)
    {
        $result = $this->addressRepository->delete($id);

        if (!$result) {
            return response()->json('Address with ID was not found or was already removed: ' . $id, 404);
        }

        return response()->json('Address with ID was succesfully removed: ' . $id, 200);
    }

    public function update($id, $request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $address = $this->updateAddress($id, $data);

        if (!$address) {
            return response()->json('Address not found with ID: ' . $id, 404);
        }

        $address = Converter::convertKeysToCamelCase($address);
        return response()->json($address, 200);
    }

    public function updateAddress($id, array $data): array
    {
        return $this->addressRepository->update($id, $data);
    }

    public function query($request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $address = $this->queryData($data);

        if ($address) {
            $address = Converter::convertKeysToCamelCase($address);
            return response()->json($address, 200);
        } else {
            return response()->json($address, 404);
        }
    }

    public function queryData(array $data): array
    {
        return $this->addressRepository->findByAttributes($data);
    }
}
