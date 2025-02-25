<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    // Create a Category
    public function create(array $data)
    {
        return Category::create($data);
    }

    // Get all Categories
    public function all()
    {
        return Category::with('parent')->get();
    }

    // Find a Category by ID
    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    // Update a Category
    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    // Delete a Category
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
