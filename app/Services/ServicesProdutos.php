<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class ServicesProdutos
{
    /**
     * Categorias do cadastro com a contagem de produtos.
     */
    public function categorias(): Collection
    {
        return Category::query()->withCount('products')->orderBy('name')->get();
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
    public function criar(array $dados, ?UploadedFile $image = null): Product
    {
        return $this->salvar(new Product, $dados, $image);
    }

    /**
     * Atualiza um produto existente.
     */
    public function atualizar(Product $product, array $dados, ?UploadedFile $image = null): Product
    {
        return $this->salvar($product, $dados, $image);
    }

    /**
     * Remove um produto do cardápio.
     */
    public function remover(Product $product): void
    {
        $product->delete();
    }

    private function salvar(Product $product, array $dados, ?UploadedFile $image): Product
    {
        if ($image === null) {
            $product->fill($dados)->save();

            return $product;
        }

        $disk = Storage::disk('local');
        $path = $image->store('product-images', 'local');

        if ($path === false) {
            throw ValidationException::withMessages(['image' => 'Não foi possível salvar a foto. Tente novamente.']);
        }

        try {
            [$product, $previousPath] = DB::transaction(function () use ($product, $dados, $path): array {
                if ($product->exists) {
                    $product = Product::query()->lockForUpdate()->findOrFail($product->getKey());
                }

                $previousPath = $product->image_path;
                $product->fill($dados);
                $product->image_path = $path;
                $product->save();

                return [$product, $previousPath];
            });
        } catch (Throwable $exception) {
            $disk->delete($path);

            throw $exception;
        }

        if ($previousPath !== null) {
            $disk->delete($previousPath);
        }

        return $product;
    }
}
