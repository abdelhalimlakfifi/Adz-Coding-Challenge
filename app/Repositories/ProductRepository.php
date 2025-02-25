<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
class ProductRepository
{
    public function create(array $data): Product
    {
        $product = Product::create($data);
        return $product;
    }
    
    public function all(): Collection
    {
        return Product::with('categories')->get();
    }

    public function findById(int $id): Product
    {
        return Product::findOrFail($id);
    }
    
    public function update(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }
    
    public function delete(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function getAllWithFilters(array $filters = []): Collection
    {
        $query = Product::with('categories');
        
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