<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

const PERSON = '/person';
const ADDRESS = '/address';

Route::prefix('v1')->group(function () {
    Route::post(PERSON, [PersonController::class, 'create']);
    Route::delete(PERSON, [PersonController::class, 'delete']);
    Route::get(PERSON, [PersonController::class, 'query']);
    Route::patch(PERSON, [PersonController::class, 'update']);

    Route::post(ADDRESS, [AddressController::class, 'create']);
    Route::delete(ADDRESS, [AddressController::class, 'delete']);
    Route::get(ADDRESS, [AddressController::class, 'query']);
    Route::patch(ADDRESS, [AddressController::class, 'update']);
});
