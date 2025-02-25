<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
class CategoryRepository
{
    // Create a Category
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    // Get all Categories
    public function all(): Collection
    {
        return Category::with('parent')->get();
    }

    // Find a Category by ID
    public function findById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    // Update a Category
    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    // Delete a Category
    public function delete(int $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
