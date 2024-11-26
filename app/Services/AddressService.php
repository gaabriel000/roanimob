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

        $address = $this->addressRepository->create($data);
        return response()->json($address, 201);
    }

    public function delete($id)
    {
        $result = $this->addressRepository->delete($id);

        if (!$result) {
            return response()->json('Endereço não encontrado ou já removido, ID: ' . $id, 404);
        }

        return response()->json('Endereço removido com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $request)
    {
        $data = $request->all();
        $validator = new AddressValidator();
        $validation_result = $validator->validate($data, true);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], 400);
        }

        $address = $this->addressRepository->update($id, $data);

        if (!$address) {
            return response()->json('Endereço não encontrado, ID: ' . $id, 404);
        }

        return response()->json($address, 200);
    }

    public function query($request)
    {
        $data = $request->all();
        $address = $this->queryData($data);

        if ($address['data']) {
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
