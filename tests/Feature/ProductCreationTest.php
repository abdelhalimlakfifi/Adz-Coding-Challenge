<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        // Simulate a file for testing (if applicable)
        // $file = UploadedFile::fake()->image('product_image.jpg');

        // Define the product data
        $data = [
            'name' => 'New Product',
            'price' => 29.99,
            // 'category' => 'Electronics', // Or an array if it's a relationship
            'description' => 'A brand new product.',
        ];

        // Simulate a POST request with form data
        $response = $this->postJson('/api/v1/products', $data, [
            'Content-Type' => 'multipart/form-data'
        ]);

        // Assert that the response is successful
        $response->assertStatus(201);

        // Assert the product is stored in the database
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'price' => 29.99,
            'category' => 'Electronics', // Adjust if it's a relationship
            'description' => 'A brand new product.',
        ]);
    }

    
}
