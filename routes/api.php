<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\CategoryController;

Route::post('/login',  [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me',      [AuthController::class, 'me'])
    ->middleware('auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todos', TodoController::class);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle']);
});
