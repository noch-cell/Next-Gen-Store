<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductCategoryController extends Controller
{
    public function index($productId)
    {
        $product = Products::with('categories')
            ->where('id', $productId)
            ->where('created_by', Auth::id())
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found or not yours'], 404);
        }

        return response()->json($product->categories);
    }
    
    public function store(Request $request, $productId)
    {
        $product = Products::where('id', $productId)
            ->where('created_by', Auth::id())
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found or not yours'], 404);
        }

        $categoryIds = $request->input('category_ids');

        if (!is_array($categoryIds)) {
            return response()->json(['error' => 'category_ids must be an array'], 422);
        }

        $product->categories()->sync($categoryIds); 

        return response()->json(['message' => 'Categories updated']);
    }

    public function destroy($productId, $categoryId)
    {
        $product = Products::where('id', $productId)
            ->where('created_by', Auth::id())
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found or not yours'], 404);
        }

        $product->categories()->detach($categoryId);

        return response()->json(['message' => 'Category removed from product']);
    }
}
