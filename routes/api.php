<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;
use App\Http\Controllers\API\CategoryController;

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::get('me',[AuthController::class,'me']);

Route::middleware('auth')->group(function(){
    Route::apiResource('todos',TodoController::class);
    Route::patch('todos/{todo}/toggle',[TodoController::class,'toggle']);
    Route::get('todos/stats',[TodoController::class,'stats']);
    Route::get('categories',[CategoryController::class,'index']);
});
