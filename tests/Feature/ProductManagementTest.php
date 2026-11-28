<?php

use App\Models\Category;
use App\Models\Comanda;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

test('categories can be registered from the product catalog', function () {
    $this->from(route('produtos.index'))
        ->post(route('categorias.store'), ['name' => 'Bebidas'])
        ->assertRedirect(route('produtos.index').'#categorias');

    $this->get(route('produtos.index'))
        ->assertOk()
        ->assertSee('Cadastrar produto')
        ->assertSee('Nova categoria')
        ->assertSee('Bebidas');

    $category = Category::query()->sole();
    $this->put(route('categorias.update', $category), ['name' => 'Bebidas geladas'])
        ->assertRedirect(route('produtos.index').'#categorias');
    expect($category->refresh()->name)->toBe('Bebidas geladas');
    $this->get(route('categorias.index'))->assertRedirect(route('produtos.index').'#categorias');

    $quickCategory = $this->postJson(route('categorias.store'), ['name' => 'Porções'])
        ->assertCreated()
        ->assertJsonPath('name', 'Porções');
    expect($quickCategory->json('management'))->toContain('Porções');
    $this->assertDatabaseHas('categories', ['id' => $quickCategory->json('id'), 'name' => 'Porções']);

    $this->postJson(route('categorias.store'), ['name' => 'Porções'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('name');
});

test('a product photo is displayed in the catalog and on the comanda', function () {
    $disk = Storage::fake('local');
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a4VUAAAAASUVORK5CYII=');
    $attributes = ['name' => 'Suco natural', 'price' => 9.5, 'is_active' => true];

    $this->post(route('produtos.store'), [
        ...$attributes,
        'image' => UploadedFile::fake()->createWithContent('suco.png', $png),
    ])->assertRedirect(route('produtos.index'));

    $product = Product::query()->sole();
    $originalPath = $product->image_path;
    $disk->assertExists($originalPath);
    $imageUrl = route('produtos.image', $product);
    $this->get($imageUrl)->assertOk()->assertHeader('Content-Type', 'image/png');
    $this->get(route('produtos.index'))->assertOk()->assertSee($imageUrl);

    $this->put(route('produtos.update', $product), $attributes)->assertRedirect(route('produtos.index'));
    expect($product->refresh()->image_path)->toBe($originalPath);

    $this->post(route('produtos.update', $product), [
        ...$attributes,
        '_method' => 'PUT',
        'image' => UploadedFile::fake()->createWithContent('novo-suco.png', $png),
    ])->assertRedirect(route('produtos.index'));
    $disk->assertExists($product->refresh()->image_path);
    $disk->assertMissing($originalPath);

    $comanda = Comanda::factory()->create();
    $this->post(route('comandas.items.store', $comanda), ['product_id' => $product->id, 'quantity' => 1])
        ->assertRedirect(route('comandas.show', $comanda));
    $this->get(route('comandas.show', $comanda))->assertOk()->assertSee($imageUrl);

    $this->delete(route('produtos.destroy', $product))->assertRedirect(route('produtos.index'));
    $this->assertSoftDeleted($product);
    $this->get(route('comandas.show', $comanda))->assertOk()->assertSee($imageUrl);
    $this->get($imageUrl)->assertOk();
});

test('a product photo must contain an allowed image', function () {
    $disk = Storage::fake('local');
    $textFile = UploadedFile::fake()->createWithContent('suco.png', 'Arquivo de texto');

    $this->from(route('produtos.index'))->post(route('produtos.store'), [
        'name' => 'Suco natural',
        'price' => 9.5,
        'is_active' => true,
        'image' => new UploadedFile($textFile->getPathname(), 'suco.png', test: true),
    ])->assertRedirect(route('produtos.index'))->assertSessionHasErrors('image');

    $disk->assertDirectoryEmpty('product-images');
    $this->assertDatabaseCount('products', 0);
});
