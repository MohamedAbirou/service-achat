<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Request;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Liam',
            'last_name' => 'Pyro',
            'email' => 'liam.abirou@gmail.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create 10 managers
        User::factory(10)->create(['role' => User::ROLE_MANAGER]);

        // Create 30 employees
        User::factory(30)->create(['role' => User::ROLE_EMPLOYEE]);

        $categories = [
            'Electronics',
            'Office Supplies',
            'IT Services',
            'Marketing Services',
            'Employee Comfort',
            'Software',
            'Training Materials',
            'Health & Wellness',
            'Travel & Expenses',
            'Maintenance & Repairs',
            'Professional Development',
            'Communication Tools',
            'Security',
            'Furniture',
            'Miscellaneous'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        Product::factory(50)->create();

        // Give existed users who are managers and employees a department
        $departments = ['Marketing', 'Sales', 'Finance', 'Human Resources', 'IT', 'Accounting', 'Support', 'Customer Service', 'Operations', 'Legal'];

        User::where('role', User::ROLE_MANAGER)->each(fn($user) => $user->update(['department' => Arr::random($departments)]));
        User::where('role', User::ROLE_EMPLOYEE)->each(fn($user) => $user->update(['department' => Arr::random($departments)]));

        // Create 5 requests for each user with only in_stock products
        User::whereIn('role', [User::ROLE_EMPLOYEE, User::ROLE_MANAGER])->each(function ($user) {
            $products = Product::where('in_stock', true)->inRandomOrder()->take(5)->get();

            foreach ($products as $product) {
                Request::factory()->create(['user_id' => $user->id, 'department' => $user->department, 'product_id' => $product->id]);
            }
        });


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
