<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Productable;
use Illuminate\Database\Eloquent\Builder;

class TopProductsTable extends DataTableComponent
{
    public function builder(): Builder{
        return Productable::query()
        ->where('productable_type', 'App\Models\Sale')
        ->join('products', 'productables.product_id', '=', 'products.id')
        ->selectRaw('
            products.id as id,
            products.name as name,
            products.description as description,
            SUM(productables.quantity) as quantity,
            SUM(productables.subtotal) as subtotal    
        ')
        ->groupBy('products.id','products.name','products.description')
        ->orderBy('subtotal','desc');
    }


    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id")
            ->label(function($row){
                return $row->id;
            })
                ->sortable(),

            Column::make("Producto")
            ->label(function($row){
                return $row->product;
            })
                ->sortable(),
        ];
    }
}
