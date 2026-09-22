<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class ServicesCategory
{
    /**
     * Lista categorias com a contagem de produtos vinculados.
     */
    public function listar(): Collection
    {
        return Category::query()->withCount('products')->orderBy('name')->get();
    }

    /**
     * Cria uma nova categoria a partir dos dados já validados.
     */
    public function criar(array $dados): Category
    {
        return Category::create($dados);
    }

    /**
     * Atualiza uma categoria existente.
     */
    public function atualizar(Category $category, array $dados): Category
    {
        $category->update($dados);

        return $category;
    }

    /**
     * Remove uma categoria, desde que não possua produtos vinculados.
     *
     * Retorna true se a categoria foi excluída, false se havia produtos
     * vinculados e a exclusão não foi realizada.
     */
    public function remover(Category $category): bool
    {
        if ($category->products()->exists()) {
            return false;
        }

        $category->delete();

        return true;
    }
}