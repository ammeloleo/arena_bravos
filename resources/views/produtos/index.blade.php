{{-- <x-layouts.app title="Produtos · Arena Bravos">
    <x-topbar title="Produtos" />
    <div class="container-fluid p-4">@include('components.flash')<div class="row g-4"><div class="col-lg-4"><div class="card"><div class="card-header">Novo produto</div><div class="card-body"><form method="POST" action="{{ route('produtos.store') }}">@csrf <div class="mb-3"><label class="form-label">Nome *</label><input class="form-control" name="name" value="{{ old('name') }}" required></div><div class="mb-3"><label class="form-label">Categoria</label><select class="form-select" name="category_id"><option value="">Sem categoria</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label">Preço *</label><input class="form-control" name="price" type="number" step="0.01" min="0.01" required></div><div class="form-check mb-3"><input class="form-check-input" type="hidden" name="is_active" value="0"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked><label class="form-check-label" for="is_active">Produto ativo</label></div><button class="btn btn-primary">Cadastrar produto</button></form></div></div></div><div class="col-lg-8"><div class="card"><div class="card-body border-bottom"><form><input class="form-control" name="search" value="{{ $search }}" placeholder="Buscar produto"></form></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Produto</th><th>Categoria</th><th>Preço</th><th>Status</th><th></th></tr></thead><tbody>@forelse($products as $product)<tr><td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '—' }}</td><td>R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td><td><span class="badge {{ $product->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $product->is_active ? 'Ativo' : 'Inativo' }}</span></td><td class="text-end"><button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $product->id }}">Editar</button><form class="d-inline" method="POST" action="{{ route('produtos.destroy', $product) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Excluir</button></form></td></tr><tr class="collapse" id="edit-{{ $product->id }}"><td colspan="5"><form class="row g-2" method="POST" action="{{ route('produtos.update', $product) }}">@csrf @method('PUT')<div class="col-md-4"><input class="form-control" name="name" value="{{ $product->name }}"></div><div class="col-md-3"><select class="form-select" name="category_id"><option value="">Sem categoria</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($product->category_id === $category->id)>{{ $category->name }}</option>@endforeach</select></div><div class="col-md-2"><input class="form-control" name="price" type="number" step="0.01" value="{{ $product->price }}"></div><div class="col-md-2"><select class="form-select" name="is_active"><option value="1" @selected($product->is_active)>Ativo</option><option value="0" @selected(! $product->is_active)>Inativo</option></select></div><div class="col-md-1"><button class="btn btn-primary">Salvar</button></div></form></td></tr>@empty <tr><td colspan="5" class="text-center text-muted py-4">Nenhum produto cadastrado.</td></tr>@endforelse</tbody></table></div></div></div></div></div>
</x-layouts.app> --}}
<x-layouts.app title="Produtos e categorias · Arena Bravos">
    <x-topbar title="Produtos e categorias" />

    <div class="container-fluid p-4 bravos-catalog">
        @include('components.flash')

        @if($errors->any() || $errors->category->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach([...$errors->all(), ...$errors->category->all()] as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-xl-4">
                <div class="card bravos-card">
                    <div class="card-header">
                        <i class="bi bi-cup-straw"></i> Novo produto
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="product-name">Nome *</label>
                                <input class="form-control" id="product-name" name="name" value="{{ old('_method') || $errors->category->any() ? '' : old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-category">Categoria</label>
                                <select class="form-select" id="product-category" name="category_id">
                                    <option value="">Sem categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(! old('_method') && (string) old('category_id', session('created_category')) === (string) $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <details id="category-quick-add" class="mt-2" @if($errors->category->any() && ! old('_method')) open @endif>
                                    <summary class="bravos-disclosure small">
                                        <i class="bi bi-plus-lg" aria-hidden="true"></i> Nova categoria
                                    </summary>
                                    <div class="bravos-category-panel rounded p-3 mt-2">
                                        <label class="form-label" for="category-name">Nome da categoria</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <input class="form-control flex-grow-1 w-auto" id="category-name" form="category-quick-form" name="name" maxlength="100" value="{{ $errors->category->any() && ! old('_method') ? old('name') : '' }}" required>
                                            <button class="btn btn-sm btn-outline-light" type="submit" form="category-quick-form" id="category-save">Adicionar</button>
                                        </div>
                                        <p class="small bravos-category-error mt-2 mb-0" id="category-error" role="alert" hidden></p>
                                    </div>
                                </details>
                                <p class="small bravos-category-status mt-2 mb-0" id="category-status" role="status" hidden></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-price">Preço *</label>
                                <input class="form-control" id="product-price" name="price" type="number" step="0.01" min="0.01" value="{{ old('_method') ? '' : old('price') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-image">Foto do produto</label>
                                <input class="form-control form-control-sm bravos-photo-input" id="product-image" type="file" name="image" accept="image/jpeg,image/png,image/webp" aria-describedby="product-image-help">
                                <small class="text-muted" id="product-image-help">JPG, PNG ou WebP, até 2 MB.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-cost">Custo unitário (opcional)</label>
                                <input class="form-control" id="product-cost" name="cost_price" type="number" step="0.01" min="0" max="999999.99" value="{{ old('_method') ? '' : old('cost_price') }}" aria-describedby="product-cost-help">
                                <small class="text-muted" id="product-cost-help">Quanto você paga por unidade. Usado no lucro bruto das próximas vendas.</small>
                            </div>
                            <div class="form-check mb-3">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('_method') || old('is_active', '1') === '1')>
                                <label class="form-check-label" for="is_active">Produto ativo</label>
                            </div>
                            <button class="btn btn-bravos">Cadastrar produto</button>
                        </form>
                        <form id="category-quick-form" method="POST" action="{{ route('categorias.store', absolute: false) }}">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card bravos-card">
                    <div class="card-body border-bottom bravos-border">
                        <form class="d-flex gap-2" role="search">
                            <input class="form-control" type="search" name="search" value="{{ $search }}" placeholder="Buscar produto" aria-label="Buscar produto">
                            <button class="btn btn-outline-light" type="submit">Buscar</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle bravos-table mb-0">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th class="d-none d-md-table-cell">Categoria</th>
                                    <th class="d-none d-md-table-cell">Preço</th>
                                    <th class="d-none d-md-table-cell">Status</th>
                                    <th><span class="visually-hidden">Ações</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    @php($editing = (string) old('editing_product') === (string) $product->id)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <x-product-thumbnail :product="$product" />
                                                <div class="bravos-product-name">
                                                    <span>{{ $product->name }}</span>
                                                    <div class="d-md-none small text-muted">
                                                        {{ $product->category?->name ?? 'Sem categoria' }} · R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                                    </div>
                                                    <span class="d-md-none badge {{ $product->is_active ? 'badge-bravos-open' : 'badge-bravos-muted' }}">{{ $product->is_active ? 'Ativo' : 'Inativo' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-break">{{ $product->category?->name ?? '—' }}</td>
                                        <td class="d-none d-md-table-cell text-nowrap">R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="badge {{ $product->is_active ? 'badge-bravos-open' : 'badge-bravos-muted' }}">
                                                {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column flex-md-row justify-content-end gap-1">
                                                <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#edit-{{ $product->id }}" aria-controls="edit-{{ $product->id }}" aria-expanded="{{ $editing ? 'true' : 'false' }}">Editar</button>
                                                <form method="POST" action="{{ route('produtos.destroy', $product) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-bravos-danger w-100">Excluir</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="bravos-product-editor">
                                        <td colspan="5" class="p-0 border-0">
                                            <div class="collapse @if($editing) show @endif" id="edit-{{ $product->id }}">
                                                <div class="p-3">
                                                    <form class="row g-2" method="POST" action="{{ route('produtos.update', $product) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="editing_product" value="{{ $product->id }}">
                                                        <div class="col-md-4">
                                                            <input class="form-control" name="name" aria-label="Nome do produto" value="{{ $editing ? old('name') : $product->name }}" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-select" name="category_id" aria-label="Categoria">
                                                                <option value="">Sem categoria</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}" @selected((string) ($editing ? old('category_id') : $product->category_id) === (string) $category->id)>{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input class="form-control" name="price" aria-label="Preço" type="number" step="0.01" min="0.01" value="{{ $editing ? old('price') : $product->price }}" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-select" name="is_active" aria-label="Status">
                                                                <option value="1" @selected($editing ? (bool) old('is_active') : $product->is_active)>Ativo</option>
                                                                <option value="0" @selected($editing ? ! old('is_active') : ! $product->is_active)>Inativo</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <label class="form-label" for="product-cost-{{ $product->id }}">Custo unitário (opcional)</label>
                                                            <input class="form-control" id="product-cost-{{ $product->id }}" name="cost_price" type="number" step="0.01" min="0" max="999999.99" value="{{ $editing ? old('cost_price') : $product->cost_price }}">
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <label class="form-label" for="product-image-{{ $product->id }}">{{ $product->image_path ? 'Trocar foto' : 'Adicionar foto' }}</label>
                                                            <input class="form-control form-control-sm bravos-photo-input" id="product-image-{{ $product->id }}" type="file" name="image" accept="image/jpeg,image/png,image/webp">
                                                        </div>
                                                        <div class="col-sm-auto align-self-end">
                                                            <button class="btn btn-bravos">Salvar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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

        @include('produtos.categories')
    </div>

    <script>
        const categoryForm = document.getElementById('category-quick-form');
        const categoryDetails = document.getElementById('category-quick-add');
        const categorySelect = document.getElementById('product-category');
        const categorySave = document.getElementById('category-save');
        const categoryError = document.getElementById('category-error');
        const categoryStatus = document.getElementById('category-status');

        categoryForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            categorySave.disabled = true;
            categoryError.hidden = true;
            categoryStatus.hidden = true;

            try {
                const response = await fetch(categoryForm.action, {
                    method: 'POST',
                    headers: { Accept: 'application/json' },
                    body: new FormData(categoryForm),
                });

                if (response.status === 422) {
                    const result = await response.json();
                    categoryError.textContent = result.errors.name[0];
                    categoryError.hidden = false;
                    document.getElementById('category-name').focus();
                    return;
                }

                if (!response.ok) {
                    throw new Error();
                }

                const category = await response.json();
                document.querySelectorAll('.bravos-catalog select[name="category_id"]').forEach((select) => {
                    select.add(new Option(category.name, category.id, false, select === categorySelect));
                });
                const management = document.getElementById('category-management');
                const managementWasOpen = management.open;
                management.outerHTML = category.management;
                document.getElementById('category-management').open = managementWasOpen;

                categoryForm.reset();
                categoryDetails.open = false;
                categoryStatus.textContent = 'Categoria criada e selecionada.';
                categoryStatus.hidden = false;
                categorySelect.focus();
            } catch {
                categoryError.textContent = 'Não foi possível cadastrar a categoria. Tente novamente.';
                categoryError.hidden = false;
            } finally {
                categorySave.disabled = false;
            }
        });
    </script>
</x-layouts.app>
