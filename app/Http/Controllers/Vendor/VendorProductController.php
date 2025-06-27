<?php 

namespace App\Http\Controllers\Vendor;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
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

        return $this->renderProducts($query);}    
        
        private function renderProducts(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        $sortDirection = $sort[0] === '-' ? 'desc' : 'asc';
        $sortField = preg_replace('/^-?/', '', $sort);

        $query->orderBy($sortField, $sortDirection);
        $query->where('published', 2);

        $vendorId = Auth::id();
        $query->where('created_by', $vendorId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.title', 'like', "%$search%")
                  ->orWhere('products.description', 'like', "%$search%");
            });
        }

        $products = $query->paginate(5);

        return response()->json($products);
    }

    public function showProductWithCategories($id)
    {
        $product = Products::with('categories')->find($id);
        if (!$product) {
            abort(404);
        }

        return view('vendor.product.show', [
            'product' => $product
        ]);
    }


}

