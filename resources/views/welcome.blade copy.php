<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick Store</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- BODY CON MODO DARK/LIGHT -->
<body class="bg-white text-black dark:bg-black dark:text-white font-sans transition-colors duration-300">

    <!-- NAV -->
    <header class="w-full flex justify-between items-center px-16 py-10">
        <h1 class="text-xl font-semibold">Rick Store</h1>

        <nav class="flex items-center gap-8 text-sm">

            <!-- TOGGLE DARK MODE -->
            <button id="theme-toggle"
                class="text-2xl hover:scale-110 transition-transform duration-200">
                🌙
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="hover:underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hover:underline">Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <!-- HERO -->
    <section class="w-full flex flex-col lg:flex-row justify-between items-center px-16 py-20 gap-20">

        <!-- TEXT -->
        <div class="max-w-xl">
            <h2 class="text-5xl font-bold leading-tight mb-6">
                Sistema Web para Optimizar<br>
                las Ventas y la Gestión de<br>
                Inventario de Relojes
            </h2>

            <p class="text-gray-700 dark:text-gray-300 mb-10 transition-colors">
                Administra tus productos, controla el inventario en tiempo real,
                visualiza reportes de ventas y mejora la gestión de tu tienda de relojes.
            </p>

            <!-- BOTÓN ADAPTADO A DARK/LIGHT -->
            <a href="{{ route('login') }}"
               class="px-7 py-3 rounded-md font-medium text-base inline-block 
                      bg-black text-white dark:bg-gray-100 dark:text-black
                      hover:bg-gray-900 dark:hover:bg-white transition-colors">
                Iniciar sesión
            </a>

            <ul class="mt-12 space-y-4 text-gray-700 dark:text-gray-300 text-base transition-colors">
                <li class="flex items-center gap-3">✔ Control de inventario en tiempo real</li>
                <li class="flex items-center gap-3">✔ Gestión de ventas y compras</li>
                <li class="flex items-center gap-3">✔ Administración de productos</li>
                <li class="flex items-center gap-3">✔ Reportes y estadísticas</li>
                <li class="flex items-center gap-3">✔ Multi-almacén</li>
            </ul>
        </div>

        <!-- IMÁGENES -->
        <div class="relative w-[600px] h-[500px]">

            <!-- DASHBOARD DARK -->
            <img src="{{ asset('storage/images/DASHB.jpg') }}"
                 class="absolute top-12 right-0 w-[520px] opacity-50 dark:block hidden"
                 alt="Dashboard">

            <!-- DASHBOARD LIGHT (opcional si tienes otra imagen) -->
            <img src="{{ asset('storage/images/DASHB.jpg') }}"
                 class="absolute top-12 right-0 w-[520px] opacity-70 block dark:hidden"
                 alt="Dashboard Light">

            <!-- RELOJ ADELANTE -->
            <img src="{{ asset('storage/images/RELOJ.PNG') }}"
                 class="absolute top-0 left-10 w-[330px] z-10 drop-shadow-2xl"
                 alt="Reloj">
        </div>

    </section>

    <!-- FOOTER -->
    <footer class="text-center text-gray-600 dark:text-gray-400 text-xs py-12 transition-colors">
        Rick Store © 2025 — Sistema de Inventario y Ventas
    </footer>


    <!-- SCRIPT DARK/LIGHT MODE -->
    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('theme-toggle');

        // Cargar preferencia guardada
        if (localStorage.theme === 'dark') {
            html.classList.add('dark');
            toggleBtn.textContent = '☀️';
        } else {
            toggleBtn.textContent = '🌙';
        }

        toggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark');

            if (html.classList.contains('dark')) {
                localStorage.theme = 'dark';
                toggleBtn.textContent = '☀️';
            } else {
                localStorage.theme = 'light';
                toggleBtn.textContent = '🌙';
            }
        });
    </script>

</body>
</html>
