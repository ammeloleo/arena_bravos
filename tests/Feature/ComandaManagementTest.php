<?php

use App\Models\Comanda;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a comanda can be created and receive products', function () {
    $this->post(route('comandas.store'), ['label' => 'Mesa 10'])
        ->assertRedirect();

    $comanda = Comanda::firstOrFail();
    $product = Product::factory()->create(['price' => 12.5]);

    $this->post(route('comandas.items.store', $comanda), ['product_id' => $product->id, 'quantity' => 2])
        ->assertRedirect(route('comandas.show', $comanda));

    $this->assertDatabaseHas('comanda_items', ['comanda_id' => $comanda->id, 'product_id' => $product->id, 'quantity' => 2]);
});

test('a closed comanda cannot receive more products', function () {
    $comanda = Comanda::factory()->closed()->create();
    $product = Product::factory()->create();

    $this->post(route('comandas.items.store', $comanda), ['product_id' => $product->id, 'quantity' => 1])
        ->assertStatus(422);
});
