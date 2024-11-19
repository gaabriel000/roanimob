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
            return $this->createPersonConfigureAddressData($address, $personData);
        });
    }

    public function createAndUpdateAddress(array $personData, array $addressData, string $id): array
    {
        return DB::transaction(function () use ($personData, $addressData, $id) {
            $address = $this->addressRepository->update($id, $addressData);
            return $this->createPersonConfigureAddressData($address, $personData);
        });
    }

    private function createPersonConfigureAddressData(array $address, array $personData): array
    {
        $personData['address_id'] = $address['id'];

        $person = $this->create($personData);
        $person['address'] = $address;
        unset($person['address_id']);

        return $person;
    }
}
