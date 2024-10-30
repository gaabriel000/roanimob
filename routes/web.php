<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/person', [PersonController::class, 'query']);
    Route::post('/person', [PersonController::class, 'create']);
    Route::delete('/person', [PersonController::class, 'delete']);
});
