<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(Request $request)
    {
        $query = $this->productRepository->query();

        // Filter by category if provided
        if ($request->has('category')) {
            $query = $query->where('category_id', $request->category);
        }

        // Sort by price if provided (asc or desc)
        if ($request->has('sort_price')) {
            $direction = strtolower($request->sort_price) === 'desc' ? 'desc' : 'asc';
            $query = $query->orderBy('price', $direction);
        }

        $products = $query->get();
        return response()->json($products);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            $path = $image->store('products', 'public');
            $data['image_path'] = $path;
        }
        
        $product = $this->productRepository->create($data);
        return response()->json($product);
    }
}
