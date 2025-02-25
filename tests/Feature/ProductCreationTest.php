<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        // Create a category first
        $category = Category::factory()->create();

        // Define the product data
        $data = [
            'name' => 'New Product',
            'price' => 29.99,
            'description' => 'A brand new product.',
            'categories' => [$category->id]  // Send category ID as array
        ];

        // Simulate a POST request
        $response = $this->postJson('/api/v1/products', $data);

        // Assert that the response is successful
        $response->assertStatus(201);

        // Assert the product is stored in the database
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'price' => 29.99,
            'description' => 'A brand new product.'
        ]);

        // Assert the category relationship is created
        $product = Product::where('name', 'New Product')->first();
        $this->assertTrue($product->categories->contains($category->id));
    }

    /** @test */
    public function user_can_create_multiple_products_sequentially()
    {
        // Create some categories that might be used
        $electronics = Category::factory()->create(['name' => 'Electronics']);
        $accessories = Category::factory()->create(['name' => 'Accessories']);

        // First product creation - A smartphone
        $phoneData = [
            'name' => 'Smartphone X1',
            'price' => 599.99,
            'description' => 'Latest smartphone with amazing camera.',
            'categories' => [$electronics->id]
        ];

        $response = $this->postJson('/api/v1/products', $phoneData);
        $response->assertStatus(201);

        // Second product creation - A phone case
        $caseData = [
            'name' => 'Protective Case X1',
            'price' => 24.99,
            'description' => 'Compatible with Smartphone X1, provides ultimate protection.',
            'categories' => [$accessories->id, $electronics->id]  // It's both an accessory and electronic
        ];

        $response = $this->postJson('/api/v1/products', $caseData);
        $response->assertStatus(201);

        // Third product creation - A charger
        $chargerData = [
            'name' => 'Fast Charger',
            'price' => 29.99,
            'description' => 'Quick charging compatible with Smartphone X1.',
            'categories' => [$accessories->id, $electronics->id]
        ];

        $response = $this->postJson('/api/v1/products', $chargerData);
        $response->assertStatus(201);

        // Verify all products are in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Smartphone X1',
            'price' => 599.99
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Protective Case X1',
            'price' => 24.99
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Fast Charger',
            'price' => 29.99
        ]);

        // Verify category relationships
        $phone = Product::where('name', 'Smartphone X1')->first();
        $this->assertTrue($phone->categories->contains($electronics->id));

        $case = Product::where('name', 'Protective Case X1')->first();
        $this->assertTrue($case->categories->contains($accessories->id));
        $this->assertTrue($case->categories->contains($electronics->id));

        $charger = Product::where('name', 'Fast Charger')->first();
        $this->assertTrue($charger->categories->contains($accessories->id));
        $this->assertTrue($charger->categories->contains($electronics->id));
    }
}
