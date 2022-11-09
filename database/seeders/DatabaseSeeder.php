<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(3)->create();

        Product::factory()->create([
            "name" => "Bread Loaf"
        ]);
        Product::factory()->create([
            "name" => "Banana Bunch"
        ]);
        Product::factory()->create([
            "name" => "Sports Car"
        ]);
        Product::factory()->create([
            "name" => "Penthouse"
        ]);
        Product::factory()->create([
            "name" => "Cooker"
        ]);

        // Cart::factory(12)->create();
    }
}
