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
        return Product::get();
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
        $query = Product::query();
        
        if (isset($filters['sort_price'])) {
            $query->orderBy('price', $filters['sort_price']);
        }

        return $query->get();
    }

}