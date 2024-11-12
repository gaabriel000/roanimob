<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

const ID = '/{id}';
const PERSON = '/person';
const ADDRESS = '/address';

Route::prefix('v1')->group(function () {
    Route::post(PERSON, [PersonController::class, 'create']);
    Route::delete(PERSON . ID, [PersonController::class, 'delete']);
    Route::get(PERSON, [PersonController::class, 'query']);
    Route::patch(PERSON . ID, [PersonController::class, 'update']);

    Route::post(ADDRESS, [AddressController::class, 'create']);
    Route::delete(ADDRESS . ID, [AddressController::class, 'delete']);
    Route::get(ADDRESS, [AddressController::class, 'query']);
    Route::patch(ADDRESS . ID, [AddressController::class, 'update']);
});
