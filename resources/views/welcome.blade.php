<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Rick Store') }}</title>

    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Archivos CSS/JS específicos para esta vista --}}
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])

</head>

<body>

    {{-- NAV --}}
    <nav>
        <div class="brand">
            {{-- <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg> --}}
            <img src="{{ asset('storage/images/logo.jpg') }}" alt="Logo Rick Store" class="logo-nav" />
            {{ config('app.name', 'Rick Store') }}
        </div>

        <div class="nav-links">
            <button onclick="toggleTheme()" aria-label="Cambiar tema">
                <span id="theme-icon">🌓</span>
            </button>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="main">

        <div class="glass-card">

            <img src="{{ asset('storage/images/logo.jpg') }}" class="logo-img" alt="Logo de Rick Store">

            <h1 class="font-bold">Bienvenido a {{ config('app.name', 'Rick Store') }} 👋</h1>

            <p>
                Optimiza tu inventario y ventas en un solo lugar.<br>
                Gestiona tu negocio de forma eficiente y segura, <br>
                ¡comienza hoy mismo!
            </p>

            <div class="actions">
                <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Registrarse gratis</a>
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <footer>
        © {{ date('Y') }} {{ config('app.name', 'Rick Store') }}. Todos los derechos reservados.
    </footer>

</body>
</html>




