<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return ['category_id' => Category::factory(), 'name' => fake()->words(2, true), 'price' => fake()->randomFloat(2, 1, 100), 'is_active' => true];
    }
}
