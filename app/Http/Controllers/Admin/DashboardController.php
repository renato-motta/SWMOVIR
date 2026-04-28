<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now();
        $anioActual = $hoy->year;
        $mesActual = $hoy->month;

        /* === TARJETAS === */

        // Ventas del mes
        $ventasMes = Sale::whereYear('date', $anioActual)
            ->whereMonth('date', $mesActual)
            ->sum('total') ?? 0;

        // Compras del mes
        $comprasMes = Purchase::whereYear('date', $anioActual)
            ->whereMonth('date', $mesActual)
            ->sum('total') ?? 0;

        // Total productos
        $totalProductos = Product::count() ?? 0;

        // Stock total REAL (último registro por producto)
        $ultimosInventarios = Inventory::select(DB::raw('MAX(id) as id'))
            ->groupBy('product_id')
            ->pluck('id');

        $stockTotal = Inventory::whereIn('id', $ultimosInventarios)
            ->sum('quantity_balance') ?? 0;

        /* === VENTAS POR MES (últimos 12 meses) === */
        $ventasPorMes = Sale::select(
            DB::raw('YEAR(date) as anio'),
            DB::raw('MONTH(date) as mes'),
            DB::raw('SUM(total) as total')
        )
        ->where('date', '>=', Carbon::now()->subMonths(11)->startOfMonth())
        ->groupBy('anio','mes')
        ->orderBy('anio')
        ->orderBy('mes')
        ->get();

        // Labels: nombres de meses en español
        $labelsVentas = $ventasPorMes->map(fn($v) =>
            ucfirst(Carbon::create()->year($v->anio)->month($v->mes)->locale('es')->monthName)
        );
        $dataVentas = $ventasPorMes->pluck('total');

        /* === TOP 5 PRODUCTOS MÁS VENDIDOS === */
        $topProductos = DB::table('productables')
            ->join('products', 'productables.product_id', '=', 'products.id')
            ->where('productable_type', Sale::class)
            ->select('products.name', 'productables.product_id', DB::raw('SUM(quantity) as cantidad'))
            ->groupBy('products.name', 'productables.product_id')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        $labelsProductos = $topProductos->pluck('name');
        $dataProductos = $topProductos->pluck('cantidad');

        /* === STOCK POR ALMACÉN === */
        $stockAlmacen = Warehouse::all()->map(function ($almacen) {
            $ultimos = Inventory::select(DB::raw('MAX(id) as id'))
                ->where('warehouse_id', $almacen->id)
                ->groupBy('product_id')
                ->pluck('id');

            $total = Inventory::whereIn('id', $ultimos)
                ->sum('quantity_balance') ?? 0;

            return (object)[
                'name' => $almacen->name,
                'total_stock' => $total
            ];
        });

        $labelsAlmacen = $stockAlmacen->pluck('name');
        $dataAlmacen = $stockAlmacen->pluck('total_stock');

        /* === DEVOLVER VISTA === */
        return view('admin.dashboard', compact(
            'ventasMes','comprasMes','totalProductos','stockTotal',
            'labelsVentas','dataVentas',
            'labelsProductos','dataProductos',
            'labelsAlmacen','dataAlmacen'
        ));
    }
}
