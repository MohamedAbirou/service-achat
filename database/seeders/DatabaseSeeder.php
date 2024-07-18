<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        // $categories = [
        //     'Electronics',
        //     'Office Supplies',
        //     'IT Services',
        //     'Marketing Services',
        //     'Employee Comfort',
        //     'Software',
        //     'Training Materials',
        //     'Health & Wellness',
        //     'Travel & Expenses',
        //     'Maintenance & Repairs',
        //     'Professional Development',
        //     'Communication Tools',
        //     'Security',
        //     'Furniture',
        //     'Miscellaneous'
        // ];

        // foreach ($categories as $category) {
        //     Category::create(['name' => $category]);
        // }

        // Product::factory(50)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
