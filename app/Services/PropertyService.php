<?php

namespace App\Services;

use App\Repositories\PropertyRepository;

class PropertyService
{
    protected $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function getAllProperties()
    {
        return $this->propertyRepository->all();
    }

    public function getPropertyById($id)
    {
        return $this->propertyRepository->find($id);
    }

    public function createProperty(array $data)
    {
        // Validação ou lógica de negócios antes da criação
        return $this->propertyRepository->create($data);
    }

    public function updateProperty($id, array $data)
    {
        // Lógica de atualização
        return $this->propertyRepository->update($id, $data);
    }

    public function deleteProperty($id)
    {
        return $this->propertyRepository->delete($id);
    }
}
