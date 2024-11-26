<?php

namespace App\Services;

use App\Repositories\PropertyRepository;
use App\Validators\PropertyValidator;

class PropertyService
{
    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function create($request)
    {
        $data = $request->all();
        $validator = new PropertyValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], 400);
        }

        $property = $this->createPropertyAndAddress($data);
        return response()->json($property, 201);
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
            return response()->json('Propriedade não encontrada ou já removida, ID: ' . $id, 404);
        }

        return response()->json('Propriedade removida com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $request)
    {
        $data = $request->all();
        $validator = new PropertyValidator();
        $validation_result = $validator->validate($data, true);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], 400);
        }

        $property = $this->propertyRepository->update($id, $data);

        if (!$property) {
            return response()->json('Propriedade não encontrada, ID: ' . $id, 404);
        }

        return response()->json($property, 200);
    }

    public function query($request)
    {
        $data = $request->all();
        $property = $this->queryData($data);

        if ($property['data']) {
            return response()->json($property, 200);
        } else {
            return response()->json($property, 404);
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
