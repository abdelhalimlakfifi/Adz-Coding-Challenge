<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\CategoryRepository;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $categoryRepo;
    protected $signature = 'category:create {name} {--parent=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new category';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $categoryRepo)
    {
        parent::__construct();
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    
    public function handle()
    {
        $name = $this->argument('name');
        $parentId = $this->option('parent');

        $categoryData = [
            'name' => $name,
            'parent_id' => $parentId
        ];

        $category = $this->categoryRepo->create($categoryData);
        
        if (!is_object($category)) {
            $this->error('Failed to create category');
            return 1;
        }

        $this->info("Category '{$category->name}' created successfully.");
        return 0;
    }
}
