@props(['title', 'back' => null])
<header class="bravos-topbar px-3 py-3 d-flex align-items-center justify-content-between">
    <div class="h4 mb-0 d-flex align-items-center gap-2 bravos-topbar-title">
        @if ($back)
            <a class="btn btn-sm btn-outline-bravos" href="{{ $back }}">
                <i class="bi bi-arrow-left"></i>
            </a>
        @endif

        {{ $title }}
    </div>

    <div class="d-flex align-items-center gap-2">
        {{ $slot }}
    </div>
</header>