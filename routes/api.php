<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProductDataController;
use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// http://localhost:8000/api

Route::post('/login', [UserController::class, 'loginUser']);
Route::post('/register', [UserController::class, 'createUser']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/receive-url', [UrlController::class, 'receiveUrl']);
Route::middleware('auth:sanctum')->post('/process-url', [ProductDataController::class, 'processProductData']);

Route::middleware('auth:sanctum')->get('/user/details', [UserController::class, 'getUserDetails']);