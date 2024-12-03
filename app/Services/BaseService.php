<?php

namespace App\Services;

abstract class BaseService
{
    public function response($data, $code)
    {
        return ['data' => $data, 'code' => $code];
    }
}
