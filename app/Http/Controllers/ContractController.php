<?php

namespace App\Http\Controllers;

use App\Services\ContractService;
use Illuminate\Http\Request;
use App\Utils\Converter;

class ContractController extends BaseController
{
    public function __construct(ContractService $contractService)
    {
        parent::__construct($contractService);
    }

    public function renew (string $id, Request $request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        return $this->service->renew($id, $data);
    }
}

