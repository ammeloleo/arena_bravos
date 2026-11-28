@props(['title', 'back' => null])
<header class="bravos-topbar">
    <div class="bravos-topbar-inner d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
        <div class="d-flex align-items-center gap-2">
            @if ($back)
                <a class="btn btn-sm btn-outline-light" href="{{ $back }}" aria-label="Voltar para a lista de comandas">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i>
                </a>
            @endif
            <h1 class="h4 mb-0 bravos-topbar-title">{{ $title }}</h1>
        </div>
        @if($slot->isNotEmpty())
            <div class="d-flex flex-wrap align-items-center gap-2">
                {{ $slot }}
            </div>
        @endif
    </div>
</header>
