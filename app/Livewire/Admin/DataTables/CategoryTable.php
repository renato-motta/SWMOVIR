<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Category;

use Maatwebsite\Excel\Facades\Excel;

class CategoryTable extends DataTableComponent
{
    protected $model = Category::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),

            Column::make("Descripcion", "description")
                ->searchable()
                ->sortable(),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.categories.actions', ['category'=>$row]);
                })    
            
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
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

        $categories= count($selected)
            ? Category::whereIn('id', $selected)->get()
            : Category::all();

        // dd($products->toArray());

        return Excel::download(new \App\Exports\CategoriesExport($categories),'products.xlsx');

    }
}
