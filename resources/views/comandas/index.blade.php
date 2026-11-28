{{-- <x-layouts.app :title="($status === 'open' ? 'Comandas abertas' : 'Comandas fechadas').' · Arena Bravos'">
    <x-topbar :title="$status === 'open' ? 'Comandas abertas' : 'Comandas fechadas'"><a class="btn btn-primary" href="{{ route('comandas.create') }}">Nova comanda</a></x-topbar>
    <div class="container-fluid p-4">@include('components.flash')<div class="card"><div class="card-body border-bottom"><form class="row g-2"><input type="hidden" name="status" value="{{ $status }}"><div class="col-sm-5"><input class="form-control" name="search" value="{{ $search }}" placeholder="Buscar por número, mesa ou cliente"></div><div class="col-auto"><button class="btn btn-outline-secondary">Buscar</button></div></form></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>#</th><th>Comanda</th><th>Cliente</th><th>Itens</th><th>Total</th><th>{{ $status === 'open' ? 'Aberta em' : 'Fechada em' }}</th><th></th></tr></thead><tbody>@forelse($comandas as $comanda)<tr><td>#{{ str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT) }}</td><td>{{ $comanda->label }}</td><td>{{ $comanda->customer_name ?: '—' }}</td><td>{{ $comanda->items_count }}</td><td>R$ {{ number_format((float) $comanda->total, 2, ',', '.') }}</td><td>{{ ($status === 'open' ? $comanda->created_at : $comanda->closed_at)?->format('d/m H:i') }}</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('comandas.show', $comanda) }}">{{ $status === 'open' ? 'Gerenciar' : 'Ver' }}</a></td></tr>@empty<tr><td colspan="7" class="text-center text-muted py-4">Nenhuma comanda encontrada.</td></tr>@endforelse</tbody></table></div></div></div>
</x-layouts.app> --}}
<x-layouts.app :title="($status === 'open' ? 'Comandas abertas' : 'Comandas fechadas').' · Arena Bravos'">
    <x-topbar :title="$status === 'open' ? 'Comandas abertas' : 'Comandas fechadas'">
        <a class="btn btn-bravos" href="{{ route('comandas.create') }}">
            <i class="bi bi-plus-lg"></i> Nova comanda
        </a>
    </x-topbar>

    <div class="container-fluid p-4">
        @include('components.flash')

        <nav class="d-flex flex-wrap gap-2 mb-3" aria-label="Filtrar comandas por situação">
            <a class="btn {{ $status === 'open' ? 'btn-bravos' : 'btn-outline-light' }}" href="{{ route('comandas.index', ['search' => $search ?: null]) }}" @if($status === 'open') aria-current="page" @endif>
                Abertas
            </a>
            <a class="btn {{ $status === 'closed' ? 'btn-bravos' : 'btn-outline-light' }}" href="{{ route('comandas.index', ['status' => 'closed', 'search' => $search ?: null]) }}" @if($status === 'closed') aria-current="page" @endif>
                Fechadas
            </a>
        </nav>

        <div class="card bravos-card">
            <div class="card-body border-bottom bravos-border">
                <form class="row g-2 align-items-end" role="search">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="col">
                        <label class="form-label" for="comanda-search">Buscar comanda</label>
                        <input class="form-control" id="comanda-search" type="search" name="search" value="{{ $search }}" placeholder="Número, mesa ou cliente">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-light">
                            <i class="bi bi-search" aria-hidden="true"></i> Buscar
                        </button>
                    </div>
                    @if($search !== '')
                        <div class="col-auto">
                            <a class="btn btn-outline-light" href="{{ route('comandas.index', ['status' => $status]) }}">Limpar</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle bravos-table mb-0">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">Número</th>
                            <th>Comanda</th>
                            <th class="d-none d-xl-table-cell">Cliente</th>
                            <th class="d-none d-lg-table-cell">Itens</th>
                            <th>Total</th>
                            <th class="d-none d-xl-table-cell">{{ $status === 'open' ? 'Aberta em' : 'Fechada em' }}</th>
                            <th><span class="visually-hidden">Ações</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comandas as $comanda)
                            <tr>
                                <td class="d-none d-md-table-cell">#{{ str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="bravos-order-heading">
                                    <strong>{{ $comanda->label }}</strong>
                                    <small class="d-block d-md-none text-muted">#{{ str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT) }}</small>
                                    <small class="d-block d-xl-none text-muted">{{ ($status === 'open' ? $comanda->created_at : $comanda->closed_at)?->format('d/m H:i') }}</small>
                                </td>
                                <td class="d-none d-xl-table-cell text-break">{{ $comanda->customer_name ?: '—' }}</td>
                                <td class="d-none d-lg-table-cell">{{ $comanda->items_count }}</td>
                                <td class="text-nowrap">R$ {{ number_format((float) $comanda->total, 2, ',', '.') }}</td>
                                <td class="d-none d-xl-table-cell text-nowrap">{{ ($status === 'open' ? $comanda->created_at : $comanda->closed_at)?->format('d/m H:i') }}</td>
                                <td class="text-end">
                                    <a class="btn btn-outline-light btn-sm px-4" href="{{ route('comandas.show', $comanda) }}" aria-label="Ver comanda {{ $comanda->label }}">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="mb-1">Nenhuma comanda encontrada.</p>
                                    <small class="text-muted">{{ $search !== '' ? 'Confira o número, a mesa ou o nome do cliente.' : ($status === 'open' ? 'Use Nova comanda para iniciar um atendimento.' : 'As comandas aparecem aqui após o fechamento.') }}</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
