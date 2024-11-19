<?php

namespace App\Repositories;

use App\Utils\Converter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data): array
    {
        $item = $this->model->create($data);
        return Converter::sortResponseId(Converter::objectToArray($item));
    }

    public function update($id, array $data)
    {
        $item = $this->model->find($id);

        if (isset($item)) {
            $item->update($data);
            return Converter::objectToArray($item);
        }

        return null;
    }

    public function delete($id): bool
    {
        $item = $this->model->find($id);

        if (isset($item)) {
            $item->delete();
            return true;
        }

        return false;
    }

    public function findByAttributes(array $attributes, array $relations = [], int $perPage = 10, int $page = 1): array
    {
        $query = $this->model->query();

        $attributes = array_intersect_key(
            $attributes,
            array_flip($this->model->getFillable())
        );

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        $result = $query->paginate($perPage, ['*'], 'page', $page);

        $data = $result->items();
        foreach ($data as &$item) {
            foreach ($relations as $relation) {
                $foreignKey = $relation . '_id';
                if (isset($item[$foreignKey])) {
                    unset($item[$foreignKey]);
                }
            }
        }

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
