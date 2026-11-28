<x-layouts.app title="Nova comanda · Arena Bravos">
    <x-topbar title="Nova comanda" :back="route('comandas.index')" />

    <div class="container-fluid p-4">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card bravos-card">
                    <div class="card-header">Dados do atendimento</div>
                    <div class="card-body">
                        <form action="{{ route('comandas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="label">Mesa ou identificação *</label>
                                <input class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" placeholder="Ex.: Mesa 05" required autofocus>
                                @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="notes">Observações</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                            </div>
                            <button class="btn btn-bravos" type="submit">
                                <i class="bi bi-plus-lg" aria-hidden="true"></i> Criar comanda
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card bravos-card">
                    <div class="card-header">Comandas recentes</div>
                    <div class="list-group list-group-flush bravos-list">
                        @forelse($recentComandas as $comanda)
                            <a class="list-group-item list-group-item-action d-flex align-items-center justify-content-between gap-2" href="{{ route('comandas.show', $comanda) }}">
                                <span class="bravos-order-heading">#{{ str_pad((string) $comanda->id, 3, '0', STR_PAD_LEFT) }} · {{ $comanda->label }}</span>
                                <span class="badge {{ $comanda->isOpen() ? 'badge-bravos-open' : 'badge-bravos-muted' }}">
                                    {{ $comanda->status === 'open' ? 'Aberta' : 'Fechada' }}
                                </span>
                            </a>
                        @empty
                            <div class="list-group-item text-muted">Nenhuma comanda criada.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
