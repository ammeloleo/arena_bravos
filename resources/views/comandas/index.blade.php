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

        <div class="card bravos-card">
            <div class="card-body border-bottom bravos-border">
                <form class="row g-2">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="col-sm-5">
                        <input class="form-control" name="search" value="{{ $search }}" placeholder="Buscar por número, mesa ou cliente">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-bravos">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover bravos-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Comanda</th>
                            <th>Cliente</th>
                            <th>Itens</th>
                            <th>Total</th>
                            <th>{{ $status === 'open' ? 'Aberta em' : 'Fechada em' }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comandas as $comanda)
                            <tr>
                                <td>#{{ str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $comanda->label }}</td>
                                <td>{{ $comanda->customer_name ?: '—' }}</td>
                                <td>{{ $comanda->items_count }}</td>
                                <td>R$ {{ number_format((float) $comanda->total, 2, ',', '.') }}</td>
                                <td>{{ ($status === 'open' ? $comanda->created_at : $comanda->closed_at)?->format('d/m H:i') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-bravos" href="{{ route('comandas.show', $comanda) }}">
                                        {{ $status === 'open' ? 'Gerenciar' : 'Ver' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Nenhuma comanda encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>