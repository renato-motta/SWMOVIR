<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

use App\Models\Product;
use App\Models\Inventory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class ProductTable extends DataTableComponent
{
    // Consulta del DataTable
    public function builder(): Builder
    {
        return Product::query()
            ->with(['category', 'images']);
    }

    // Propiedades Livewire
    public $inventories;
    public $stock = 0;
    public $openModal = false;

    public function mount()
    {
        $this->inventories = collect(); // inicializar siempre
    }

    // Configuración del DataTable
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');

        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.products.modal', // tu modal blade
            ],
        ]);
    }

    // Columnas del DataTable
    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),

            ImageColumn::make('Imagen')
                ->location(fn($row) => $row->image)
                ->attributes(fn($row) => [
                    'class' => 'image-product',
                ]),

            Column::make("Nombre", "name")->searchable()->sortable(),

            Column::make("Categoría", "category.name")->searchable()->sortable(),

            Column::make("Precio", "price")->sortable(),

            // Column::make("Stock", "stock")
            //     ->sortable()
            //     ->format(function($value, $row){
            //         return view('admin.products.stock', [
            //             'stock' => $value,
            //             'product' => $row
            //         ]);
            //     }),

            Column::make("Stock")->sortable()->format(function($value, $row){
            
            // Calcular stock real sumando los últimos registros de inventarios por almacén
            $latestInventories = Inventory::where('product_id', $row->id)
                ->select(DB::raw('MAX(id) as id'), 'warehouse_id')
                ->groupBy('warehouse_id')
                ->pluck('id');

            $stockTotal = Inventory::whereIn('id', $latestInventories)
                ->sum('quantity_balance');

            // Renderizar el botón con Livewire para abrir modal
                return view('admin.products.stock', [
                    'stock' => $stockTotal,
                    'product' => $row
                ]);
            }),


            Column::make("Acciones")->label(fn($row) => view('admin.products.actions', ['product'=>$row])),
        ];
    }

    //en este metodo vamos a definir acciones masivas que queremos que se realizen con los elementos de la datatable
    public function bulkActions(): array 
    {
        return [
            'exportSelected' => 'Exportar',
        ];
    }

    public function exportSelected()
    {
        $selected = $this->getSelected();

        $products= count($selected)
            ? Product::whereIn('id', $selected)->get()
            : Product::all();

        // dd($products->toArray());

        return Excel::download(new \App\Exports\ProductsExport($products),'products.xlsx');

    }

    // Método para abrir modal y cargar inventario
    public function showStock($productId)
    {
        $this->openModal = true;

        // Obtener último registro por cada almacén
        $latestInventories = Inventory::where('product_id', $productId)
            ->select(DB::raw('MAX(id) as id'), 'warehouse_id')
            ->groupBy('warehouse_id')
            ->pluck('id');

        // Cargar inventarios con relación a almacén
        $this->inventories = Inventory::whereIn('id', $latestInventories)
            ->with('warehouse')
            ->get() ?? collect(); // asegurar que sea colección

        // Calcular stock total
        $this->stock = $this->inventories->sum(fn($inv) => $inv->quantity_balance ?? 0);
    }
}
