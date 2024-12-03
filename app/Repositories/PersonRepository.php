<?php

namespace App\Repositories;

use App\Models\Person;
use App\Repositories\AddressRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class PersonRepository extends BaseRepository
{
    private AddressRepository $addressRepository;

    public function __construct(Person $model, AddressRepository $addressRepository)
    {
        parent::__construct($model);
        $this->addressRepository = $addressRepository;
    }

    public function createWithAddress(array $personData, array $addressData): array
    {
        return DB::transaction(function () use ($personData, $addressData) {
            $address = $this->addressRepository->create($addressData);
            return $this->createOrUpdatePersonConfigureAddressData($address, $personData);
        });
    }

    public function createAndUpdateAddress(array $personData, array $addressData, string $id): array
    {
        return DB::transaction(function () use ($personData, $addressData, $id) {
            $address = $this->addressRepository->update($id, $addressData);
            return $this->createOrUpdatePersonConfigureAddressData($address, $personData);
        });
    }

    public function UpdateAndUpdateAddress(array $personData, array $addressData, string $personId, string $addressId): array
    {
        return DB::transaction(function () use ($personData, $addressData, $personId, $addressId) {
            $address = $this->addressRepository->update($addressId, $addressData);
            return $this->createOrUpdatePersonConfigureAddressData($address, $personData, $personId, true);
        });
    }

    public function UpdateAndCreateAddress(array $personData, array $addressData, string $personId): array
    {
        return DB::transaction(function () use ($personData, $addressData, $personId) {
            $address = $this->addressRepository->create($addressData);
            return $this->createOrUpdatePersonConfigureAddressData($address, $personData, $personId, true);
        });
    }

    private function createOrUpdatePersonConfigureAddressData(array $address, array $personData, $id = null, bool $update = false): array
    {
        $personData['address_id'] = $address['id'];

        if ($update) {
            $person = $this->update($id, $personData);
        } else {
            $person = $this->create($personData);
        }

        $person['address'] = $address;
        unset($person['address_id']);

        return $person;
    }
}
