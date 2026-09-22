<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ServicesProdutos
{
    /**
     * Categorias disponíveis para o formulário de produto.
     */
    public function categorias(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }

    /**
     * Lista produtos filtrados por nome, com a categoria carregada.
     */
    public function listar(string $search): Collection
    {
        return Product::query()
            ->with('category')
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->get();
    }

    /**
     * Cria um novo produto a partir dos dados já validados.
     */
    public function criar(array $dados): Product
    {
        return Product::create($dados);
    }

    /**
     * Atualiza um produto existente.
     */
    public function atualizar(Product $product, array $dados): Product
    {
        $product->update($dados);

        return $product;
    }

    /**
     * Remove um produto do cardápio.
     */
    public function remover(Product $product): void
    {
        $product->delete();
    }
}