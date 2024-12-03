<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

const ID = '/{id}';
const PERSON = '/person';
const ADDRESS = '/address';
const PROPERTY = '/property';
const CONTRACT = '/contract';

Route::prefix('v1')->group(function () {
    Route::post(PERSON, [PersonController::class, 'create']);
    Route::delete(PERSON . ID, [PersonController::class, 'delete']);
    Route::get(PERSON, [PersonController::class, 'query']);
    Route::patch(PERSON . ID, [PersonController::class, 'update']);

    Route::post(ADDRESS, [AddressController::class, 'create']);
    Route::delete(ADDRESS . ID, [AddressController::class, 'delete']);
    Route::get(ADDRESS, [AddressController::class, 'query']);
    Route::patch(ADDRESS . ID, [AddressController::class, 'update']);

    Route::post(PROPERTY, [PropertyController::class, 'create']);
    Route::delete(PROPERTY . ID, [PropertyController::class, 'delete']);
    Route::get(PROPERTY, [PropertyController::class, 'query']);
    Route::patch(PROPERTY . ID, [PropertyController::class, 'update']);
    Route::get(PROPERTY . ID . CONTRACT, [PropertyController::class, 'contract']);

    Route::post(CONTRACT, [ContractController::class, 'create']);
    Route::post(CONTRACT . ID, [ContractController::class, 'renew']);
    Route::delete(CONTRACT . ID, [ContractController::class, 'delete']);
    Route::get(CONTRACT, [ContractController::class, 'query']);
    Route::patch(CONTRACT . ID, [ContractController::class, 'update']);
});
