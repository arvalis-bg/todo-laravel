<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::query()
            ->where('user_id', $request->user()->id)
            ->withCount('todos')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    /**
     * Custom SQL method
     */
    public function stats(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $stats = DB::table('categories')
            ->leftJoin('todos', function ($join) use ($userId) {
                $join->on('todos.category_id', '=', 'categories.id')
                    ->where('todos.user_id', '=', $userId);
            })
            ->where('categories.user_id', $userId)
            ->groupBy('categories.id', 'categories.name')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('COUNT(todos.id) as total_todos'),
                DB::raw('SUM(CASE WHEN todos.is_completed = 1 THEN 1 ELSE 0 END) as completed_todos'),
                DB::raw('
                    CASE 
                        WHEN COUNT(todos.id) = 0 THEN 0
                        ELSE ROUND(
                            SUM(CASE WHEN todos.is_completed = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(todos.id),
                            2
                        )
                    END as completion_rate
                ')
            )
            ->orderBy('categories.name')
            ->get();

        return response()->json($stats);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
