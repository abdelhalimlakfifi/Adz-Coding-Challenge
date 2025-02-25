<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
class CategoryRepository
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function all(): Collection
    {
        return Category::with('parent')->get();
    }

    public function findById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
