<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllWithFilters(array $filters)
    {
        return $this->productRepository->getAllWithFilters($filters);
    }

    public function createProduct(array $data)
    {
        if (isset($data['image'])) {
            $data['image_path'] = $this->handleImageUpload($data['image']);
        }

        return $this->productRepository->create($data);
    }

    private function handleImageUpload($image)
    {
        return $image->store('products', 'public');
    }
} 