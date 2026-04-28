<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const newTheme = html.getAttribute("data-theme") === "dark" ? "light" : "dark";
            html.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const saved = localStorage.getItem("theme");
            if (saved) document.documentElement.setAttribute("data-theme", saved);
        });
    </script>

    <style>
        /* ------------------------------------
           THEMES
        ------------------------------------ */
        [data-theme="dark"] {
            --bg: #0d0d0d;
            --text: #ffffff;
            --text-secondary: #c3c3c3;
            --glass-bg: rgba(255, 255, 255, 0.06);
            --border: rgba(255,255,255,0.15);
        }

        [data-theme="light"] {
            --bg: #f3f3f3;
            --text: #111;
            --text-secondary: #444;
            --glass-bg: rgba(255,255,255,0.65);
            --border: rgba(0,0,0,0.1);
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--bg);
            color: var(--text);
            height: 100vh;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
        }

        /* ------------------------------------
           NAVBAR SUPERIOR
        ------------------------------------ */
        nav {
            width: 100%;
            padding: 18px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        nav .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
        }

        nav .nav-links a {
            margin-left: 18px;
            font-size: 15px;
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--glass-bg);
            text-decoration: none;
            color: var(--text);
            transition: 0.2s;
        }

        nav .nav-links a:hover {
            filter: brightness(1.15);
        }

        /* ------------------------------------
           TOGGLE THEME
        ------------------------------------ */
        .theme-btn {
            margin-left: 12px;
            padding: 8px 14px;
            border-radius: 8px;
            background: var(--glass-bg);
            border: 1px solid var(--border);
            cursor: pointer;
        }

        /* ------------------------------------
           MAIN
        ------------------------------------ */
        .main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .glass-card {
            width: 420px;
            padding: 35px;
            background: var(--glass-bg);
            border-radius: 22px;
            border: 1px solid var(--border);
            backdrop-filter: blur(18px);
            text-align: center;
            box-shadow: 0 0 35px rgba(0,0,0,0.25);
        }

        .logo-img {
            width: 90%;
            display: block;
            margin: 0 auto 22px auto;
            object-fit: contain;
            border-radius: 12px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0071ff, #005ad1);
            color: #fff;
            padding: 13px 26px;
            border-radius: 10px;
            display: inline-block;
            font-weight: 600;
            margin-top: 18px;
            transition: 0.25s;
            text-decoration: none;
        }

        .btn-primary:hover {
            filter: brightness(1.12);
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            color: var(--text-secondary);
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav>
        <div class="brand">
            <span>🕒</span> {{ config('app.name', 'Laravel') }}
        </div>

        <div class="nav-links">
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
            <button onclick="toggleTheme()" class="theme-btn">🌓</button>
        </div>
    </nav>

    <!-- MAIN CARD -->
    <div class="main">
        <div class="glass-card">
            <img src="{{ asset('storage/images/logo.jpg') }}" class="logo-img" alt="Rick Store Logo">

            <h1 class="text-3xl font-bold mb-2">Rick Store</h1>

            <p class="text-[var(--text-secondary)] leading-relaxed">
                Sistema Web para la Gestión Optimizada de Inventario y Ventas.
                Diseño moderno, profesional y orientado a toma de decisiones.
            </p>

            {{-- <a href="{{ route('login') }}" class="btn-primary">Ingresar al sistema</a> --}}
        </div>
    </div>

    <footer>
        © {{ date('Y') }} {{ config('app.name', 'Laravel') }}
    </footer>

</body>
</html>
