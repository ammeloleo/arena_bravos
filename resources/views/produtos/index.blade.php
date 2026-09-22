{{-- <x-layouts.app title="Produtos · Arena Bravos">
    <x-topbar title="Produtos" />
    <div class="container-fluid p-4">@include('components.flash')<div class="row g-4"><div class="col-lg-4"><div class="card"><div class="card-header">Novo produto</div><div class="card-body"><form method="POST" action="{{ route('produtos.store') }}">@csrf <div class="mb-3"><label class="form-label">Nome *</label><input class="form-control" name="name" value="{{ old('name') }}" required></div><div class="mb-3"><label class="form-label">Categoria</label><select class="form-select" name="category_id"><option value="">Sem categoria</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label">Preço *</label><input class="form-control" name="price" type="number" step="0.01" min="0.01" required></div><div class="form-check mb-3"><input class="form-check-input" type="hidden" name="is_active" value="0"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked><label class="form-check-label" for="is_active">Produto ativo</label></div><button class="btn btn-primary">Cadastrar produto</button></form></div></div></div><div class="col-lg-8"><div class="card"><div class="card-body border-bottom"><form><input class="form-control" name="search" value="{{ $search }}" placeholder="Buscar produto"></form></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Produto</th><th>Categoria</th><th>Preço</th><th>Status</th><th></th></tr></thead><tbody>@forelse($products as $product)<tr><td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '—' }}</td><td>R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td><td><span class="badge {{ $product->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $product->is_active ? 'Ativo' : 'Inativo' }}</span></td><td class="text-end"><button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $product->id }}">Editar</button><form class="d-inline" method="POST" action="{{ route('produtos.destroy', $product) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Excluir</button></form></td></tr><tr class="collapse" id="edit-{{ $product->id }}"><td colspan="5"><form class="row g-2" method="POST" action="{{ route('produtos.update', $product) }}">@csrf @method('PUT')<div class="col-md-4"><input class="form-control" name="name" value="{{ $product->name }}"></div><div class="col-md-3"><select class="form-select" name="category_id"><option value="">Sem categoria</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($product->category_id === $category->id)>{{ $category->name }}</option>@endforeach</select></div><div class="col-md-2"><input class="form-control" name="price" type="number" step="0.01" value="{{ $product->price }}"></div><div class="col-md-2"><select class="form-select" name="is_active"><option value="1" @selected($product->is_active)>Ativo</option><option value="0" @selected(! $product->is_active)>Inativo</option></select></div><div class="col-md-1"><button class="btn btn-primary">Salvar</button></div></form></td></tr>@empty <tr><td colspan="5" class="text-center text-muted py-4">Nenhum produto cadastrado.</td></tr>@endforelse</tbody></table></div></div></div></div></div>
</x-layouts.app> --}}
<x-layouts.app title="Produtos · Arena Bravos">
    <x-topbar title="Produtos" />

    <div class="container-fluid p-4">
        @include('components.flash')

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card bravos-card">
                    <div class="card-header">
                        <i class="bi bi-cup-straw"></i> Novo produto
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('produtos.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nome *</label>
                                <input class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select class="form-select" name="category_id">
                                    <option value="">Sem categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Preço *</label>
                                <input class="form-control" name="price" type="number" step="0.01" min="0.01" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Produto ativo</label>
                            </div>
                            <button class="btn btn-bravos">Cadastrar produto</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card bravos-card">
                    <div class="card-body border-bottom bravos-border">
                        <form>
                            <input class="form-control" name="search" value="{{ $search }}" placeholder="Buscar produto">
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover bravos-table mb-0">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category?->name ?? '—' }}</td>
                                        <td>R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $product->is_active ? 'badge-bravos-open' : 'badge-bravos-muted' }}">
                                                {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-bravos" data-bs-toggle="collapse" data-bs-target="#edit-{{ $product->id }}">Editar</button>
                                            <form class="d-inline" method="POST" action="{{ route('produtos.destroy', $product) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-bravos-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="edit-{{ $product->id }}">
                                        <td colspan="5">
                                            <form class="row g-2" method="POST" action="{{ route('produtos.update', $product) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="col-md-4">
                                                    <input class="form-control" name="name" value="{{ $product->name }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-select" name="category_id">
                                                        <option value="">Sem categoria</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" @selected($product->category_id === $category->id)>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" name="price" type="number" step="0.01" value="{{ $product->price }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-select" name="is_active">
                                                        <option value="1" @selected($product->is_active)>Ativo</option>
                                                        <option value="0" @selected(! $product->is_active)>Inativo</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-bravos">Salvar</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Nenhum produto cadastrado.</td>
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