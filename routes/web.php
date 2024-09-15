<?php

use App\Http\Controllers\ProductDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ping', function () {
    return ["response" => "pong"];
});

Route::get('/products', [ProductDataController::class,'fetchProductData']);
