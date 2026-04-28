<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión – {{ config('app.name', 'Rick Store') }}</title>

    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- CSS y JS del welcome --}}
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>

<body>

    {{-- NAV --}}
    <nav>
        <div class="brand">
            <img src="{{ asset('storage/images/logo.jpg') }}" alt="Logo Rick Store" class="logo-nav">
            {{ config('app.name', 'Rick Store') }}
        </div>

        <div class="nav-links">
            <button onclick="toggleTheme()" aria-label="Cambiar tema">
                <span id="theme-icon">🌓</span>
            </button>
        </div>
    </nav>

    {{-- CONTENIDO --}}
    <div class="main">
        <div class="glass-card">

            <img src="{{ asset('storage/images/logo.jpg') }}" class="logo-img" alt="Logo de Rick Store">

            {{-- <h1 class="font-bold text-xl">Iniciar sesión</h1> --}}

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            {{-- Mensaje de estado --}}
            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            {{-- FORMULARIO --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="actions" >

                    {{-- Email --}}
                    <div class="input-group">
                        <input 
                            type="email"
                            name="email"
                            id="email"
                            class="input-field"
                            required
                            autofocus
                            autocomplete="username"
                            value="{{ old('email') }}"
                            placeholder=" "
                        >
                        <label for="email">Correo electrónico</label>
                    </div>

                    {{-- Contraseña --}}
                    <div class="input-group">
                        <input 
                            type="password"
                            name="password"
                            id="password"
                            class="input-field"
                            required
                            autocomplete="current-password"
                            placeholder=" "
                        >
                        <label for="password">Contraseña</label>
                    </div>

                    {{-- Mantener sesión activa --}}
                    <div class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember_me" class="checkbox-pro">
                        Mantener sesión activa
                    </div>

                    {{-- Olvidaste tu contraseña --}}
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-pro">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    {{-- Botón login --}}
                    <button type="submit" class="btn btn-primary-pro" >
                        Iniciar sesión
                    </button>

                    {{-- Crear cuenta --}}
                    <a href="{{ route('register') }}" class="btn btn-secondary-pro">
                        Crear una cuenta
                    </a>

                </div>
            </form>

        </div>
    </div>

    {{-- FOOTER --}}
    <footer>
        © {{ date('Y') }} {{ config('app.name', 'Rick Store') }}. Todos los derechos reservados.
    </footer>

</body>
</html>
