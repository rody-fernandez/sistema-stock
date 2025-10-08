@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>➕ Registrar Nueva Compra</h2>

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Proveedor</label>
            <select name="supplier_id" id="supplier_id" class="form-select" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <hr>
        <h5>🧾 Productos</h5>

        <table class="table table-bordered" id="productsTable">
            <thead class="table-secondary">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario (Gs)</th>
                    <th>Subtotal (Gs)</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button type="button" class="btn btn-outline-success" id="addProduct">➕ Agregar Producto</button>

        <div class="mt-4 text-end">
            <h4>Total: <span id="totalAmount">0</span> Gs</h4>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">💾 Guardar Compra</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const products = @json($products);
    const tbody = document.querySelector("#productsTable tbody");
    const addBtn = document.getElementById("addProduct");
    const totalDisplay = document.getElementById("totalAmount");

    addBtn.addEventListener("click", () => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>
                <select name="products[][id]" class="form-select product-select" required>
                    <option value="">Seleccionar</option>
                    ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="products[][qty]" class="form-control qty" min="1" value="1" required></td>
            <td><input type="number" name="products[][price]" class="form-control price" min="0" value="0" required></td>
            <td class="subtotal">0</td>
            <td><button type="button" class="btn btn-danger btn-sm remove">✖</button></td>
        `;
        tbody.appendChild(row);
        updateTotals();
    });

    tbody.addEventListener("input", (e) => {
        if (e.target.classList.contains("qty") || e.target.classList.contains("price")) {
            updateTotals();
        }
    });

    tbody.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove")) {
            e.target.closest("tr").remove();
            updateTotals();
        }
    });

    function updateTotals() {
        let total = 0;
        tbody.querySelectorAll("tr").forEach(tr => {
            const qty = parseFloat(tr.querySelector(".qty").value) || 0;
            const price = parseFloat(tr.querySelector(".price").value) || 0;
            const subtotal = qty * price;
            tr.querySelector(".subtotal").textContent = subtotal.toLocaleString();
            total += subtotal;
        });
        totalDisplay.textContent = total.toLocaleString();
    }
});
</script>
@endsection
