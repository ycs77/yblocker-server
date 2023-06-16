<?php

use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\Users\HostnameControoller;
use App\Http\Controllers\Users\TokenControoller;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::redirect('/', 'users');

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    Route::post('/users/{user}/hostname', [HostnameControoller::class, 'index']);

    Route::post('/users/{user}/tokens', [TokenControoller::class, 'create']);
    Route::delete('/users/{user}/tokens/{id}', [TokenControoller::class, 'destroy']);

    Route::get('/blacklist', [BlacklistController::class, 'index']);
    Route::post('/blacklist', [BlacklistController::class, 'store']);
});

Auth::routes([
    'register' => false,
    'reset' => false,
]);
