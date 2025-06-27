<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTreeResource;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $categories = Categories::query()
            ->orderBy($sortField, $sortDirection)
            ->latest()
            ->get();

        return CategoryResource::collection($categories);
    }

    public function getAsTree()
    {
        return Categories::getActiveAsTree(CategoryTreeResource::class);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
//        $user = $request->user();
//        if (!$user) {
//            return response()->json(['error' => 'Unauthenticated'], 401);
//        }

        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
        $category = Categories::create($data);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Categories $category)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $category->update($data);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
