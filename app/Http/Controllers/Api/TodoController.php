<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        $todos = Todo::with('category')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($todos);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'=>'required|string|max:255',
            'category_id'=>'required|integer|exists:categories,id',
            'priority'=>'nullable|integer|min:1|max:5'
        ]);

        $todo = Todo::create(array_merge($validated,['user_id'=>auth()->id()]));

        return response()->json($todo,201);
    }

    public function show(Todo $todo): JsonResponse
    {
        $this->authorize('view',$todo);
        return response()->json($todo->load('category'));
    }

    public function update(Request $request, Todo $todo): JsonResponse
    {
        $this->authorize('update',$todo);

        $validated = $request->validate([
            'title'=>'sometimes|required|string|max:255',
            'category_id'=>'sometimes|required|integer|exists:categories,id',
            'priority'=>'nullable|integer|min:1|max:5',
            'completed'=>'nullable|boolean'
        ]);

        $todo->update($validated);

        return response()->json($todo->load('category'));
    }

    public function destroy(Todo $todo): JsonResponse
    {
        $this->authorize('delete',$todo);
        $todo->delete();
        return response()->json(['message'=>'Deleted']);
    }

    public function toggle(Todo $todo): JsonResponse
    {
        $this->authorize('update',$todo);
        $todo->completed = !$todo->completed;
        $todo->save();
        return response()->json($todo);
    }

    public function stats(): JsonResponse
    {
        $results = DB::select(
            "SELECT category_id, COUNT(*) AS total
             FROM todos
             WHERE user_id = ?
             GROUP BY category_id",
             [auth()->id()]
        );

        return response()->json($results);
    }
}
