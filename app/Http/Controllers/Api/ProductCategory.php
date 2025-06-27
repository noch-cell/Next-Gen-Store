<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class ProductCategory extends Controller
{
    public function index()
    {
        $categories = \App\Models\ProductCategory::all();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $category = \App\Models\ProductCategory::with('')->find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json([
            'category' => $category,
            'products' => $category->products,
        ]);
    }
}
