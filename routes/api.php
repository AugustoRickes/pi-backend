<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// http://localhost:8000/api

Route::post('/login', [UserController::class, 'loginUser']);
Route::post('/register', [UserController::class, 'createUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});