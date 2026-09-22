@php
    $current = request()->route()?->getName();
@endphp

<aside class="bravos-sidebar p-3">
    <a class="bravos-brand text-decoration-none d-block mb-4" href="{{ route('dashboard') }}">
        <span class="bravos-brand-arena">ARENA</span>
        <span class="bravos-brand-name">BRAVOS</span>
    </a>

    <div class="bravos-nav-label mb-2">Operação</div>
    <nav class="nav flex-column gap-1">
        <a class="bravos-nav-link {{ $current === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-house me-2"></i>Início
        </a>
        <a class="bravos-nav-link {{ $current === 'comandas.create' ? 'active' : '' }}" href="{{ route('comandas.create') }}">
            <i class="bi bi-plus-circle me-2"></i>Nova comanda
        </a>
        <a class="bravos-nav-link {{ str_starts_with($current ?? '', 'comandas.') && $current !== 'comandas.create' ? 'active' : '' }}" href="{{ route('comandas.index') }}">
            <i class="bi bi-receipt me-2"></i>Comandas abertas
        </a>
        <a class="bravos-nav-link" href="{{ route('comandas.index', ['status' => 'closed']) }}">
            <i class="bi bi-archive me-2"></i>Comandas fechadas
        </a>
    </nav>

    <div class="bravos-nav-label mt-4 mb-2">Cadastros</div>
    <nav class="nav flex-column gap-1">
        <a class="bravos-nav-link {{ str_starts_with($current ?? '', 'produtos.') ? 'active' : '' }}" href="{{ route('produtos.index') }}">
            <i class="bi bi-cup-straw me-2"></i>Produtos
        </a>
        <a class="bravos-nav-link {{ str_starts_with($current ?? '', 'categorias.') ? 'active' : '' }}" href="{{ route('categorias.index') }}">
            <i class="bi bi-tags me-2"></i>Categorias
        </a>
    </nav>
</aside>