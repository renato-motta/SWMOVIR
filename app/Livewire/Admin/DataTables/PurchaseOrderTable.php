<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;


class PurchaseOrderTable extends DataTableComponent
{
    //protected $model = PurchaseOrder::class;

    public function builder(): Builder
    {
        return PurchaseOrder::query()
        ->with(['supplier']);
    }

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
            
            Column::make("Serie", "serie")
                ->searchable()
                ->sortable(),
            
            Column::make("Correlativo", "correlative")
                ->searchable()
                ->sortable(),

            Column::make("Num Doc", "supplier.document_number")
                ->searchable()    
                ->sortable(),

            Column::make("Razón Social", "supplier.name")
                ->searchable()    
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ '.number_format($value,2,'.',',')),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.purchase_orders.actions', ['purchaseOrder'=>$row]);
                })    
        ];
    }

    public function bulkActions(): array
    {
        return [
            'exportSelected'=> 'Exportar',
        ];
    }

    public function exportSelected(){

        $selected = $this->getSelected();

        $purchaseOrders= count($selected)
            ? PurchaseOrder::whereIn('id', $selected)->with(['supplier.identity'])->get()
            : PurchaseOrder::with(['supplier.identity'])->get();
        // dd($products->toArray());

        return Excel::download(new \App\Exports\PurchaseOrdersExport($purchaseOrders),'purchaseOrders.xlsx');
    }


     //propiedades
    public $form = [
        'open'=>false,
        'document'=>'',
        'client'=>'',
        'email'=>'',
        'model' => null,
        'view_pdf_patch'=> 'admin.purchase_orders.pdf',
    ];

    //Metodo

    public function openModal(PurchaseOrder $purchaseOrder){
        // dd($purchase->toArray());
        $this->form['open']=true;
        $this->form['document']= 'Orden de Compra '.$purchaseOrder->serie.'-'.$purchaseOrder->correlative;
        $this->form['client']=$purchaseOrder->supplier->document_number.'-'.$purchaseOrder->supplier->name;
        $this->form['email']=$purchaseOrder->supplier->email;
        $this->form['model']=$purchaseOrder;
    
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
