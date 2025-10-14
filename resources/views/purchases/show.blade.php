@extends('layouts.app')

@section('content')
<h2 class="mb-4">🧾 Detalle de Compra #{{ $purchase->id }}</h2>

<p><strong>Proveedor:</strong> {{ $purchase->supplier->name ?? 'N/A' }}</p>
<p><strong>Fecha:</strong> {{ $purchase->date?->format('d/m/Y H:i') }}</p>
<p><strong>Total:</strong> {{ number_format($purchase->total, 0, ',', '.') }} Gs</p>

<hr>
<h5>Productos</h5>
<table class="table table-bordered">
    <thead>
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
            <td>{{ number_format($detail->unit_price, 0, ',', '.') }} Gs</td>
            <td>{{ number_format($detail->subtotal, 0, ',', '.') }} Gs</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('purchases.index') }}" class="btn btn-secondary">← Volver</a>
@endsection
