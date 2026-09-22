<?php

namespace Database\Factories;

use App\Models\Comanda;
use App\Models\ComandaItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ComandaItem> */
class ComandaItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::factory()->create();

        return ['comanda_id' => Comanda::factory(), 'product_id' => $product, 'product_name' => $product->name, 'quantity' => 1, 'unit_price' => $product->price];
    }
}
