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
    Route::get('/', fn () => redirect('/todos'));

    Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');
    Route::get('/todos', [TodoWebController::class, 'index'])->name('todos.index');
    Route::get('/todos/create', [TodoWebController::class, 'create'])->name('todos.create');
    Route::post('/todos', [TodoWebController::class, 'store'])->name('todos.store');
    Route::get('/todos/{id}/edit', [TodoWebController::class, 'edit'])->name('todos.edit');
    Route::put('/todos/{id}', [TodoWebController::class, 'update'])->name('todos.update');
    Route::patch('/todos/{id}/toggle', [TodoWebController::class, 'toggle'])->name('todos.toggle');
    Route::delete('/todos/{id}', [TodoWebController::class, 'destroy'])->name('todos.destroy');
    Route::get('/todos/stats', [TodoWebController::class, 'stats'])->name('todos.stats');
});
