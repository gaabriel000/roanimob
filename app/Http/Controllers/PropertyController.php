<?php

namespace App\Http\Controllers;

use App\Services\PropertyService;

class PropertyController extends BaseController
{
    public function __construct(PropertyService $propertyService)
    {
        parent::__construct($propertyService);
    }

    public function contract (string $id)
    {
        $response = $this->service->contract($id);

        $this->convertKeysToSnakeCase($response['data']);
        return response()->json($response['data'], $response['code']);
    }
}
