<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            "sku" => Str::upper(Str::random(4)),
            "imageUrl" => $this->faker->imageUrl(150, 150, gray: true),
            "amount" => $this->faker->numberBetween(1, 10000),
        ];
    }
}
