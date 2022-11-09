<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->unique()->name(),
            "sku" => $this->faker->uuid(),
            "imageUrl" => $this->faker->imageUrl(150, 150),
            "amount" => $this->faker->numberBetween(1, 10000),
        ];
    }
}
