<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    // Create a Product
    public function create(array $data)
    {
        $product = Product::create($data);
        return $product;
    }
    
    // Get all Products
    public function all()
    {
        return Product::with('categories')->get();
    }

    // Find a Product by ID
    public function findById($id)
    {
        return Product::findOrFail($id);
    }
    
    // Update a Product
    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }
    
    // Delete a Product
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    // Get all Products with filters
    public function getAllWithFilters(array $filters = [])
    {
        $query = Product::with('categories');
        
        // Apply filters if provided
        if (isset($filters['category'])) {
            $query->whereHas('categories', function($q) use ($filters) {
                $q->where('categories.id', $filters['category']);
            });
        }
        
        if (isset($filters['sort_price'])) {
            $query->orderBy('price', $filters['sort_price']);
        }

        return $query->get();
    }

    public function query()
    {
        return Product::with('categories')->newQuery();
    }
}