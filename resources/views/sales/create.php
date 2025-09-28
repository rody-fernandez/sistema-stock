@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">🛒 Registrar nueva venta</h3>
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

            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                <!-- Cliente -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Cliente</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Seleccione un cliente...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Productos -->
                <h5 class="fw-bold mb-3">Productos</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="products-table">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
