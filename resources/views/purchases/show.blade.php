@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📦 Detalle de Compra #{{ $purchase->id }}</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Proveedor:</strong> {{ $purchase->supplier->name ?? 'N/A' }}</p>
            <p><strong>Usuario:</strong> {{ $purchase->user->name ?? 'N/A' }}</p>
            <p><strong>Fecha:</strong> {{ $purchase->date->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> {{ number_format($purchase->total, 0, ',', '.') }} Gs</p>
        </div>
    </div>

    <h4>🧾 Detalles</h4>
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                    <td>{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-end">
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">⬅ Volver</a>
    </div>
</div>
@endsection
