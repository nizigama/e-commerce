<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "productID" => Product::factory()->create(),
            "qty" => $this->faker->numberBetween(1, 10),
            "userID" => User::InRandomOrder()->first() ?? User::factory()->create()
        ];
    }
}
