<?php

namespace App\Services;

use App\Repositories\PropertyRepository;
use App\Validators\PropertyValidator;

class PropertyService extends BaseService
{
    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function create($data)
    {
        $validator = new PropertyValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $property = $this->createPropertyAndAddress($data);
        return $this->response($property, 201);
    }

    private function createPropertyAndAddress(array $data): array
    {
        $address_id = null;
        $address_data = $data['address'];

        if (isset($address_data['id'])) {
            $address_id = $address_data['id'];
            $property = $this->propertyRepository->createAndUpdateAddress($data, $address_data, $address_id);
        } else {
            $property = $this->propertyRepository->createWithAddress($data, $address_data);
        }

        return $property;
    }

    public function delete($id)
    {
        $result = $this->propertyRepository->delete($id);

        if (!$result) {
            return $this->response('Propriedade não encontrada ou já removida, ID: ' . $id, 404);
        }

        return $this->response('Propriedade removida com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $data)
    {
        $validator = new PropertyValidator();
        $validation_result = $validator->validate($data, true);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $property = $this->updateData($id, $data);

        if (!$property) {
            return $this->response('Propriedade ou endereço não encontrados, ID: ' . $id, 404);
        }

        return $this->response($property, 200);
    }

    public function updateData($id, $data)
    {
        $address_id = null;

        if (isset($data['address'])) {
            $address_data = $data['address'];

            if (isset($address_data['id'])) {
                $address_id = $address_data['id'];
                $property = $this->propertyRepository->UpdateAndUpdateAddress($data, $address_data, $id, $address_id);
            } else {
                return null;
            }
        } else {
            $property = $this->propertyRepository->update($id, $data);
        }

        return $property;
    }

    public function query($data)
    {
        $property = $this->queryData($data);

        if ($property['data']) {
            return $this->response($property, 200);
        } else {
            return $this->response($property, 404);
        }
    }

    public function queryData(array $data): array
    {
        $query_relation = isset($data['include_address']) && $data['include_address'] === 'true' ? ['address'] : [];
        $per_page = isset($data['per_page']) ? $data['per_page'] : 10;
        $page = isset($data['page']) ? $data['page'] : 1;

        return $this->propertyRepository->findByAttributes($data, $query_relation, $per_page, $page);
    }
}
