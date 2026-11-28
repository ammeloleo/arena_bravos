<?php

namespace App\Services;

use App\Models\Comanda;
use App\Models\ComandaItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ServicesComanda
{
    /**
     * Lista comandas filtradas por status e busca, com total e contagem de itens.
     */
    public function listar(string $status, string $search): Collection
    {
        return Comanda::query()
            ->withSum('items as total', DB::raw('quantity * unit_price'))
            ->withCount('items')
            ->where('status', $status)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('label', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhereKey($search);
                });
            })
            ->latest()
            ->get();
    }

    /**
     * Comandas mais recentes, usadas na tela de criação.
     */
    public function recentes(int $limit = 5): Collection
    {
        return Comanda::query()->latest()->limit($limit)->get();
    }

    /**
     * Cria uma nova comanda a partir dos dados já validados.
     */
    public function criar(array $dados): Comanda
    {
        return Comanda::create($dados);
    }

    /**
     * Carrega uma comanda com seus itens.
     */
    public function comItens(Comanda $comanda): Comanda
    {
        return $comanda->load('items.product');
    }

    /**
     * Produtos ativos disponíveis para adicionar à comanda.
     */
    public function produtosDisponiveis(): Collection
    {
        return Product::query()->active()->with('category')->orderBy('name')->get();
    }

    /**
     * Fecha uma comanda aberta, opcionalmente informando a forma de pagamento.
     */
    public function fechar(Comanda $comanda, ?string $paymentMethod): Comanda
    {
        abort_unless($comanda->isOpen(), 422, 'Esta comanda já foi fechada.');

        $comanda->update([
            'status' => 'closed',
            'payment_method' => $paymentMethod,
            'closed_at' => now(),
        ]);

        return $comanda;
    }

    /**
     * Adiciona um item à comanda, ou soma a quantidade se o produto já estiver nela.
     */
    public function adicionarItem(Comanda $comanda, int $productId, int $quantity): ComandaItem
    {
        abort_unless($comanda->isOpen(), 422, 'Não é possível alterar uma comanda fechada.');

        $product = Product::query()->active()->findOrFail($productId);

        return DB::transaction(function () use ($comanda, $product, $quantity): ComandaItem {
            $item = $comanda->items()->firstOrNew(['product_id' => $product->id]);
            $item->fill([
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'unit_cost' => $product->cost_price,
                'quantity' => ($item->exists ? $item->quantity : 0) + $quantity,
            ]);
            $item->save();

            return $item;
        });
    }

    /**
     * Remove um item de uma comanda aberta.
     */
    public function removerItem(Comanda $comanda, ComandaItem $item): void
    {
        abort_unless($comanda->isOpen(), 422, 'Não é possível alterar uma comanda fechada.');
        abort_unless($item->comanda_id === $comanda->id, 404);

        $item->delete();
    }
}
