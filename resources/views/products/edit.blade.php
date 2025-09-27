@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>
    <form action="{{ route('products.update',$product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('products.partials.form')
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
