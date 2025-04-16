<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// API Routes for CRUD
Route::apiResource('users', UserController::class);
