<?php

namespace App\Http\Controllers;

use App\Utils\Converter;
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
        $data = Converter::convertKeysToSnakeCase($request->all());
        $response = $this->service->create($data);

        $this->convertKeysToSnakeCase($response['data']);
        return response()->json($response['data'], $response['code']);
    }

    public function delete(string $id)
    {
        $response = $this->service->delete($id);
        return response()->json($response['data'], $response['code']);
    }

    public function update(string $id, Request $request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $response = $this->service->update($id, $data);

        $this->convertKeysToSnakeCase($response['data']);
        return response()->json($response['data'], $response['code']);
    }

    public function query(Request $request)
    {
        $data = Converter::convertKeysToSnakeCase($request->all());
        $response = $this->service->query($data);

        $this->convertKeysToSnakeCase($response['data']);
        return response()->json($response['data'], $response['code']);
    }

    private function convertKeysToSnakeCase(&$data)
    {
        if (is_array($data)) {
            $data = Converter::convertKeysToCamelCase($data);
        }
    }
}
