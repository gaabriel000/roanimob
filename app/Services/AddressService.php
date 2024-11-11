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

    public function delete($request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $address = $this->addressRepository->delete($data);

        if (!$address) {
            return response()->json(404);
        }

        return response()->json(200);
    }

    public function update($request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $address = $this->addressRepository->update($data);

        if (!$address) {
            return response()->json(404);
        }

        $address = Converter::convertKeysToCamelCase($address);
        return response()->json($address, 200);
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
