@props(['title' => null])

<section class="card bravos-card">
    <header class="bravos-card-head">
        <div class="d-flex align-items-center gap-2">
            <span class="bravos-card-marker">◆</span>
            {{ $title }}
        </div>

        {{ $actions ?? '' }}
    </header>

    <div class="card-body">
        {{ $slot }}
    </div>
</section>