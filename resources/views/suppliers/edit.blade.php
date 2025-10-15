@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Editar proveedor</h2>
        <a href="{{ route('suppliers.index') }}" class="btn btn-link">← Volver al listado</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Revisa los datos ingresados.
        </div>
    @endif

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('suppliers.form', ['supplier' => $supplier])
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar proveedor</button>
        </div>
    </form>
</div>
@endsection
