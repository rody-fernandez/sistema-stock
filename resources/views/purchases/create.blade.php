@extends('layouts.app')

@section('content')
<h2 class="mb-4">🛒 Nueva Compra</h2>

@if ($errors->any())
    <div class="alert alert-danger">Verifica los datos ingresados.</div>
@endif

@if($suppliers->isEmpty() || $products->isEmpty())
    <div class="alert alert-warning">
        Para registrar una compra es necesario tener proveedores y productos cargados previamente.
    </div>
@endif

@php
    $oldProducts = old('products', [['id' => null, 'qty' => 1, 'price' => null]]);
    $productOptionsHtml = $products->map(fn($product) => '<option value="'.$product->id.'">'.e($product->name).'</option>')->implode('');
@endphp

<form action="{{ route('purchases.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="supplier_id" class="form-label">Proveedor</label>
        <select name="supplier_id" class="form-select" required>
            <option value="">Seleccione un proveedor...</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>

    <h5>Productos</h5>
    <div id="product-list">
        @foreach($oldProducts as $index => $item)
            <div class="row g-2 align-items-end mb-2 product-row" data-index="{{ $index }}">
                <div class="col-md-4">
                    <select name="products[{{ $index }}][id]" class="form-select" required>
                        <option value="">Producto...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected((string)$item['id'] === (string)$product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[{{ $index }}][qty]" class="form-control" placeholder="Cantidad" value="{{ $item['qty'] ?? 1 }}" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="products[{{ $index }}][price]" class="form-control" placeholder="Precio" value="{{ $item['price'] ?? '' }}" min="0" required>
                </div>
                <div class="col-md-2 text-muted small">
                    <span class="product-subtotal">Subtotal: 0</span>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-product">✕</button>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" id="add-product" class="btn btn-sm btn-secondary mb-3" @disabled($products->isEmpty())>+ Agregar otro producto</button>
    <button type="submit" class="btn btn-success" @disabled($suppliers->isEmpty() || $products->isEmpty())>Guardar Compra</button>
</form>

<script>
(function() {
    const container = document.getElementById('product-list');
    const addButton = document.getElementById('add-product');
    const optionsHtml = @json($productOptionsHtml);
    let productIndex = container.querySelectorAll('.product-row').length;

    function formatNumber(value) {
        return new Intl.NumberFormat('es-PY').format(value ?? 0);
    }

    function updateRowSubtotal(row) {
        const qty = Number(row.querySelector('input[name$="[qty]"]').value || 0);
        const price = Number(row.querySelector('input[name$="[price]"]').value || 0);
        row.querySelector('.product-subtotal').textContent = `Subtotal: ${formatNumber(qty * price)} Gs`;
    }

    function refreshRemoveButtons() {
        const rows = container.querySelectorAll('.product-row');
        rows.forEach(row => {
            const removeButton = row.querySelector('.remove-product');
            if (removeButton) {
                removeButton.disabled = rows.length === 1;
            }
        });
    }

    function addRow(index) {
        const row = document.createElement('div');
        row.classList.add('row', 'g-2', 'align-items-end', 'mb-2', 'product-row');
        row.dataset.index = index;
        row.innerHTML = `
            <div class="col-md-4">
                <select name="products[${index}][id]" class="form-select" required>
                    <option value="">Producto...</option>
                    ${optionsHtml}
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="products[${index}][qty]" class="form-control" placeholder="Cantidad" value="1" min="1" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="products[${index}][price]" class="form-control" placeholder="Precio" value="0" min="0" required>
            </div>
            <div class="col-md-2 text-muted small">
                <span class="product-subtotal">Subtotal: 0</span>
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-product">✕</button>
            </div>
        `;
        container.appendChild(row);
        attachRowEvents(row);
        updateRowSubtotal(row);
        refreshRemoveButtons();
    }

    function attachRowEvents(row) {
        row.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => updateRowSubtotal(row));
        });

        const removeButton = row.querySelector('.remove-product');
        if (removeButton) {
            removeButton.addEventListener('click', () => {
                row.remove();
                refreshRemoveButtons();
            });
        }

        updateRowSubtotal(row);
    }

    addButton.addEventListener('click', () => {
        const nextIndex = productIndex++;
        addRow(nextIndex);
    });

    container.querySelectorAll('.product-row').forEach(row => attachRowEvents(row));
    refreshRemoveButtons();
})();
</script>
@endsection
