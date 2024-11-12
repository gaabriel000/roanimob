<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        return $this->service->create($request);
    }

    public function delete(string $id)
    {
        return $this->service->delete($id);
    }

    public function update(string $id, Request $request)
    {
        return $this->service->update($id, $request);
    }

    public function query(Request $request)
    {
        return $this->service->query($request);
    }
}
