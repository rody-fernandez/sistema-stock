@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Mi perfil</h1>

    @if (session('status'))
        <div class="mb-4 text-green-600">{{ session('status') }}</div>
    @endif

    <div class="space-y-4">
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            {{-- Campos a futuro --}}
            <button class="btn btn-primary">Guardar (stub)</button>
        </form>
    </div>
</div>
@endsection
