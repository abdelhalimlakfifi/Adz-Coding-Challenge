<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllWithFilters(array $filters): Collection
    {
        $products = $this->productRepository->getAllWithFilters($filters);
        
        if (isset($filters['category'])) {
            $products = $products->filter(function ($product) use ($filters) {
                return $product->categories->contains('id', $filters['category']);
            });
        }
        // Eager load categories after fetching products
        return $products->load('categories');
    }

    public function createProduct(array $data): Product
    {
        if (isset($data['image'])) {
            $data['image_path'] = $this->handleImageUpload($data['image']);
        }

        return $this->productRepository->create($data);
    }

    private function handleImageUpload(UploadedFile $image): string
    {
        return $image->store('products', 'public');
    }
} 