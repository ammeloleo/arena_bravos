<x-layouts.app title="Relatórios · Arena Bravos">
    <x-topbar title="Relatórios" />

    <div class="container-fluid p-4">
        <div class="card bravos-card mb-4">
            <form class="card-body d-flex flex-wrap align-items-end gap-3" method="GET" action="{{ route('relatorios.index') }}">
                <div>
                    <label class="form-label" for="report-date">Data de referência</label>
                    <input class="form-control" id="report-date" type="date" name="date" min="2000-01-01" max="{{ $today->toDateString() }}" value="{{ $date->toDateString() }}" required>
                </div>
                <button class="btn btn-bravos">Consultar</button>
                <a class="btn btn-outline-light" href="{{ route('relatorios.index') }}">Hoje</a>
                <p class="small text-muted mb-0">Vendas por data de fechamento · Horário de Brasília</p>
            </form>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
        @endif

        @foreach([
            ['title' => 'Dia '.$date->format('d/m/Y'), 'data' => $day, 'change' => $dayChange, 'comparison' => 'em relação ao dia anterior'],
            ['title' => 'Mês até '.$date->format('d/m/Y'), 'data' => $month, 'change' => $monthChange, 'comparison' => 'em relação ao mesmo intervalo do mês anterior'],
        ] as $section)
            @php($summary = $section['data'])
            <section class="mb-4" aria-label="{{ $section['title'] }}">
                <h2 class="h5 mb-3">{{ $section['title'] }}</h2>
                <div class="row g-3">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card bravos-card h-100"><div class="card-body">
                            <div class="bravos-label">Faturamento</div>
                            <div class="h3 mt-2">R$ {{ number_format($summary['revenue'], 2, ',', '.') }}</div>
                            <p class="small mb-0 text-muted">
                                @if($section['change'] !== null)
                                    <strong class="{{ $section['change'] >= 0 ? 'bravos-category-status' : 'bravos-category-error' }}">{{ $section['change'] > 0 ? '+' : '' }}{{ number_format($section['change'], 1, ',', '.') }}%</strong> {{ $section['comparison'] }}
                                @else
                                    Sem faturamento na base de comparação.
                                @endif
                            </p>
                        </div></div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card bravos-card h-100"><div class="card-body">
                            <div class="bravos-label">Lucro bruto</div>
                            <div class="h3 mt-2">{{ $summary['profit'] === null ? 'Pendente' : 'R$ '.number_format($summary['profit'], 2, ',', '.') }}</div>
                            <p class="small text-muted mb-0">
                                @if($summary['missingCost'] > 0)
                                    {{ $summary['missingCost'] }} unidade(s) vendida(s) sem custo registrado.
                                @else
                                    Margem {{ $summary['margin'] === null ? '—' : number_format($summary['margin'], 1, ',', '.').'%' }}
                                @endif
                            </p>
                        </div></div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card bravos-card h-100"><div class="card-body">
                            <div class="bravos-label">Comandas fechadas</div>
                            <div class="h3 mt-2">{{ $summary['orders'] }}</div>
                            <p class="small text-muted mb-0">{{ $summary['units'] }} unidade(s) vendida(s)</p>
                        </div></div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card bravos-card h-100"><div class="card-body">
                            <div class="bravos-label">Ticket médio</div>
                            <div class="h3 mt-2">R$ {{ number_format($summary['ticket'], 2, ',', '.') }}</div>
                            <p class="small text-muted mb-0">Faturamento por comanda fechada.</p>
                        </div></div>
                    </div>
                </div>
            </section>
        @endforeach

        <p class="small text-muted mb-4">Lucro bruto = faturamento menos o custo dos produtos vendidos. Despesas, taxas e impostos devem ser considerados à parte. Cadastre o custo unitário em Produtos para as próximas vendas. Custos atuais não alteram vendas já registradas.</p>

        <div class="row g-4">
            @foreach([
                ['title' => 'Faturamento diário do mês', 'rows' => $daily],
                ['title' => 'Faturamento nos últimos 12 meses', 'rows' => $monthly],
            ] as $chart)
                <section class="col-xl-6" aria-label="{{ $chart['title'] }}">
                    <div class="card bravos-card h-100">
                        <div class="card-header">{{ $chart['title'] }}</div>
                        <div class="card-body">
                            @if($chart['rows']->sum('orders') === 0)
                                <p class="small text-muted">Nenhuma comanda fechada neste intervalo.</p>
                            @endif
                            <div class="bravos-report-chart" role="list" aria-label="{{ $chart['title'] }} em reais">
                                @php($maximum = max(1, $chart['rows']->max('revenue')))
                                @foreach($chart['rows'] as $point)
                                    <div class="bravos-report-row" role="listitem">
                                        <span class="small text-muted">{{ $point['label'] }}</span>
                                        <div class="bravos-report-track" aria-hidden="true">
                                            <span style="width: {{ round($point['revenue'] / $maximum * 100, 2) }}%"></span>
                                        </div>
                                        <span class="small text-end text-nowrap">R$ {{ number_format($point['revenue'], 2, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>

        <section class="card bravos-card mt-4" aria-label="Resumo diário">
            <div class="card-header">Resumo diário do mês</div>
            <div class="table-responsive">
                <table class="table bravos-table align-middle mb-0">
                    <thead><tr><th>Dia</th><th>Comandas</th><th>Faturamento</th><th>Lucro bruto</th><th>Margem</th></tr></thead>
                    <tbody>
                        @foreach($daily->reverse() as $point)
                            <tr>
                                <td>{{ $point['label'] }}</td>
                                <td>{{ $point['orders'] }}</td>
                                <td class="text-nowrap">R$ {{ number_format($point['revenue'], 2, ',', '.') }}</td>
                                <td class="text-nowrap">{{ $point['profit'] === null ? 'Custo pendente' : 'R$ '.number_format($point['profit'], 2, ',', '.') }}</td>
                                <td>{{ $point['margin'] === null ? '—' : number_format($point['margin'], 1, ',', '.').'%' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.app>
