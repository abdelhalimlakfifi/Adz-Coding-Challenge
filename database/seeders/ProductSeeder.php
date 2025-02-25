<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create main categories
        $electronics = Category::create(['name' => 'Electronics']);
        $accessories = Category::create(['name' => 'Accessories']);
        $clothing = Category::create(['name' => 'Clothing']);

        // Create sub-categories
        $smartphones = Category::create([
            'name' => 'Smartphones',
            'parent_id' => $electronics->id
        ]);
        
        $laptops = Category::create([
            'name' => 'Laptops',
            'parent_id' => $electronics->id
        ]);

        // Create products with their categories
        // Smartphones and accessories
        $iphone = Product::create([
            'name' => 'iPhone 15 Pro',
            'description' => 'Latest iPhone with A17 Pro chip and amazing camera system',
            'price' => 999.99,
            // 'image_path' => 'products/iphone15pro.jpg'
        ]);
        $iphone->categories()->attach([$smartphones->id, $electronics->id]);

        $iphoneCase = Product::create([
            'name' => 'iPhone 15 Pro Leather Case',
            'description' => 'Premium leather case with MagSafe',
            'price' => 49.99,
            // 'image_path' => 'products/iphone_case.jpg'
        ]);
        $iphoneCase->categories()->attach([$accessories->id]);

        // Laptops and accessories
        $macbook = Product::create([
            'name' => 'MacBook Pro 16"',
            'description' => 'Powerful laptop for professionals with M2 Max chip',
            'price' => 2499.99,
            // 'image_path' => 'products/macbook_pro.jpg'
        ]);
        $macbook->categories()->attach([$laptops->id, $electronics->id]);

        $laptopBag = Product::create([
            'name' => 'Premium Laptop Bag',
            'description' => 'Waterproof laptop bag fits up to 16" laptops',
            'price' => 79.99,
            // 'image_path' => 'products/laptop_bag.jpg'
        ]);
        $laptopBag->categories()->attach([$accessories->id, $clothing->id]);

        // Clothing items
        $tshirt = Product::create([
            'name' => 'Classic Cotton T-Shirt',
            'description' => '100% organic cotton, comfortable fit',
            'price' => 24.99,
            // 'image_path' => 'products/tshirt.jpg'
        ]);
        $tshirt->categories()->attach([$clothing->id]);

        // Electronics accessories
        $charger = Product::create([
            'name' => 'USB-C Fast Charger',
            'description' => '65W GaN charger compatible with all USB-C devices',
            'price' => 39.99,
            // 'image_path' => 'products/charger.jpg'
        ]);
        $charger->categories()->attach([$accessories->id, $electronics->id]);
    }
} 