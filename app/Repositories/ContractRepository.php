<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Utils\Converter;

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
}
