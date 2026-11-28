<details class="card bravos-card mt-4" id="category-management">
    <summary class="bravos-disclosure p-3">
        <i class="bi bi-tags" aria-hidden="true"></i> Gerenciar categorias
    </summary>
    <div id="categorias" class="border-top bravos-border">
        <ul class="list-group list-group-flush bravos-list">
            @forelse($categories as $category)
                <li class="list-group-item d-flex flex-wrap align-items-center gap-2">
                    <form class="bravos-category-edit d-flex flex-grow-1 gap-2" method="POST" action="{{ route('categorias.update', $category) }}">
                        @csrf
                        @method('PUT')
                        <input class="form-control form-control-sm" name="name" aria-label="Nome da categoria" value="{{ $category->name }}" required>
                        <button class="btn btn-sm btn-outline-light">Salvar</button>
                    </form>
                    <span class="small text-muted">{{ $category->products_count }} {{ $category->products_count === 1 ? 'produto' : 'produtos' }}</span>
                    <form class="ms-auto" method="POST" action="{{ route('categorias.destroy', $category) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-bravos-danger" @disabled($category->products_count > 0)>Excluir</button>
                    </form>
                </li>
            @empty
                <li class="list-group-item text-muted">Nenhuma categoria cadastrada.</li>
            @endforelse
        </ul>
    </div>
</details>
