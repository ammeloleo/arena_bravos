<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $bebidas = Category::firstOrCreate(['name' => 'Bebidas']);
        $alimentos = Category::firstOrCreate(['name' => 'Alimentos']);

        Product::firstOrCreate(['name' => 'Água mineral'], ['category_id' => $bebidas->id, 'price' => 5, 'is_active' => true]);
        Product::firstOrCreate(['name' => 'Refrigerante lata'], ['category_id' => $bebidas->id, 'price' => 6, 'is_active' => true]);
        Product::firstOrCreate(['name' => 'Porção de batata'], ['category_id' => $alimentos->id, 'price' => 18, 'is_active' => true]);
    }
}
