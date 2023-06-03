<?php

use App\Http\Controllers\TokenControoller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'users');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

Route::post('/users/{user}/tokens', [TokenControoller::class, 'create']);
Route::delete('/users/{user}/tokens/{id}', [TokenControoller::class, 'destroy']);
