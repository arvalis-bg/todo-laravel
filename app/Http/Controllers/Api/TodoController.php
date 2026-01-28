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
        $todos = Todo::with(['category', 'priority'])
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return response()->json($todos);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
        ]);

        // Default category fallback
        if (empty($validated['category_id'])) {
            $validated['category_id'] = Category::where('name', 'Other')->value('id');
        }

        // Default priority fallback
        if (empty($validated['priority_id'])) {
            $validated['priority_id'] = Priority::where('name', 'Medium')->value('id');
        }

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
        $validated = $request->validate([
            'title'=>'sometimes|required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'completed'=>'nullable|boolean'
        ]);

        $todo->update($validated);

        return response()->json($todo);
    }

    public function toggle(Todo $todo): JsonResponse
    {
        $todo->completed = ! $todo->completed;
        $todo->save();

        return response()->json($todo);
    }
    
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
    }

    public function stats(): JsonResponse
    {
        $stats = Todo::with('category')
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy(fn ($todo) => $todo->category->name ?? 'Uncategorized')
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
