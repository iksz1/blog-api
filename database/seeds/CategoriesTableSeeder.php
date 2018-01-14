<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Category::class, 6)->create();
        Category::create(['alias' => 'scifi', 'name' => 'Science Fiction']);
        Category::create(['alias' => 'webdev', 'name' => 'Web Development']);
        Category::create(['alias' => 'sports', 'name' => 'Sports']);
        Category::create(['alias' => 'cooking', 'name' => 'Cooking']);
        Category::create(['alias' => 'economy', 'name' => 'Economy']);
        Category::create(['alias' => 'travel', 'name' => 'Travel']);        
    }
}
