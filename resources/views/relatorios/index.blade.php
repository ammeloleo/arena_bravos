<x-layouts.app title="Relatórios · Arena Bravos">
    <x-topbar title="Relatórios"><select class="form-input period">
            <option>Este Mês</option>
            <option>Semana</option>
            <option>Hoje</option>
        </select></x-topbar>
    <div class="content">
        <div class="rel-kpi">
            @foreach ([['Faturamento Total', 'R$ 45.680', '+15% vs mês anterior'], ['Total de Pedidos', '892', '+12% vs mês anterior'], ['Comandas Fechadas', '156', '+8% vs mês anterior'], ['Ticket Médio', 'R$ 51,25', '+6% vs mês anterior']] as [$label, $value, $sub])
                <div class="rel-k">
                    <small>{{ $label }}</small><b>{{ $value }}</b><em>{{ $sub }}</em></div>
            @endforeach
        </div>
        <div class="grid-dashboard"><x-card title="Faturamento Diário">
                <div class="bar-chart">
                    @foreach ([40, 55, 35, 70, 60, 80, 50, 65, 90, 55, 75, 85, 60, 70, 45, 80, 95, 65, 75, 88, 55, 70, 60, 85, 78, 65, 90, 75, 80, 92] as $height)
                        <i style="height: {{ $height }}%"></i>
                    @endforeach
                </div>
            </x-card><x-card title="Categorias — Faturamento">
                <div class="donut-wrap">
                    <div class="donut"></div>
                    <div>
                        @foreach ([['Bebidas', 'R$ 27.408'], ['Alimentos', 'R$ 11.420'], ['Sobremesas', 'R$ 4.568'], ['Outros', 'R$ 2.284']] as [$name, $value])
                            <div class="legend"><i></i>{{ $name }} <strong>{{ $value }}</strong></div>
                        @endforeach
                    </div>
                </div>
            </x-card></div><x-card title="Produtos Mais Vendidos">
            <table class="ab-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th class="right">Faturamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([['Cerveja Heineken', '245', 'R$ 1.960,00'], ['Água Mineral', '198', 'R$ 990,00'], ['Refrigerante Lata', '156', 'R$ 936,00'], ['Caipirinha', '143', 'R$ 2.002,00'], ['Porção de Batata', '98', 'R$ 1.764,00']] as [$name, $quantity, $revenue])
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="strong">{{ $name }}</td>
                            <td><span class="quantity-bar"
                                    style="width: {{ (int) $quantity / 2.5 }}px"></span>{{ $quantity }}</td>
                            <td class="right price">{{ $revenue }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </div>
</x-layouts.app>
