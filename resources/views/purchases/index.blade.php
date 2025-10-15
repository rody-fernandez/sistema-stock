@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📦 Compras Registradas</h2>
    <a href="{{ route('purchases.create') }}" class="btn btn-primary">+ Nueva Compra</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse($purchases as $purchase)
        <tr>
            <td>{{ $purchase->id }}</td>
            <td>{{ $purchase->supplier->name ?? '-' }}</td>
            <td>{{ $purchase->user->name ?? '-' }}</td>
            <td>{{ $purchase->date?->format('d/m/Y H:i') }}</td>
            <td>{{ number_format($purchase->total, 0, ',', '.') }} Gs</td>
            <td>
                <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-outline-info">Ver</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted">Sin compras registradas</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $purchases->links() }}
</div>
@endsection
