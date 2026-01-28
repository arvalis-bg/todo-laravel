<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TodoController as ApiTodoController;
use App\Models\Todo;
use App\Models\Category;
use App\Models\Priority;

class TodoWebController extends Controller
{
    public function index(Request $request): View
    {
        $todos = app(ApiTodoController::class)->index()->getData(true);

        return view('todos.index', compact('todos'));
    }

    public function create(): View
    {
        $categories = Category::all(); // fetch all categories
        $priorities = Priority::orderBy('value')->get(); // fetch all priorities by value
        
        return view('todos.create', compact('categories', 'priorities'));
    }

    public function store(Request $request): RedirectResponse
    {
        app(ApiTodoController::class)->store($request);

        return redirect()->route('todos.index');
    }

    public function edit(int $id): View
    {
        $todo = Todo::findOrFail($id);
        $categories = Category::all();
        $priorities = Priority::orderBy('value')->get();

        return view('todos.edit', compact('todo', 'categories', 'priorities'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $todo = Todo::findOrFail($id);

        app(ApiTodoController::class)->update($request, $todo);

        return redirect()->route('todos.index');
    }

    public function toggle(int $id): RedirectResponse
    {
        $todo = Todo::findOrFail($id);

        app(ApiTodoController::class)->toggle($todo);

        return back();
    }

    public function stats(): View
    {
        $stats = app(ApiTodoController::class)->stats()->getData(true);

        return view('todos.stats', compact('stats'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $todo = Todo::findOrFail($id);

        app(ApiTodoController::class)->destroy($todo);

        return back();
    }
}
