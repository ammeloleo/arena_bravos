<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComandaRequest;
use App\Models\Comanda;
use App\Services\ServicesComanda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ComandaController extends Controller
{
    public function __construct(private readonly ServicesComanda $comandas)
    {
    }

    public function index(Request $request): View
    {
        $status = $request->string('status')->toString() === 'closed' ? 'closed' : 'open';
        $search = $request->string('search')->trim()->toString();

        return view('comandas.index', [
            'comandas' => $this->comandas->listar($status, $search),
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('comandas.create', [
            'recentComandas' => $this->comandas->recentes(),
            
        ]);
    }

    public function store(StoreComandaRequest $request): RedirectResponse
    {
        $comanda = $this->comandas->criar($request->validated());

        return to_route('comandas.show', $comanda)->with('success', 'Comanda criada. Adicione os itens do pedido.');
    }

    public function show(Comanda $comanda): View
    {
        return view('comandas.show', [
            'comanda' => $this->comandas->comItens($comanda),
            'products' => $this->comandas->produtosDisponiveis(),
        ]);
    }

    public function close(Request $request, Comanda $comanda): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => ['nullable', 'string', 'max:50'],
        ]);

        $this->comandas->fechar($comanda, $validated['payment_method'] ?? null);

        return to_route('comandas.index')->with('success', 'Comanda fechada com sucesso.');
    }
}