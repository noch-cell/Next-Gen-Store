<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class VendorCategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::paginate(5); 
        return response()->json($categories);
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        try {
            $category = Categories::findOrFail($id); 
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json($category);
    }
}
