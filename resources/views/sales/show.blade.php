@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">🧾 Detalle de Venta #{{ $sale->id }}</h3>
            <a href="{{ route('sales.index') }}" class="btn btn-light btn-sm">⬅ Volver</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold">Cliente</h5>
                    <p class="mb-1">{{ $sale->customer->name ?? 'Sin cliente asignado' }}</p>
                    <p class="mb-1"><small>Email: {{ $sale->customer->email ?? 'N/A' }}</small></p>
                    <p class="mb-0"><small>Tel: {{ $sale->customer->phone ?? 'N/A' }}</small></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="fw-bold">Fecha de venta</h6>
                    <p>{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                    <h5 class="text-success">Total: {{ number_format($sale->total, 0, ',', '.') }} Gs</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-end">Cantidad</th>
                            <th class="text-end">Precio</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sale->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Producto eliminado' }}</td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} Gs</td>
                                <td class="text-end">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} Gs</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No se registraron productos en esta venta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
