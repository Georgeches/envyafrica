<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItem::truncate();
        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            $numberOfItems = rand(1, 5);
            $selectedProducts = $products->shuffle()->take($numberOfItems);

            foreach ($selectedProducts as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => rand(1, 3),
                ]);
            }
        }
    }
}
