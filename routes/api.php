<?php

use App\Http\Controllers\SendController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/send', SendController::class);
});
