<?php

namespace App\Http\Controllers;

use App\Services\ContractService;
use Illuminate\Http\Request;

class ContractController extends BaseController
{
    public function __construct(ContractService $contractService)
    {
        parent::__construct($contractService);
    }

    public function renew (string $id)
    {
        return $this->service->renew($id);
    }
}

