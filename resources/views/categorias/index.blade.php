<x-layouts.app title="Categorias · Arena Bravos">
    <x-topbar title="Categorias" />

    <div class="container-fluid p-4">
        @include('components.flash')

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card bravos-card">
                    <div class="card-header">
                        <i class="bi bi-tags"></i> Nova categoria
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categorias.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nome *</label>
                                <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button class="btn btn-bravos">Cadastrar categoria</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card bravos-card">
                    <div class="table-responsive">
                        <table class="table align-middle bravos-table mb-0">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Produtos</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <form class="d-flex gap-2" method="POST" action="{{ route('categorias.update', $category) }}">
                                                @csrf
                                                @method('PUT')
                                                <input class="form-control" name="name" value="{{ $category->name }}">
                                                <button class="btn btn-sm btn-outline-bravos">Salvar</button>
                                            </form>
                                        </td>
                                        <td>{{ $category->products_count }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('categorias.destroy', $category) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-bravos-danger" @disabled($category->products_count > 0)>Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Nenhuma categoria cadastrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>