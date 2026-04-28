<!DOCTYPE html>
<html lang="es" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick Store — Sistema de Inventario</title>

    @vite('resources/css/app.css')

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#0e0e0e] text-white">

    <!-- NAV -->
    <header class="w-full py-6">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="text-xl font-semibold">Rick Store</div>

            <nav class="space-x-6 text-sm">
                <a href="{{ route('login') }}" class="text-white/80 hover:text-white">Log in</a>
                <a href="{{ route('register') }}" class="text-white/80 hover:text-white">Register</a>
            </nav>
        </div>
    </header>

    <!-- HERO MAIN -->
    <section class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <!-- TEXT LEFT -->
        <div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                Sistema Web para Optimizar<br>
                las Ventas y la Gestión de<br>
                Inventario de Relojes
            </h1>

            <p class="mt-6 text-lg text-white/80 max-w-xl">
                Administra tus productos, controla el inventario en tiempo real,
                visualiza reportes de ventas y mejora la gestión de tu tienda de relojes.
            </p>

            <a href="{{ route('login') }}"
                class="inline-block mt-8 bg-white text-gray-900 font-semibold px-6 py-3 rounded-md shadow hover:brightness-95 transition">
                Iniciar sesión
            </a>

            <ul class="mt-10 space-y-4 text-white/80">
                <li class="flex gap-3">✔ Control de inventario en tiempo real</li>
                <li class="flex gap-3">✔ Gestión de ventas y compras</li>
                <li class="flex gap-3">✔ Administración de productos</li>
                <li class="flex gap-3">✔ Reportes y estadísticas</li>
                <li class="flex gap-3">✔ Multi-almacén</li>
            </ul>

            <p class="mt-12 text-sm text-white/60">
                Rick Store © {{ date('Y') }} — Sistema de Inventario y Ventas
            </p>
        </div>

        <!-- RIGHT — IMAGE -->
        <div class="relative flex justify-center items-center">

            <!-- Fondo del dashboard difuminado -->
            <img src="{{ asset('storage/images/logo.jpg') }}"
                 class="absolute w-[80%] max-w-xl opacity-20 blur-sm pointer-events-none" />

            <!-- Imagen principal del reloj -->
            <img src="{{ asset('storage/images/logo.jpg') }}"
                 class="relative float w-[420px] max-w-[60vw] drop-shadow-2xl" />

        </div>

    </section>

</body>
</html>
