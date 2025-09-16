@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Producto</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="category_id" class="form-control">
                <option value="">-- Ninguna --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Precio Compra</label>
            <input type="number" step="0.01" name="cost_price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio Venta</label>
            <input type="number" step="0.01" name="sale_price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
