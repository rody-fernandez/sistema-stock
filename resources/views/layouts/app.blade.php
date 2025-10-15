<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Sistema Stock') }}</title>

  {{-- Bootstrap por CDN (parche rápido) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="{{ route('dashboard') }}">Control de Stock</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          @auth
            @if(auth()->user()->isAdmin())
              <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Productos</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('purchases.index') }}">Compras</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}">Ventas</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('customers.index') }}">Clientes</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('suppliers.index') }}">Proveedores</a></li>
            @endif
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn btn-link nav-link">Salir</button>
              </form>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <main class="container">@yield('content')</main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
