<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Products::query();

        $query->orderBy($sortField, $sortDirection);
        if ($search) {
            $query->where('name', 'like', '%{$search}%')
                ->orWhere('description', 'like', '%{$search}%');
        }

        return ProductListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $categories = $data['categories'] ?? [];

        $product = Products::create($data);
        $this->saveCategories($categories, $product);
//        $this->saveImage($images , $product);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        return new ProductResource($products);
    }

    public function update(ProductsRequest $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $images = $data['images'] ?? [];
        $deletedImages = $data['deleted_images'] ?? [];
        $categories = $data['categories'] ?? [];

        $this->saveCategories($categories, $product);

//        if (count($images) > 0) {
//            $this->saveImage($images, $product);
//        }
//
//        if (count($deletedImages) > 0) {
//            $this->deleteImages($deletedImages, $product);
//        }

        $product->update($data);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(Products $products)
//    {
//        $products->delete();
//        return response()->noContent();
//    }
    public function destroy(Products $products)
    {
        $products->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    private function saveCategories($categoryIds, Products $product)
    {
        \App\Models\ProductCategory::where('products_id', $product->id)->delete();
        $data = array_map(fn($id) => (['categories_id' => $id, 'products_id' => $product->id]), $categoryIds);

        \App\Models\ProductCategory::insert($data);
    }
    /**
     *
     *
     * @param UploadedFile[] $images
     * @return string
     * @throws \Exception
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
//    private function saveImage(UploadedFile $image)
//    {
//        $path = 'images/' . Str::random();
//        if (!Storage::exists($path)) {
//            Storage::makeDirectory($path, 0755, true);
//        }
//        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
//            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
//        }
//
//        return $path . '/' . $image->getClientOriginalName();
//    }

//    private function deleteImages($imageIds, Products $product)
//    {
//        $images = ProductImage::query()
//            ->where('product_id', $product->id)
//            ->whereIn('id', $imageIds)
//            ->get();
//
//        foreach ($images as $image) {
//            // If there is an old image, delete it
//            if ($image->path) {
//                Storage::deleteDirectory('/public/' . dirname($image->path));
//            }
//            $image->delete();
//        }
//    }
}
