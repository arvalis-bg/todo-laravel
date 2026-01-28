<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TodoController as ApiTodoController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TodoWebController extends Controller
{
    public function index(Request $request): View
    {
        $apiController = app(ApiTodoController::class);
        $todos = $apiController->index($request)->getData(true);

        return view('todos.index', ['todos' => $todos]);
    }

    public function create(): View
    {
        return view('todos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['title', 'category_id', 'priority']);

        $apiController = app(ApiTodoController::class);
        $apiController->store($request->merge($data));

        return redirect()->route('todos.index');
    }

    public function edit(Request $request, int $id): View
    {
        $apiController = app(ApiTodoController::class);
        $todo = $apiController->show($id)->getData(true);

        return view('todos.edit', ['todo' => $todo]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->only(['title', 'category_id', 'priority', 'completed']);

        $apiController = app(ApiTodoController::class);
        $apiController->update($request->merge($data), $id);

        return redirect()->route('todos.index');
    }

    public function toggle(Request $request, int $id): RedirectResponse
    {
        $apiController = app(ApiTodoController::class);
        $apiController->toggle($id);

        return redirect()->back();
    }

    public function stats(Request $request): View
    {
        $apiController = app(ApiTodoController::class);
        $stats = $apiController->stats($request)->getData(true);

        return view('todos.stats', ['stats' => $stats]);
    }
}
