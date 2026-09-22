{{-- <x-layouts.app :title="'Comanda #'.str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT).' · Arena Bravos'">
    <x-topbar :title="'Comanda #'.str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT)" :back="route('comandas.index', ['status' => $comanda->status])"><span class="badge {{ $comanda->isOpen() ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $comanda->isOpen() ? 'Aberta' : 'Fechada' }}</span></x-topbar>
    <div class="container-fluid p-4">@include('components.flash')<div class="row g-4"><div class="col-lg-7"><div class="card"><div class="card-header d-flex justify-content-between"><span>{{ $comanda->label }}{{ $comanda->customer_name ? ' · '.$comanda->customer_name : '' }}</span><span>Total: <strong>R$ {{ number_format($comanda->total(), 2, ',', '.') }}</strong></span></div><ul class="list-group list-group-flush">@forelse($comanda->items as $item)<li class="list-group-item d-flex align-items-center justify-content-between"><div><strong>{{ $item->quantity }}x {{ $item->product_name }}</strong><small class="d-block text-muted">R$ {{ number_format((float) $item->unit_price, 2, ',', '.') }} cada</small></div><div>R$ {{ number_format($item->subtotal(), 2, ',', '.') }} @if($comanda->isOpen())<form class="d-inline" method="POST" action="{{ route('comandas.items.destroy', [$comanda, $item]) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-link text-danger" title="Remover"><i class="bi bi-trash"></i></button></form>@endif</div></li>@empty<li class="list-group-item text-muted">Nenhum item adicionado.</li>@endforelse</ul>@if($comanda->isOpen())<div class="card-body border-top"><form method="POST" action="{{ route('comandas.close', $comanda) }}" class="d-flex gap-2">@csrf <input class="form-control" name="payment_method" placeholder="Forma de pagamento (opcional)"><button class="btn btn-success text-nowrap">Fechar comanda</button></form></div>@endif</div></div><div class="col-lg-5">@if($comanda->isOpen())<div class="card"><div class="card-header">Adicionar item</div><div class="list-group list-group-flush">@forelse($products as $product)<div class="list-group-item d-flex align-items-center justify-content-between"><span>{{ $product->name }}<small class="d-block text-muted">{{ $product->category?->name ?? 'Sem categoria' }} · R$ {{ number_format((float) $product->price, 2, ',', '.') }}</small></span><form method="POST" action="{{ route('comandas.items.store', $comanda) }}" class="d-flex gap-1">@csrf <input type="hidden" name="product_id" value="{{ $product->id }}"><input class="form-control form-control-sm" type="number" name="quantity" value="1" min="1" style="width:65px"><button class="btn btn-sm btn-primary">Adicionar</button></form></div>@empty <div class="list-group-item text-muted">Cadastre um produto ativo para adicionar itens.</div>@endforelse</div></div>@endif</div></div></div>
</x-layouts.app> --}}
<x-layouts.app :title="'Comanda #'.str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT).' · Arena Bravos'">
    <x-topbar :title="'Comanda #'.str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT)" :back="route('comandas.index', ['status' => $comanda->status])">
        <span class="badge {{ $comanda->isOpen() ? 'badge-bravos-open' : 'badge-bravos' }}">
            {{ $comanda->isOpen() ? 'Aberta' : 'Fechada' }}
        </span>
    </x-topbar>

    <div class="container-fluid p-4">
        @include('components.flash')

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card bravos-card">
                    <div class="card-header d-flex justify-content-between bravos-border">
                        <span>{{ $comanda->label }}{{ $comanda->customer_name ? ' · '.$comanda->customer_name : '' }}</span>
                        <span>Total: <strong class="text-bravos-red">R$ {{ number_format($comanda->total(), 2, ',', '.') }}</strong></span>
                    </div>

                    <ul class="list-group list-group-flush bravos-list">
                        @forelse($comanda->items as $item)
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <div>
                                    <strong>{{ $item->quantity }}x {{ $item->product_name }}</strong>
                                    <small class="d-block text-muted">R$ {{ number_format((float) $item->unit_price, 2, ',', '.') }} cada</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    R$ {{ number_format($item->subtotal(), 2, ',', '.') }}
                                    @if($comanda->isOpen())
                                        <form class="d-inline" method="POST" action="{{ route('comandas.items.destroy', [$comanda, $item]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-link text-bravos-red" title="Remover">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Nenhum item adicionado.</li>
                        @endforelse
                    </ul>

                    @if($comanda->isOpen())
                        <div class="card-body border-top bravos-border">
                            <form method="POST" action="{{ route('comandas.close', $comanda) }}" class="d-flex gap-2">
                                @csrf
                                <input class="form-control" name="payment_method" placeholder="Forma de pagamento (opcional)">
                                <button class="btn btn-bravos-success text-nowrap">
                                    <i class="bi bi-check2-circle"></i> Fechar comanda
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                @if($comanda->isOpen())
                    <div class="card bravos-card">
                        <div class="card-header">
                            <i class="bi bi-dribbble"></i> Adicionar item
                        </div>
                        <div class="list-group list-group-flush bravos-list">
                            @forelse($products as $product)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <span>
                                        {{ $product->name }}
                                        <small class="d-block text-muted">{{ $product->category?->name ?? 'Sem categoria' }} · R$ {{ number_format((float) $product->price, 2, ',', '.') }}</small>
                                    </span>
                                    <form method="POST" action="{{ route('comandas.items.store', $comanda) }}" class="d-flex gap-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input class="form-control form-control-sm" type="number" name="quantity" value="1" min="1" style="width:65px">
                                        <button class="btn btn-sm btn-bravos">Adicionar</button>
                                    </form>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">Cadastre um produto ativo para adicionar itens.</div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
