<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

const PERSON = '/person';

Route::get('/token', function (Request $request) {
    return $request->session()->token();
});

Route::prefix('v1')->group(function () {
    Route::get(PERSON, [PersonController::class, 'query']);
    Route::post(PERSON, [PersonController::class, 'create']);
    Route::patch(PERSON, [PersonController::class, 'update']);
    Route::delete(PERSON, [PersonController::class, 'delete']);
});
