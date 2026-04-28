<x-admin-layout
    title='Dashboard'
    :breadcrumbs="[ 
        [
            'name'=>'Dashboard',
            'href'=> route('admin.dashboard'),                                           
        ],
        [
            'name'=>'Pruebas',
        ]
    ]">

{{-- === TARJETAS === --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- Ventas --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-lg">
                <i class="fa-solid fa-cash-register text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ventas del mes</p>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    S/ {{ number_format($ventasMes ?? 0,2) }}
                </h2>
                @if(($ventasMes ?? 0) == 0)
                    <p class="text-xs text-red-500 mt-1">No hay ventas registradas este mes</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Compras --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-lg">
                <i class="fa-solid fa-cart-shopping text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Compras del mes</p>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    S/ {{ number_format($comprasMes ?? 0,2) }}
                </h2>
                @if(($comprasMes ?? 0) == 0)
                    <p class="text-xs text-red-500 mt-1">No hay compras registradas este mes</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Productos --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 rounded-lg">
                <i class="fa-solid fa-box text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Productos</p>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ $totalProductos ?? 0 }}
                </h2>
                @if(($totalProductos ?? 0) == 0)
                    <p class="text-xs text-red-500 mt-1">No hay productos registrados</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Stock total --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 rounded-lg">
                <i class="fa-solid fa-warehouse text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Stock total</p>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ $stockTotal ?? 0 }}
                </h2>
                @if(($stockTotal ?? 0) == 0)
                    <p class="text-xs text-red-500 mt-1">No hay stock disponible</p>
                @endif
            </div>
        </div>
    </div>

</div>


{{-- === GRÁFICOS === --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Ventas por mes --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800">
        <h3 class="text-lg font-semibold mb-4">Ventas por mes</h3>
        <div class="h-72">
            <canvas id="chartVentas"></canvas>
        </div>
    </div>

    {{-- Top productos --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800">
        <h3 class="text-lg font-semibold mb-4">Top productos</h3>
        <div class="h-72">
            <canvas id="chartProductos"></canvas>
        </div>
    </div>

    {{-- Stock por almacén --}}
    <div class="p-6 bg-white border rounded-xl shadow-md dark:bg-gray-800 col-span-1 lg:col-span-2">
        <h3 class="text-lg font-semibold mb-4">Stock por almacén</h3>
        <div class="h-80">
            <canvas id="chartAlmacen"></canvas>
        </div>
    </div>

</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

    
/* === Ventas por mes === */
new Chart(document.getElementById('chartVentas'), {
    type: 'bar',
    data: {
        labels: @json($labelsVentas ?? []),
        datasets: [{
            label: 'Ventas por mes (S/)',
            data: @json($dataVentas ?? []),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.3)',
            fill: true,
            tension: 0.3
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});

/* === Top productos === */
// new Chart(document.getElementById('chartProductos'), {
//     type: 'bar',
//     data: {
//         labels: @json($labelsProductos ?? []),
//         datasets: [{
//             label: 'Cantidad vendida',
//             data: @json($dataProductos ?? []),
//             backgroundColor: '#10b981'
//         }]
//     },
//     options: { responsive: true, maintainAspectRatio: false }
// });

/* === Top productos (gráfico horizontal) === */
new Chart(document.getElementById('chartProductos'), {
    type: 'bar',
    data: {
        labels: @json($labelsProductos),
        datasets: [{
            label: 'Cantidad vendida',
            data: @json($dataProductos),
            backgroundColor: '#10b981'
        }]
    },
    options: {
        indexAxis: 'y', // hace las barras horizontales
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Cantidad vendida'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Producto'
                },
                ticks: {
                    autoSkip: false, // muestra todas las etiquetas
                    maxRotation: 0,
                    minRotation: 0
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});


/* === Stock por almacén === */
new Chart(document.getElementById('chartAlmacen'), {
    type: 'bar',
    data: {
        labels: @json($labelsAlmacen ?? []),
        datasets: [{
            label: 'Stock',
            data: @json($dataAlmacen ?? []),
            backgroundColor: '#f59e0b'
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});
</script>
@endpush

</x-admin-layout>
