<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;


class SaleTable extends DataTableComponent
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
            
            Column::make("Serie", "serie")
                ->searchable()
                ->sortable(),
            
            Column::make("Correlativo", "correlative")
                ->searchable()
                ->sortable(),

            Column::make("Num Docu", "customer.document_number")
                ->searchable()
                ->sortable(),

            Column::make("Razón Social", "customer.name")
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ '.number_format($value,2,'.',',')),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.sales.actions', ['sale'=>$row]);
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

        $sales= count($selected)
            ? Sale::whereIn('id', $selected)->with(['customer.identity'])->get()
            : Sale::with(['customer.identity'])->get();
        // dd($products->toArray());

        return Excel::download(new \App\Exports\SalesExport($sales),'sales.xlsx');
    }

    public function builder(): Builder
    {
        return Sale::query()
        ->with(['customer']);
    }

    //propiedades
    public $form = [
        'open'=>false,
        'document'=>'',
        'client'=>'',
        'email'=>'',
        'model' => null,
        'view_pdf_patch'=> 'admin.sales.pdf',
    ];

    //Metodo

    public function openModal(Sale $sale){
        // dd($sale);
        // dd($sale->toArray());
        $this->form['open']=true;
        $this->form['document']= 'Venta '.$sale->serie.'-'.$sale->correlative;
        $this->form['client']=$sale->customer->document_number.' - '.$sale->customer->name;
        $this->form['email']=$sale->customer->email;
        $this->form['model']=$sale;
    
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
