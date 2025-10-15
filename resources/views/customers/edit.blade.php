@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Editar Cliente</h2>
        <a href="{{ route('customers.index') }}" class="btn btn-link">← Volver al listado</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Revisa los datos ingresados.
        </div>
    @endif

    <form action="{{ route('customers.update', $customer) }}" method="POST" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('customers.form', ['customer' => $customer])
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar cliente</button>
        </div>
    </form>
</div>
@endsection
