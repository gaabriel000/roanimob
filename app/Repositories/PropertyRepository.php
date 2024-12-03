<?php

namespace App\Repositories;

use App\Models\Property;
use App\Repositories\AddressRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class PropertyRepository extends BaseRepository
{
    private AddressRepository $addressRepository;
    private ContractRepository $contractRepository;

    public function __construct(Property $model, AddressRepository $addressRepository, ContractRepository $contractRepository)
    {
        parent::__construct($model);
        $this->addressRepository = $addressRepository;
        $this->contractRepository = $contractRepository;
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

    public function UpdateAndUpdateAddress(array $propertyData, array $addressData, string $propertyId, string $addressId): array
    {
        return DB::transaction(function () use ($propertyData, $addressData, $propertyId, $addressId) {
            $address = $this->addressRepository->update($addressId, $addressData);
            return $this->createPropertyConfigureAddressData($address, $propertyData, $propertyId, true);
        });
    }

    public function findActiveContract(string $id)
    {
        $contract = $this->contractRepository->findByAttributes(['property_id' => $id]);
        return $contract['data'] ? $contract['data'] : null;
    }

    private function createPropertyConfigureAddressData(array $address, array $propertyData, $id = null, bool $update = false): array
    {
        $propertyData['address_id'] = $address['id'];

        if ($update) {
            $property = $this->update($id, $propertyData);
        } else {
            $property = $this->create($propertyData);
        }

        $property['address'] = $address;
        unset($property['address_id']);

        return $property;
    }
}
