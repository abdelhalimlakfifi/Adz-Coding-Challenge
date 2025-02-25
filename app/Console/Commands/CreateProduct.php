<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ProductRepository;
class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product';
    protected $productRepo;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $productRepo)
    {
        parent::__construct();
        $this->productRepo = $productRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter the product name');
        if (empty($name)) {
            $this->error('Product name is required');
            return 1;
        }

        $description = $this->ask('Enter the product description');
        
        $price = $this->ask('Enter the product price');
        if (empty($price) || !is_numeric($price) || $price < 0) {
            $this->error('Product price is required and must be a positive number');
            return 1;
        }

        $categories = $this->ask('Enter the product categories (comma-separated)');
        if (empty($categories)) {
            $this->error('Product categories are required');
            return 1;
        }
        
        $categories = explode(',', $categories);
        $categories = array_map('trim', $categories);
        
        if (empty($categories)) {
            $this->error('At least one category is required');
            return 1;
        }

        $product = $this->productRepo->create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'categories' => $categories
        ]);

        $this->info('Product created successfully');
        $this->table(['ID', 'Name', 'Description', 'Price', 'Categories'], [$product->toArray()]);
        return 0;
    }
}
