<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Validators\AddressValidator;

class AddressService extends BaseService
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function create($data)
    {
        $validator = new AddressValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $address = $this->addressRepository->create($data);
        return $this->response($address, 201);
    }

    public function delete($id)
    {
        $result = $this->addressRepository->delete($id);

        if (!$result) {
            return $this->response('Endereço não encontrado ou já removido, ID: ' . $id, 404);
        }

        return $this->response('Endereço removido com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $data)
    {
        $validator = new AddressValidator();
        $validation_result = $validator->validate($data, true);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $address = $this->addressRepository->update($id, $data);

        if (!$address) {
            return $this->response('Endereço não encontrado, ID: ' . $id, 404);
        }

        return $this->response($address, 200);
    }

    public function query($data)
    {
        $address = $this->queryData($data);

        if ($address['data']) {
            return $this->response($address, 200);
        } else {
            return $this->response($address, 404);
        }
    }

    public function queryData(array $data): array
    {
        return $this->addressRepository->findByAttributes($data);
    }
}
