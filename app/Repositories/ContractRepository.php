<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Utils\Converter;
use Illuminate\Support\Facades\DB;

class ContractRepository extends BaseRepository
{
    public function __construct(Contract $model)
    {
        parent::__construct($model);
    }

    public function findById($id)
    {
        $query = $this->model->query();
        return Converter::objectToArray($query->find($id));
    }

    public function renew(array $old_data, array $data)
    {
        return DB::transaction(function () use ($old_data, $data) {
            $this->update($old_data['id'], $old_data);
            return $this->create($data);
        });
    }
}
