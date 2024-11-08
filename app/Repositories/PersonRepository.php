<?php

namespace App\Repositories;

use App\Models\Person;

class PersonRepository
{
    public function create(array $data)
    {
        return Person::create($data);
    }

    public function update(array $data)
    {
        $person = Person::findOr($data['id'], function () {
            return null;
        });

        $person->update($data);
        return $person;
    }

    public function delete($id)
    {
        $person = Person::findOr($id, function () {
            return null;
        });

        $person->delete();
    }

    public function findByAttributes(array $attributes)
    {
        $query = Person::query();

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get()->toArray();
    }
}
