<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Stock</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Control de Stock</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Productos</a></li>
                <li class="nav-item"><a href="{{ route('sales.index') }}" class="nav-link">Ventas</a></li>
                <li class="nav-item"><a href="{{ route('purchases.index') }}" class="nav-link">Compras</a></li>
            </ul>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
