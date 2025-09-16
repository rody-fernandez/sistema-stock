
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    <form action="{{ route('products.update',$product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="code" value="{{ $product->code }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="category_id" class="form-control">
                <option value="">-- Ninguna --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected':'' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Precio Compra</label>
            <input type="number" step="0.01" name="cost_price" value="{{ $product->cost_price }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio Venta</label>
            <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Imagen</label><br>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
