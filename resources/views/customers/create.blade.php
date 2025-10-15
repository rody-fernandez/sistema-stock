@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Nuevo Cliente</h2>
        <a href="{{ route('customers.index') }}" class="btn btn-link">← Volver al listado</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Revisa los datos ingresados.
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST" class="card shadow-sm">
        @csrf
        <div class="card-body">
            @include('customers.form')
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar cliente</button>
        </div>
    </form>
</div>
@endsection
