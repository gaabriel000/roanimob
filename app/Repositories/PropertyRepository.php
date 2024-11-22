<?php

namespace App\Repositories;

use App\Models\Property;

class PropertyRepository extends BaseRepository
{
    private AddressRepository $addressRepository;

    public function __construct(Property $model, AddressRepository $addressRepository)
    {
        parent::__construct($model);
        $this->addressRepository = $addressRepository;
    }

    public function createWithAddress(array $propertyData, array $addressData): array
    {
        return DB::transaction(function () use ($propertyData, $addressData) {
            $address = $this->addressRepository->create($addressData);
            return $this->createPropertyConfigureAddressData($address, $propertyData);
        });
    }

    public function createAndUpdateAddress(array $propertyData, array $addressData, string $id): array
    {
        return DB::transaction(function () use ($propertyData, $addressData, $id) {
            $address = $this->addressRepository->update($id, $addressData);
            return $this->createPropertyConfigureAddressData($address, $propertyData);
        });
    }

    private function createPropertyConfigureAddressData(array $address, array $propertyData): array
    {
        $propertyData['address_id'] = $address['id'];

        $property = $this->create($propertyData);
        $property['address'] = $address;
        unset($property['address_id']);

        return $property;
    }
}
