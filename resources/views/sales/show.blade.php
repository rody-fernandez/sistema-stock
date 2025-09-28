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
                    <p>{{ $sale->customer->name }}</p>
                    <p class="mb-0"><small>Email: {{ $sale->customer->email ?? 'N/A' }}</small></p>
                    <p><small>Tel: {{ $sale->customer->phone ?? 'N/A' }}</small></p>
                </div>
                <div class="col-md-6 text-end">
                    <h6 class="fw-bold">Fecha de venta</h6>
