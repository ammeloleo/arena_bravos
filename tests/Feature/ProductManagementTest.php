<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a product can be registered', function () {
    $this->post(route('produtos.store'), ['name' => 'Suco natural', 'price' => 9.5, 'is_active' => true])
        ->assertRedirect(route('produtos.index'));

    $this->assertDatabaseHas('products', ['name' => 'Suco natural', 'price' => 9.5, 'is_active' => true]);
});

test('a product requires a positive price', function () {
    $this->from(route('produtos.index'))->post(route('produtos.store'), ['name' => 'Suco natural', 'price' => 0, 'is_active' => true])
        ->assertRedirect(route('produtos.index'))
        ->assertSessionHasErrors(['price']);
});
