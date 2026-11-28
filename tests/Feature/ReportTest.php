<?php

use App\Models\Comanda;
use App\Models\ComandaItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reports count closed sales in the Brasilia day and preserve historical costs', function () {
    $this->travelTo(now()->parse('2026-03-16 12:00:00', 'UTC'));
    $product = Product::factory()->create(['price' => 20, 'cost_price' => 8]);
    $sale = Comanda::factory()->create();
    $this->post(route('comandas.items.store', $sale), ['product_id' => $product->id, 'quantity' => 2])->assertRedirect();
    $this->post(route('comandas.close', $sale), [])->assertRedirect();
    $product->update(['price' => 99, 'cost_price' => 90]);

    $previous = Comanda::factory()->closed()->create(['closed_at' => '2026-03-16 02:59:59']);
    ComandaItem::factory()->create(['comanda_id' => $previous->id, 'quantity' => 1, 'unit_price' => 10, 'unit_cost' => 4]);
    $oldMonth = Comanda::factory()->closed()->create(['closed_at' => '2026-02-16 12:00:00']);
    ComandaItem::factory()->create(['comanda_id' => $oldMonth->id, 'quantity' => 1, 'unit_price' => 25, 'unit_cost' => 10]);
    $outside = Comanda::factory()->closed()->create(['closed_at' => '2026-02-17 12:00:00']);
    ComandaItem::factory()->create(['comanda_id' => $outside->id, 'quantity' => 1, 'unit_price' => 900, 'unit_cost' => 2]);
    $open = Comanda::factory()->create();
    ComandaItem::factory()->create(['comanda_id' => $open->id, 'quantity' => 1, 'unit_price' => 500, 'unit_cost' => 1]);

    $this->get(route('relatorios.index', ['date' => '2026-03-16']))
        ->assertOk()
        ->assertViewHas('day', fn (array $day): bool => $day['revenue'] === 40.0 && $day['profit'] === 24.0 && $day['margin'] === 60.0 && $day['orders'] === 1 && $day['ticket'] === 40.0)
        ->assertViewHas('month', fn (array $month): bool => $month['revenue'] === 50.0 && $month['orders'] === 2)
        ->assertViewHas('dayChange', 300.0)
        ->assertViewHas('monthChange', 100.0)
        ->assertViewHas('daily', fn ($daily): bool => $daily->count() === 16 && $daily->first()['revenue'] === 0.0)
        ->assertViewHas('monthly', fn ($monthly): bool => $monthly->count() === 12 && $monthly->first()['label'] === '04/2025');

    $this->assertDatabaseHas('comanda_items', ['comanda_id' => $sale->id, 'unit_cost' => 8, 'unit_price' => 20]);
});

test('reports flag unknown historic costs and handle an empty comparison', function () {
    $this->travelTo(now()->parse('2026-01-01 12:00:00', 'UTC'));
    $sale = Comanda::factory()->closed()->create();
    ComandaItem::factory()->create(['comanda_id' => $sale->id, 'unit_price' => 12.5, 'unit_cost' => null, 'quantity' => 2]);

    $this->get(route('relatorios.index', ['date' => '2026-01-01']))
        ->assertOk()
        ->assertSee('Pendente')
        ->assertViewHas('day', fn (array $day): bool => $day['revenue'] === 25.0 && $day['profit'] === null && $day['margin'] === null && $day['missingCost'] === 2)
        ->assertViewHas('dayChange', null)
        ->assertViewHas('monthChange', null);
});

test('an empty report renders without divisions by zero', function () {
    $this->get(route('relatorios.index'))
        ->assertOk()
        ->assertViewHas('day', fn (array $day): bool => $day['revenue'] === 0.0 && $day['profit'] === 0.0 && $day['ticket'] === 0.0 && $day['margin'] === null);
});

test('reports reject invalid dates', function (string $date) {
    $this->travelTo(now()->parse('2026-03-16 12:00:00', 'UTC'));
    $this->getJson(route('relatorios.index', ['date' => $date]))->assertUnprocessable()->assertJsonValidationErrors('date');
})->with(['invalid-date', '2026-02-30', '2026-03-17', '1999-12-31']);

test('product costs accept zero and reject negative values', function () {
    $attributes = ['name' => 'Água', 'price' => 5, 'is_active' => true];
    $this->post(route('produtos.store'), [...$attributes, 'cost_price' => 0])->assertRedirect();
    $this->assertDatabaseHas('products', ['name' => 'Água', 'cost_price' => 0]);
    $this->postJson(route('produtos.store'), [...$attributes, 'cost_price' => -1])->assertUnprocessable()->assertJsonValidationErrors('cost_price');
});
