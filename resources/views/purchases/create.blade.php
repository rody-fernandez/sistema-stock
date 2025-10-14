@extends('layouts.app')

@section('content')
<h2 class="mb-4">🛒 Nueva Compra</h2>

<form action="{{ route('purchases.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="supplier_id" class="form-label">Proveedor</label>
        <select name="supplier_id" class="form-select" required>
            <option value="">Seleccione un proveedor...</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>

    <h5>Productos</h5>
    <div id="product-list">
        <div class="row mb-2">
            <div class="col-md-4">
                <select name="products[0][id]" class="form-select" required>
                    <option value="">Producto...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="products[0][qty]" class="form-control" placeholder="Cantidad" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="products[0][price]" class="form-control" placeholder="Precio" required>
            </div>
        </div>
    </div>

    <button type="button" id="add-product" class="btn btn-sm btn-secondary mb-3">+ Agregar otro producto</button>
    <button type="submit" class="btn btn-success">Guardar Compra</button>
</form>

<script>
let productIndex = 1;
document.getElementById('add-product').addEventListener('click', () => {
    const container = document.getElementById('product-list');
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-2');
    newRow.innerHTML = `
        <div class="col-md-4">
            <select name="products[${productIndex}][id]" class="form-select" required>
                <option value="">Producto...</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="products[${productIndex}][qty]" class="form-control" placeholder="Cantidad" required>
        </div>
        <div class="col-md-3">
            <input type="number" step="0.01" name="products[${productIndex}][price]" class="form-control" placeholder="Precio" required>
        </div>
    `;
    container.appendChild(newRow);
    productIndex++;
});
</script>
@endsection
