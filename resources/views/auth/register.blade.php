<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar – {{ config('app.name', 'Rick Store') }}</title>

    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- CSS y JS --}}
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

            {{-- <h1 class="title-pro">Crear cuenta</h1> --}}

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="actions">

                    {{-- Nombre --}}
                    <div class="input-group">
                        <input 
                            type="text"
                            name="name"
                            id="name"
                            class="input-field"
                            value="{{ old('name') }}"
                            required
                            placeholder=" "
                        >
                        <label for="name">Nombre</label>
                    </div>

                    {{-- Email --}}
                    <div class="input-group">
                        <input 
                            type="email"
                            name="email"
                            id="email"
                            class="input-field"
                            value="{{ old('email') }}"
                            required
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
                            placeholder=" "
                        >
                        <label for="password">Contraseña</label>
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="input-group">
                        <input 
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="input-field"
                            required
                            placeholder=" "
                        >
                        <label for="password_confirmation">Confirmar contraseña</label>
                    </div>

                    {{-- Checkbox términos --}}
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="checkbox-container">
                            <input type="checkbox" name="terms" id="terms" class="checkbox-pro" required>
                            Acepto los 
                            <a href="{{ route('terms.show') }}" target="_blank" class="link-pro">Términos de Servicio</a> y 
                            <a href="{{ route('policy.show') }}" target="_blank" class="link-pro">Política de Privacidad</a>
                        </div>
                    @endif

                    {{-- Enlace a login --}}
                    <a href="{{ route('login') }}" class="link-pro">¿Ya tienes cuenta?</a>

                    {{-- Botones --}}
                    <button type="submit" class="btn btn-primary-pro">Registrar</button>
                    {{-- <a href="{{ route('login') }}" class="btn btn-secondary-pro">Iniciar sesión</a> --}}

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
