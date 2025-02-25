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
        $description = $this->ask('Enter the product description');
        $price = $this->ask('Enter the product price');
        $categories = $this->ask('Enter the product categories (comma-separated)');
        $categories = explode(',', $categories);
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
