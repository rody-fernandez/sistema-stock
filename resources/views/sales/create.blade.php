@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">🛒 Registrar nueva venta</h3>
            <a href="{{ route('sales.index') }}" class="btn btn-light btn-sm">← Volver</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ups!</strong> Corrige los siguientes errores:<br><br>
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $oldProducts = old('products', [['id' => null, 'quantity' => 1]]);
                $productOptions = $products->map(fn($product) => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                ])->values();
                $productOptionsHtml = $products->map(fn($product) => '<option value="'.$product->id.'" data-price="'.$product->price.'" data-stock="'.$product->stock.'">'.e($product->name).'</option>')->implode('');
            @endphp

            @if($products->isEmpty())
                <div class="alert alert-warning">
                    No hay productos cargados en el sistema. Agrega productos antes de registrar una venta.
                </div>
            @else
            <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">Cliente</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Seleccione un cliente...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <h5 class="fw-bold mb-3">Productos</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="products-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 35%;">Producto</th>
                                <th style="width: 12%;" class="text-end">Precio</th>
                                <th style="width: 12%;" class="text-end">Stock</th>
                                <th style="width: 15%;">Cantidad</th>
                                <th style="width: 15%;" class="text-end">Subtotal</th>
                                <th style="width: 11%;"></th>
                            </tr>
                        </thead>
                        <tbody id="products-body">
                            @foreach($oldProducts as $index => $oldProduct)
                                <tr class="product-row" data-index="{{ $index }}" data-price="0">
                                    <td>
                                        <select name="products[{{ $index }}][id]" class="form-select product-select" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" @selected((string)$oldProduct['id'] === (string)$product->id)>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="product-price text-end">0</td>
                                    <td class="product-stock text-end">0</td>
                                    <td>
                                        <input type="number" name="products[{{ $index }}][quantity]" class="form-control product-qty" min="1" value="{{ $oldProduct['quantity'] ?? 1 }}" required>
                                    </td>
                                    <td class="product-subtotal text-end">0</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-product">✕</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <button type="button" id="add-product" class="btn btn-outline-secondary btn-sm">+ Agregar producto</button>
                    <div class="fs-5">
                        <strong>Total:</strong> <span id="sale-total">0</span> Gs
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Guardar venta</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@if(!$products->isEmpty())
@push('scripts')
<script>
(function() {
    const productsData = @json($productOptions);
    const productOptionsHtml = @json($productOptionsHtml);

    const body = document.getElementById('products-body');
    const addButton = document.getElementById('add-product');
    const totalElement = document.getElementById('sale-total');
    let productIndex = body.querySelectorAll('.product-row').length;

    function formatNumber(value) {
        return new Intl.NumberFormat('es-PY').format(value ?? 0);
    }

    function updateTotals() {
        let total = 0;
        body.querySelectorAll('.product-row').forEach(row => {
            const price = Number(row.dataset.price || 0);
            const qty = Number(row.querySelector('.product-qty').value || 0);
            const subtotal = price * qty;
            row.querySelector('.product-subtotal').textContent = formatNumber(subtotal);
            total += subtotal;
        });
        totalElement.textContent = formatNumber(total);
    }

    function updateRowOptions(row) {
        const select = row.querySelector('.product-select');
        const selectedId = select.value;
        const selectedProduct = productsData.find(item => String(item.id) === String(selectedId));
        const priceCell = row.querySelector('.product-price');
        const stockCell = row.querySelector('.product-stock');

        if (selectedProduct) {
            row.dataset.price = selectedProduct.price;
            priceCell.textContent = formatNumber(selectedProduct.price);
            stockCell.textContent = formatNumber(selectedProduct.stock);
        } else {
            row.dataset.price = 0;
            priceCell.textContent = '0';
            stockCell.textContent = '0';
        }

        updateTotals();
    }

    function refreshRemoveButtons() {
        const rows = body.querySelectorAll('.product-row');
        rows.forEach(buttonRow => {
            const btn = buttonRow.querySelector('.remove-product');
            btn.disabled = rows.length === 1;
        });
    }

    function createRow(index) {
        const row = document.createElement('tr');
        row.classList.add('product-row');
        row.dataset.index = index;
        row.innerHTML = `
            <td>
                <select name="products[${index}][id]" class="form-select product-select" required>
                    <option value="">Seleccione...</option>
                    ${productOptionsHtml}
                </select>
            </td>
            <td class="product-price text-end">0</td>
            <td class="product-stock text-end">0</td>
            <td>
                <input type="number" name="products[${index}][quantity]" class="form-control product-qty" min="1" value="1" required>
            </td>
            <td class="product-subtotal text-end">0</td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm remove-product">✕</button>
            </td>
        `;
        return row;
    }

    function attachRowEvents(row) {
        row.querySelector('.product-select').addEventListener('change', () => updateRowOptions(row));
        row.querySelector('.product-qty').addEventListener('input', updateTotals);
        row.querySelector('.remove-product').addEventListener('click', () => {
            row.remove();
            refreshRemoveButtons();
            updateTotals();
        });
    }

    addButton.addEventListener('click', () => {
        const nextIndex = productIndex++;
        const newRow = createRow(nextIndex);
        body.appendChild(newRow);
        attachRowEvents(newRow);
        updateRowOptions(newRow);
        refreshRemoveButtons();
    });

    body.querySelectorAll('.product-row').forEach(row => {
        attachRowEvents(row);
        updateRowOptions(row);
    });

    refreshRemoveButtons();
})();
</script>
@endpush
@endif
@endsection
