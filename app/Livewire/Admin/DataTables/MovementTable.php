<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Movement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class MovementTable extends DataTableComponent
{
    //protected $model = PurchaseOrder::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id','desc');
        
        // $this->sertAdditionalSelects(['purchase_orders.id']);
        
        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.pdf.modal',
            ],
        ]);
    }

    public function filters(): array{
        return [
            DateRangeFilter::make('Fecha')->config([
                'placeholder' => 'seleccionar rango de fechas'
            ])->filter(function($query, array $dateRange){
                $query->whereBetween('date',[
                    $dateRange['minDate'] ,
                    $dateRange['maxDate']
                ]);
            })
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("Date", "date")
                ->sortable()
                ->format(fn($value) => $value->format('Y-m-d')),

            Column::make("Tipo", "type")
                ->sortable()
                ->format(fn($value) => match ($value) {
                    1 => 'Ingreso',
                    2 => 'Salida',
                    default => 'Desconocido',
                },
            ),
            
            Column::make("Serie", "serie")
                ->searchable()
                ->sortable(),
            
            Column::make("Correlativo", "correlative")
                ->sortable(),

            Column::make("Almacén", "warehouse.name")
                ->searchable()
                ->sortable(),

            Column::make("Motivo", "reason.name")
                ->searchable()
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ '.number_format($value,2,'.',',')),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.movements.actions', ['movement'=>$row]);
                })    
        ];
    }

    public function bulkActions(): array
    {
        return [
            'exportSelected'=> 'Exportar',
        ];
    }

    public function exportSelected()
    {

        $selected = $this->getSelected();

        $movements= count($selected)
            ? Movement::whereIn('id', $selected)->with(['warehouse','reason'])->get()
            : Movement::with(['warehouse','reason'])->get();
        // dd($products->toArray());

        return Excel::download(new \App\Exports\MovementsExport($movements),'movements.xlsx');
    }

    public function builder(): Builder
    {
        return Movement::query()
        ->with(['warehouse','reason', ]);
    }

    //propiedades
    public $form = [
        'open'=>false,
        'document'=>'',
        'client'=>'',
        'email'=>'',
        'model' => null,
        'view_pdf_patch'=> 'admin.movements.pdf',
    ];

    //Metodo

    public function openModal(Movement $movement){
        // dd($movement);
        // dd($movement->toArray());
        $this->form['open']=true;
        $this->form['document']= 'Movimiento '.$movement->serie.'-'.$movement->correlative;
        $this->form['client']=$movement->Warehouse->name;
        $this->form['email']='';
        $this->form['model']=$movement;
    
    }

    public function sendEmail(){

        $this->validate([
            'form.email'=> 'required|email'
        ]);

        //llamar un mailable
        Mail::to($this->form['email'])->send(new \App\Mail\PdfSend($this->form));


        $this->dispatch('swal',[
            'title' => 'Correo enviado',
            'text' => 'El Correo ha sido enviado correctamente',
            'icon' => 'success',
        ]);

        $this->reset('form');
    }
}
