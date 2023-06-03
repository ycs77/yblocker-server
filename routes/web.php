<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'clients');

Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{client}', [ClientController::class, 'show']);
