<?php

namespace App\Repositories;

use App\Models\Address;
use App\Utils\Converter;

class AddressRepository
{
    public function create(array $data): array
    {
        $address = Address::create($data);
        return Converter::sortResponseId(Converter::objectToArray($address));
    }

    public function update(array $data): array
    {
        $address = Address::findOr($data['id'], function() {
            return null;
        });

        $address->update($data);
        return Converter::objectToArray($address);
    }

    public function delete($id): void
    {
        $address = Address::findOr($id, function() {
            return null;
        });

        $address->delete();
    }

    public function findByAttributes(array $attributes): array
    {
        $query = Address::query();

        $attributes = array_intersect_key(
            $attributes,
            array_flip((new Address())->getFillable())
        );

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        return Converter::objectToArray($query->get());
    }
}
