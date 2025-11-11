<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::resource('products', \App\Http\Controllers\API\ApiProductsController::class);

Route::resource('contacts', \App\Http\Controllers\API\ApiContactController::class);

Route::resource('news', \App\Http\Controllers\API\ApiNewsController::class);

Route::resource('abouts', \App\Http\Controllers\API\ApiAboutController::class);
