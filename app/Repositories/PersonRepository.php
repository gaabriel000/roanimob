<?php

namespace App\Repositories;

use App\Models\Person;
use App\Utils\Converter;

class PersonRepository
{
    public function create(array $data): array
    {
        $person = Person::create($data);
        return Converter::sortResponseId(Converter::objectToArray($person));
    }

    public function update(array $data): array
    {
        $person = Person::findOr($data['id'], function () {
            return null;
        });

        $person->update($data);
        return Converter::objectToArray($person);
    }

    public function delete($id): void
    {
        $person = Person::findOr($id, function () {
            return null;
        });

        $person->delete();
    }

    public function findByAttributes(array $attributes): array
    {
        $query = Person::query();

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get()->toArray();
    }
}
