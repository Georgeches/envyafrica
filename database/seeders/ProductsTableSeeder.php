<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                Product::create([
                    'name' => 'Product ' . $i,
                    'price' => rand(10, 100),
                    'description' => 'Description for Product ' . $i,
                    'image' => 'image-url-for-product-' . $i . '.jpg',
                    'category_id' => $category->id,
                    'brand' => 'Brand Name',
                    'model' => 'Model Name',
                    'quantity' => rand(1, 100),
                ]);
            }
        }
    }
}
