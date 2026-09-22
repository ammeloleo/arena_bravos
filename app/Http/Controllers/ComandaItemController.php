<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComandaItemRequest;
use App\Models\Comanda;
use App\Models\ComandaItem;
use App\Services\ServicesComanda;
use Illuminate\Http\RedirectResponse;

class ComandaItemController extends Controller
{
    public function __construct(private readonly ServicesComanda $comandas)
    {
    }

    public function store(StoreComandaItemRequest $request, Comanda $comanda): RedirectResponse
    {
        $this->comandas->adicionarItem(
            $comanda,
            $request->integer('product_id'),
            $request->integer('quantity'),
        );

        return to_route('comandas.show', $comanda)->with('success', 'Item adicionado à comanda.');
    }

    public function destroy(Comanda $comanda, ComandaItem $item): RedirectResponse
    {
        $this->comandas->removerItem($comanda, $item);

        return to_route('comandas.show', $comanda)->with('success', 'Item removido da comanda.');
    }
}