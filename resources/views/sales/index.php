@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ventas</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Cliente</th><th>Total</th><th>Fecha</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->customer->name }}</td>
                <td>{{ $sale->total }}</td>
                <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                <td><a href="{{ route('sales.show',$sale) }}" class="btn btn-info btn-sm">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sales->links() }}
</div>
@endsection
