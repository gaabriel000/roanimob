<?php

namespace App\Http\Controllers;

use App\Services\AddressService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function create(Request $request)
    {
        return $this->addressService->create($request);
    }

    public function delete(Request $request)
    {
        return $this->addressService->delete($request);
    }

    public function update(Request $request)
    {
        return $this->addressService->update($request);
    }

    public function query(Request $request)
    {
        return $this->addressService->query($request);
    }
}
