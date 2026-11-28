@props(['product' => null])

@if($product?->image_path)
    <img class="bravos-product-thumbnail rounded flex-shrink-0" src="{{ route('produtos.image', $product) }}" alt="" width="48" height="48" loading="lazy">
@else
    <span class="bravos-product-thumbnail rounded d-inline-flex align-items-center justify-content-center flex-shrink-0" aria-hidden="true">
        <i class="bi bi-image"></i>
    </span>
@endif
