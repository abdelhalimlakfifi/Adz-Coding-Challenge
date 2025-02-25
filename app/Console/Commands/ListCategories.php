<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\CategoryRepository;

class ListCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $categoryRepo;
    protected $signature = 'category:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all categories';

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
        $categories = $this->categoryRepo->all();
        $categories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'parent name' => $category->parent ? $category->parent->name : null,
                'parent id' => $category->parent ? $category->parent->id : null,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at
            ];
        });
        $this->table(['ID', 'Name', 'Parent Name', 'Parent ID', 'Created At', 'Updated At'], $categories->toArray());
        return 0;
    }
}
