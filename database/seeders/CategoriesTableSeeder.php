<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Shirts', 'slug' => 'shirts'],
            ['name' => 'Pants', 'slug' => 'pants'],
            ['name' => 'Dresses', 'slug' => 'dresses'],
            ['name' => 'Jackets', 'slug' => 'jackets'],
            ['name' => 'Sweaters', 'slug' => 'sweaters'],
            ['name' => 'Skirts', 'slug' => 'skirts'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
            ['name' => 'Footwear', 'slug' => 'footwear'],
            ['name' => 'Hats', 'slug' => 'hats'],
            ['name' => 'Bags', 'slug' => 'bags'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
