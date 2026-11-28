<x-layouts.app title="Início · Arena Bravos">
    <x-topbar title="Visão geral">
        <a class="btn btn-bravos" href="{{ route('comandas.create') }}">
            <i class="bi bi-plus-lg" aria-hidden="true"></i> Nova comanda
        </a>
    </x-topbar>

    <div class="container-fluid p-4">
        <section aria-labelledby="service-heading">
            <h2 class="h5 mb-1" id="service-heading">Atendimento</h2>
            <p class="text-muted mb-3">Acompanhe os pedidos em andamento e consulte as comandas já fechadas.</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <a class="card bravos-card bravos-dashboard-link h-100 text-decoration-none" href="{{ route('comandas.index') }}">
                        <div class="card-body">
                            <div class="bravos-label"><i class="bi bi-receipt me-1" aria-hidden="true"></i> Comandas abertas</div>
                            <div class="bravos-number">{{ $openComandas }}</div>
                            <span class="bravos-dashboard-action">Ver comandas abertas <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a class="card bravos-card bravos-dashboard-link h-100 text-decoration-none" href="{{ route('comandas.index', ['status' => 'closed']) }}">
                        <div class="card-body">
                            <div class="bravos-label"><i class="bi bi-check-circle me-1" aria-hidden="true"></i> Fechadas hoje</div>
                            <div class="bravos-number">{{ $closedToday }}</div>
                            <span class="bravos-dashboard-action">Ver histórico de comandas <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="mt-4" aria-labelledby="catalog-heading">
            <h2 class="h5 mb-3" id="catalog-heading">Cadastros</h2>
            <a class="card bravos-card bravos-dashboard-link text-decoration-none" href="{{ route('produtos.index') }}">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-cup-straw fs-4" aria-hidden="true"></i>
                    <div class="flex-grow-1">
                        <strong>Produtos e categorias</strong>
                        <span class="d-block small text-muted">Atualize o cardápio, os preços e as fotos dos produtos.</span>
                    </div>
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </div>
            </a>
        </section>
    </div>
</x-layouts.app>
