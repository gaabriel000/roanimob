<?php

namespace App\Repositories;

use App\Models\Property;

class PropertyRepository extends BaseRepository
{
    public function __construct(Property $model)
    {
        parent::__construct($model);
    }

    // Métodos específicos para o repositório de propriedades, se necessário
}
