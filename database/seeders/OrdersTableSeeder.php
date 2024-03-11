<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            for ($i = 1; $i <= 5; $i++) {
                Order::create([
                    'customer_id' => $customer->id,
                    'status' => 'pending',
                    'amount' => rand(100, 1000),
                    'notes' => 'Order notes for customer ' . $customer->id,
                    'shipping_price' => 9.99,
                    'number' => 'ORD-' . strtoupper(substr(uniqid(), -8)),
                ]);
            }
        }
    }
}
