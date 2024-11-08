<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

const PERSON = '/person';

Route::prefix('v1')->group(function () {
    Route::get(PERSON, [PersonController::class, 'query']);
    Route::post(PERSON, [PersonController::class, 'create']);
    Route::patch(PERSON, [PersonController::class, 'update']);
    Route::delete(PERSON, [PersonController::class, 'delete']);
});
