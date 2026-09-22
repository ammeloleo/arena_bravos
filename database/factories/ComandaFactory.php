<?php

namespace Database\Factories;

use App\Models\Comanda;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Comanda> */
class ComandaFactory extends Factory
{
    public function definition(): array
    {
        return ['label' => 'Mesa '.fake()->numberBetween(1, 99), 'customer_name' => fake()->name(), 'status' => 'open'];
    }

    public function closed(): static
    {
        return $this->state(['status' => 'closed', 'closed_at' => now()]);
    }
}
