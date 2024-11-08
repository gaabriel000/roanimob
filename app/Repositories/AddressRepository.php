<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    public function create(array $data)
    {
        return Address::create($data);
    }

    public function update(array $data)
    {
        $address = Address::findOr($data['id'], function() {
            return null;
        });

        $address->update($data);
        return $address;
    }

    public function delete($id)
    {
        $address = Address::findOr($id, function() {
            return null;
        });

        $address->delete();
    }

    public function findByAttributes(array $attributes)
    {
        $query = Address::query();

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get()->toArray();
    }
}
