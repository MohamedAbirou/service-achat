<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        return [
            'title' => $this->faker->sentence,
            'user_id' => $user->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'budget' => $this->faker->numberBetween(100, 10000),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['pending', 'approved', 'declined']),
            'department' => $user->department,
        ];
    }
}
