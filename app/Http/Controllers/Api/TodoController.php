<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\Category;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        // get all todos for the current user
        $todos = Todo::with(['category', 'priority'])
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return response()->json($todos);
    }

    public function store(Request $request): JsonResponse
    {
        // validate data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
        ]);

        // default category fallback
        if (empty($validated['category_id'])) {
            $validated['category_id'] = Category::where('name', 'Other')->value('id');
        }

        // default priority fallback
        if (empty($validated['priority_id'])) {
            $validated['priority_id'] = Priority::where('name', 'Medium')->value('id');
        }

        // add new todo
        $todo = Todo::create([
            'title'       => $validated['title'],
            'category_id' => $validated['category_id'],
            'priority_id'    => $validated['priority_id'],
            'user_id'     => auth()->id(),
            'completed'   => false,
        ]);

        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo): JsonResponse
    {
        // validate data
        $validated = $request->validate([
            'title'=>'sometimes|required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'completed'=>'nullable|boolean'
        ]);

        // update todo
        $todo->update($validated);

        return response()->json($todo);
    }

    public function toggle(Todo $todo): JsonResponse
    {
        // set complete/incomplete
        $todo->completed = ! $todo->completed;
        $todo->save();

        return response()->json($todo);
    }
    
    public function destroy(Todo $todo): JsonResponse
    {
        // delete todo
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
    }

    public function stats(): JsonResponse
    {
        // show stats by category
        $stats = Todo::with('category')
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy(fn ($todo) => $todo->category->name ?? 'Other')
            ->map(function ($items, $category) {
                return [
                    'category' => $category,
                    'total' => $items->count(),
                    'completed' => $items->where('completed', true)->count(),
                    'incomplete' => $items->where('completed', false)->count(),
                ];
            })
            ->values();

        return response()->json($stats);
    }
}
