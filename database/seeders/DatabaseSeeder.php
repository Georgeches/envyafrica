<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'=>'George Chesire',
            'password'=>'$2y$12$uiCzOsQ8yrqH3xc8YTyN8./g55FdjdPqxVgYvwxzrRlWhRMqtIvHS',
            'email'=>'chesire608@gmail.com'
        ]);
    }
}
