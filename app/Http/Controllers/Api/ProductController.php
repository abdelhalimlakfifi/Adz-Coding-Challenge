<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productRepository;
    protected $productService;

    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function getAll(Request $request)
    {
        $query = $this->productRepository->query();

        // Filter by category if provided
        if ($request->has('category')) {
            $query = $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'categories' => 'required|array'
        ]);

        $product = $this->productService->createProduct($validated);
        
        return response()->json($product, 201);
    }
}
