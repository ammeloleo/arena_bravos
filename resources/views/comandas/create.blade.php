<x-layouts.app title="Nova comanda · Arena Bravos">
    <x-topbar title="Nova comanda" />

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
        }

        .bravos-card .card-header {
            background: transparent;
            border-bottom: 1px solid var(--bravos-line);
            color: #fff;
            font-weight: 700;
            letter-spacing: .05em;
            font-size: .8rem;
            text-transform: uppercase;
        }

        .bravos-card .form-label {
            color: #ccc;
            font-size: .8rem;
            letter-spacing: .03em;
        }

        .bravos-card .form-control,
        .bravos-card textarea.form-control {
            background: #0d0d0d;
            border: 1px solid var(--bravos-line);
            color: #f2f2f2;
        }

        .bravos-card .form-control:focus {
            background: #0d0d0d;
            border-color: var(--bravos-red);
            color: #fff;
            box-shadow: 0 0 0 .2rem rgba(227, 6, 19, .15);
        }

        .bravos-card .form-control::placeholder {
            color: #6b6b6b;
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

        .bravos-list .list-group-item {
            background: var(--bravos-bg-soft);
            border-color: var(--bravos-line);
            color: #f2f2f2;
        }

        .bravos-list .list-group-item-action:hover {
            background: #1e1e1e;
            color: #fff;
        }

        .bravos-list .list-group-item.text-muted {
            color: #7a7a7a !important;
        }

        .badge-bravos {
            background: var(--bravos-red);
            color: #fff;
            font-weight: 600;
            letter-spacing: .03em;
        }

        .badge-bravos-open {
            background: #1f8a3c;
            color: #fff;
            font-weight: 600;
            letter-spacing: .03em;
        }
    </style>

    <div class="container-fluid p-4">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card bravos-card">
                    <div class="card-body">
                        <form action="{{ route('comandas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="label">Mesa ou identificação *</label>
                                <input class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" placeholder="Ex.: Mesa 05" required autofocus>
                                @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="customer_name">Cliente</label>
                                <input class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="notes">Observações</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                            </div>
                            <button class="btn btn-bravos" type="submit">
                                <i class="bi bi-dribbble"></i> Criar comanda
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card bravos-card">
                    <div class="card-header">Comandas recentes</div>
                    <ul class="list-group list-group-flush bravos-list">
                        @forelse($recentComandas as $comanda)
                            <a class="list-group-item list-group-item-action" href="{{ route('comandas.show', $comanda) }}">
                                #{{ str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT) }} · {{ $comanda->label }}
                                <span class="badge {{ $comanda->status === 'open' ? 'badge-bravos-open' : 'badge-bravos' }} float-end">
                                    {{ $comanda->status === 'open' ? 'Aberta' : 'Fechada' }}
                                </span>
                            </a>
                        @empty
                            <li class="list-group-item text-muted">Nenhuma comanda criada.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>