<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/order', [OrderController::class, 'store']);
Route::get('/order/{id}', [OrderController::class, 'getOrder']);
Route::delete('/order/{id}', [OrderController::class, 'cansel']);
Route::get('/orders', [OrderController::class, 'index']);

