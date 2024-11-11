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

    public function update($id, $request)
    {
        $person = Person::find($id);

        if (isset($person)) {
            $person->update($request);
            return Converter::objectToArray($person);
        }

        return null;
    }

    public function delete($id): bool
    {
        $person = Person::find($id);

        if (isset($person)) {
            $person->delete();
            return true;
        }

        return false;
    }

    public function findByAttributes(array $attributes, bool $include_address = false, int $perPage = 10, int $page = 1): array
    {
        $query = Person::query();

        $attributes = array_intersect_key(
            $attributes,
            array_flip((new Person())->getFillable())
        );

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        if ($include_address === true) {
            $query->with('address');
        }

        $result = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $result->items(),
            'per_page' => $result->perPage(),
            'count' => $result->count(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'last_page' => $result->lastPage(),
        ];
    }
}
