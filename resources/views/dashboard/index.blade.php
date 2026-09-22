<x-layouts.app title="Início · Arena Bravos">
    <x-topbar title="Operação">
        <a class="btn btn-bravos" href="{{ route('comandas.create') }}">
            <i class="bi bi-plus-lg"></i> Nova comanda
        </a>
    </x-topbar>

    <style>
        :root {
            --bravos-bg: #0d0d0d;
            --bravos-bg-soft: #161616;
            --bravos-red: #e30613;
            --bravos-red-dark: #a5040e;
            --bravos-line: #2a2a2a;
        }

        .container-fluid.p-4 {
            background: var(--bravos-bg);
            min-height: 100%;
            border-radius: .5rem;
            position: relative;
            overflow: hidden;
        }

        /* listras diagonais inspiradas na logo */
        .container-fluid.p-4::before {
            content: "";
            position: absolute;
            top: -20px; right: -60px;
            width: 260px; height: 140px;
            background: repeating-linear-gradient(
                -35deg,
                var(--bravos-red) 0px, var(--bravos-red) 14px,
                transparent 14px, transparent 26px
            );
            opacity: .18;
            pointer-events: none;
        }

        .bravos-card {
            background: var(--bravos-bg-soft);
            border: 1px solid var(--bravos-line);
            border-radius: .75rem;
            color: #f2f2f2;
            transition: border-color .2s ease, transform .15s ease;
        }

        a.bravos-card:hover {
            border-color: var(--bravos-red);
            transform: translateY(-2px);
        }

        .bravos-label {
            color: #9a9a9a;
            font-size: .75rem;
            letter-spacing: .08em;
            font-weight: 600;
        }

        .bravos-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            border-left: 4px solid var(--bravos-red);
            padding-left: .75rem;
            margin-top: .25rem;
        }

        .bravos-main-card {
            background: var(--bravos-bg-soft);
            border: 1px solid var(--bravos-line);
            border-radius: .75rem;
            color: #f2f2f2;
            position: relative;
        }

        .bravos-title {
            color: #fff;
            font-weight: 700;
            letter-spacing: .03em;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .bravos-title i {
            color: var(--bravos-red);
        }

        .bravos-title small {
            font-size: .6rem;
            color: var(--bravos-red);
            letter-spacing: .15em;
            font-weight: 700;
        }

        .btn-bravos {
            background: var(--bravos-red);
            border: 1px solid var(--bravos-red);
            color: #fff;
            font-weight: 600;
            letter-spacing: .03em;
        }

        .btn-bravos:hover {
            background: var(--bravos-red-dark);
            border-color: var(--bravos-red-dark);
            color: #fff;
        }
    </style>

    <div class="container-fluid p-4">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <a class="card bravos-card text-decoration-none" href="{{ route('comandas.index') }}">
                    <div class="card-body">
                        <div class="bravos-label"><i class="bi bi-receipt"></i> COMANDAS ABERTAS</div>
                        <div class="bravos-number">{{ $openComandas }}</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="card bravos-card text-decoration-none" href="{{ route('comandas.index', ['status' => 'closed']) }}">
                    <div class="card-body">
                        <div class="bravos-label"><i class="bi bi-check-circle"></i> FECHADAS HOJE</div>
                        <div class="bravos-number">{{ $closedToday }}</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="card bravos-main-card">
            <div class="card-body">
                <h2 class="h5 bravos-title">
                    <i class="bi bi-dribbble"></i> ARENA <small>BRAVOS</small> · MVP
                </h2>
                <p class="text-muted mb-3">Cadastre produtos e categorias, abra comandas, adicione itens e feche a venda. Não há gráficos ou relatórios neste MVP.</p>
                <a class="btn btn-bravos" href="{{ route('produtos.index') }}">Cadastrar produtos</a>
            </div>
        </div>
    </div>
</x-layouts.app>