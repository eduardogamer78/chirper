<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/new_message', [MessageController::class, 'new_message'])
    ->name('new_message');
Route::get('/status', [MessageController::class, 'status'])
    ->name('status');
