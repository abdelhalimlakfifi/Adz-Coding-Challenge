<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    // Create a Product
    public function create(array $data)
    {
        
        if (isset($data['categories'])) {
            $categories = $data['categories'];
            // dd($categories);
            unset($data['categories']);
        }
        $product = Product::create($data);
        
        if (isset($categories)) {
            $product->categories()->attach($categories);
        }
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

    public function query()
    {
        return Product::with('categories')->newQuery();
    }
}