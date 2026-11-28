<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ServicesProdutos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ServicesProdutos $products) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('produtos.index', [
            'categories' => $this->products->categorias(),
            'products' => $this->products->listar($search),
            'search' => $search,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->products->criar($request->safe()->except('image'), $request->file('image'));

        return to_route('produtos.index')->with('success', 'Produto cadastrado.');
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->products->atualizar($product, $request->safe()->except('image'), $request->file('image'));

        return to_route('produtos.index')->with('success', 'Produto atualizado.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->products->remover($product);

        return to_route('produtos.index')->with('success', 'Produto removido do cardápio.');
    }

    public function image(Product $product): StreamedResponse
    {
        $disk = Storage::disk('local');
        abort_unless($product->image_path && $disk->fileExists($product->image_path), 404);

        return $disk->response($product->image_path, headers: ['X-Content-Type-Options' => 'nosniff']);
    }
}
