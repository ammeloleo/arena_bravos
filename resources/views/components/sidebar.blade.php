@php
    $current = request()->route()?->getName();
    $isComandaList = $current === 'comandas.index';
    $closed = $current === 'comandas.show'
        ? ! request()->route('comanda')->isOpen()
        : request()->query('status') === 'closed';
    $inComandas = $isComandaList || $current === 'comandas.show';
    $inCatalog = str_starts_with($current ?? '', 'produtos.');
@endphp

<aside class="bravos-sidebar p-3">
    <div class="bravos-brand-panel d-flex align-items-center justify-content-between gap-3 mb-lg-4">
        <a class="bravos-brand text-decoration-none" href="{{ route('dashboard') }}">
            <span class="bravos-brand-arena">ARENA</span>
            <span class="bravos-brand-name">BRAVOS</span>
        </a>
        <button class="btn btn-sm btn-outline-light d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#bravos-navigation" aria-expanded="false" aria-controls="bravos-navigation">
            <i class="bi bi-list" aria-hidden="true"></i> Menu
        </button>
    </div>

    <div class="collapse d-lg-block mt-3 mt-lg-0" id="bravos-navigation">
        <div class="bravos-nav-label mb-2">Operação</div>
        <nav class="nav flex-row flex-lg-column gap-1" aria-label="Operação">
            <a class="bravos-nav-link {{ $current === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}" @if($current === 'dashboard') aria-current="page" @endif>
                <i class="bi bi-house me-2"></i>Início
            </a>
            <a class="bravos-nav-link {{ $current === 'comandas.create' ? 'active' : '' }}" href="{{ route('comandas.create') }}" @if($current === 'comandas.create') aria-current="page" @endif>
                <i class="bi bi-plus-circle me-2"></i>Nova comanda
            </a>
            <a class="bravos-nav-link {{ $inComandas && ! $closed ? 'active' : '' }}" href="{{ route('comandas.index') }}" @if($isComandaList && ! $closed) aria-current="page" @endif>
                <i class="bi bi-receipt me-2"></i>Comandas abertas
            </a>
            <a class="bravos-nav-link {{ $inComandas && $closed ? 'active' : '' }}" href="{{ route('comandas.index', ['status' => 'closed']) }}" @if($isComandaList && $closed) aria-current="page" @endif>
                <i class="bi bi-archive me-2"></i>Comandas fechadas
            </a>
        </nav>

        <div class="bravos-nav-label mt-4 mb-2">Gestão</div>
        <nav class="nav flex-row flex-lg-column gap-1 mb-3" aria-label="Relatórios">
            <a class="bravos-nav-link {{ $current === 'relatorios.index' ? 'active' : '' }}" href="{{ route('relatorios.index') }}" @if($current === 'relatorios.index') aria-current="page" @endif>
                <i class="bi bi-bar-chart-line me-2" aria-hidden="true"></i>Relatórios
            </a>
        </nav>
        <div class="bravos-nav-label mt-4 mb-2">Cadastros</div>
        <nav class="nav flex-row flex-lg-column gap-1" aria-label="Cadastros">
            <a class="bravos-nav-link {{ $inCatalog ? 'active' : '' }}" href="{{ route('produtos.index') }}" @if($inCatalog) aria-current="page" @endif>
                <i class="bi bi-cup-straw me-2"></i>Produtos e categorias
            </a>
        </nav>
    </div>
</aside>
