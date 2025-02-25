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
            'category_id' => $category->id,
            'description' => 'A brand new product.',
        ];

        // Simulate a POST request
        $response = $this->postJson('/api/v1/products', $data);

        // Assert that the response is successful
        $response->assertStatus(201);

        // Assert the product is stored in the database
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'price' => 29.99,
            'category_id' => $category->id,  // Check for category_id instead of category
            'description' => 'A brand new product.',
        ]);
    }

    
}
