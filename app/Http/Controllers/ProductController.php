<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index()
    {
        $query = Products::query();

        return $this->renderProducts($query);
    }

    public function byCategory(Categories $category)
    {
        $categories = Categories::getAllChildrenByParent($category);

        $query = Products::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories));

        return $this->renderProducts($query);
    }

    public function view(Products $product)
    {
        return view('product.view', ['product' => $product]);
    }

    private function renderProducts(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $products = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                /** @var $query \Illuminate\Database\Eloquent\Builder */
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })
            ->paginate(5);

        return view('product.index', [
            'products' => $products
        ]);
    }

    public function showProductWithCategories($id)
    {
        $product = Products::with('categories')->find($id);
        if (!$product) {
            abort(404);
        }

        return view('product.show', [
            'product' => $product
        ]);
    }
}
