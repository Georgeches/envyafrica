<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'firstname' => 'John',
                'secondname' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '123456789',
                'address' => '123 Main Street',
                'city' => 'Anytown',
            ],
            [
                'firstname' => 'Jane',
                'secondname' => 'Smith',
                'email' => 'jane@example.com',
                'phone' => '987654321',
                'address' => '456 Elm Street',
                'city' => 'Othertown',
            ],
            [
                'firstname' => 'Alice',
                'secondname' => 'Johnson',
                'email' => 'alice@example.com',
                'phone' => '5551234',
                'address' => '789 Oak Avenue',
                'city' => 'Somewhere',
            ],
            [
                'firstname' => 'Bob',
                'secondname' => 'Brown',
                'email' => 'bob@example.com',
                'phone' => '5554321',
                'address' => '321 Pine Street',
                'city' => 'Nowhere',
            ],
            [
                'firstname' => 'Eve',
                'secondname' => 'White',
                'email' => 'eve@example.com',
                'phone' => '5557890',
                'address' => '567 Maple Road',
                'city' => 'Elsewhere',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
