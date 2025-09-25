@extends('layouts.app')

@section('content')
<div class="p-6">
  <h1 class="text-2xl font-bold">Panel de Usuario</h1>
  <p class="mt-2">Hola, {{ auth()->user()->name }}</p>
</div>
@endsection
