<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\StoreProductRequest;
    use App\Http\Requests\UpdateProductRequest;
    use App\Models\Product;
    use App\Services\ServicesProdutos;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class ProductController extends Controller
    {
        public function __construct(private readonly ServicesProdutos $products)
        {
            
        }

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
            $this->products->criar($request->validated());

            return to_route('produtos.index')->with('success', 'Produto cadastrado.');
        }

        public function update(UpdateProductRequest $request, Product $product): RedirectResponse
        {
            $this->products->atualizar($product, $request->validated());

            return to_route('produtos.index')->with('success', 'Produto atualizado.');
        }

        public function destroy(Product $product): RedirectResponse
        {
            $this->products->remover($product);

            return to_route('produtos.index')->with('success', 'Produto removido do cardápio.');
        }
    }