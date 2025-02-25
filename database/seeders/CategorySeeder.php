<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Main categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'parent_id' => null
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'parent_id' => null
        ]);

        $furniture = Category::create([
            'name' => 'Furniture',
            'parent_id' => null
        ]);

        // Electronics subcategories
        Category::create([
            'name' => 'Smartphones',
            'parent_id' => $electronics->id
        ]);

        Category::create([
            'name' => 'Laptops',
            'parent_id' => $electronics->id
        ]);

        Category::create([
            'name' => 'Accessories',
            'parent_id' => $electronics->id
        ]);

        // Clothing subcategories
        Category::create([
            'name' => 'Men',
            'parent_id' => $clothing->id
        ]);

        Category::create([
            'name' => 'Women',
            'parent_id' => $clothing->id
        ]);

        Category::create([
            'name' => 'Kids',
            'parent_id' => $clothing->id
        ]);

        // Furniture subcategories
        Category::create([
            'name' => 'Living Room',
            'parent_id' => $furniture->id
        ]);

        Category::create([
            'name' => 'Bedroom',
            'parent_id' => $furniture->id
        ]);

        Category::create([
            'name' => 'Office',
            'parent_id' => $furniture->id
        ]);
    }
} 