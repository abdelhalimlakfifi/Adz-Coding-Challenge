<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAll(Request $request)
    {
        $filters = $request->all();
        $products = $this->productService->getAllWithFilters($filters);
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
        $product->categories()->attach($validated['categories']);
        return response()->json($product, 201);
    }
}
