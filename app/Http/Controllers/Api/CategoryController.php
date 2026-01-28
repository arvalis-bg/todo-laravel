<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        // get all categories
        $categories = Category::withCount('todos')->get();
        return response()->json($categories);
    }
}
