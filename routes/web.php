<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\TodoWebController;

/* Guest routes */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthWebController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthWebController::class, 'login']);
});

/* Authenticated routes */
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthWebController::class, 'logout'])
        ->name('logout');

    // Default redirect
    Route::get('/', fn () => redirect('/todos'));

    // Todo pages (Web → API)
    Route::get('/todos', [TodoWebController::class, 'index'])
        ->name('todos.index');

    Route::get('/todos/create', [TodoWebController::class, 'create'])
        ->name('todos.create');

    Route::post('/todos', [TodoWebController::class, 'store'])
        ->name('todos.store');

    Route::get('/todos/{todo}/edit', [TodoWebController::class, 'edit'])
        ->name('todos.edit');

    Route::put('/todos/{todo}', [TodoWebController::class, 'update'])
        ->name('todos.update');

    Route::patch('/todos/{todo}/toggle', [TodoWebController::class, 'toggle'])
        ->name('todos.toggle');

    // Todo stats
    Route::get('/todos/stats', [TodoWebController::class, 'stats'])
        ->name('todos.stats');
});
