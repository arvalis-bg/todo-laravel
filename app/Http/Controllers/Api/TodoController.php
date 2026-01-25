<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Todo::query()
            ->where('user_id', Auth::id())
            ->with(['category']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('completed')) {
            $query->where('is_completed', filter_var($request->completed, FILTER_VALIDATE_BOOLEAN));
        }

        $todos = $query
            ->orderByDesc('priority')
            ->orderBy('created_at')
            ->get();

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority'    => 'required|integer|min:1|max:3',
        ]);

        $todo = Todo::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        return response()->json($todo, 201);
    }

    /**
     * Display a specified resource.
     */
    public function show(Todo $todo): JsonResponse
    {
        $this->authorize('view', $todo);

        return response()->json(
            $todo->load('category')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo): JsonResponse
    {
        $this->authorize('update', $todo);

        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
            'priority'    => 'sometimes|integer|min:1|max:3',
            'is_completed'=> 'sometimes|boolean',
        ]);

        $todo->update($data);

        return response()->json($todo);
    }

    /**
     * Toggle completion of a specified resource
     */
    public function toggle(Todo $todo): JsonResponse
    {
        $this->authorize('update', $todo);

        $todo->update([
            'is_completed' => ! $todo->is_completed,
        ]);

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $this->authorize('delete', $todo);

        $todo->delete();

        return response()->json(null, 204);
    }
}
