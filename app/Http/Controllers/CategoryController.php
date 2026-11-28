<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\ServicesProdutos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function index(): RedirectResponse
    {
        return to_route('produtos.index')->withFragment('categorias');
    }

    public function store(StoreCategoryRequest $request, ServicesProdutos $products): RedirectResponse|JsonResponse
    {
        $category = Category::create($request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $category->id,
                'name' => $category->name,
                'management' => view('produtos.categories', ['categories' => $products->categorias()])->render(),
            ], 201);
        }

        return to_route('produtos.index')
            ->withFragment('categorias')
            ->with('created_category', $category->id)
            ->with('success', 'Categoria cadastrada.');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return to_route('produtos.index')->withFragment('categorias')->with('success', 'Categoria atualizada.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return to_route('produtos.index')->withFragment('categorias')->with('error', 'Não é possível excluir uma categoria que possui produtos.');
        }

        $category->delete();

        return to_route('produtos.index')->withFragment('categorias')->with('success', 'Categoria excluída.');
    }
}
