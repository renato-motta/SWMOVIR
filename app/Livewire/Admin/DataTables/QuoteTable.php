<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;


class QuoteTable extends DataTableComponent
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
                ->sortable(),

            Column::make("Num doc", "customer.document_number")
                ->searchable()
                ->sortable(),

            Column::make("Razón Social", "customer.name")
                ->searchable()
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ '.number_format($value,2,'.',',')),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.quotes.actions', ['quote'=>$row]);
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

        $quotes= count($selected)
            ? Quote::whereIn('id', $selected)->with(['customer.identity'])->get()
            : Quote::with(['customer.identity'])->get();
        // dd($products->toArray());

        return Excel::download(new \App\Exports\QuotesExport($quotes),'quotes.xlsx');
    }

    public function builder(): Builder
    {
        return Quote::query()
        ->with(['customer']);
    }

      //propiedades
    public $form = [
        'open'=>false,
        'document'=>'',
        'client'=>'',
        'email'=>'',
        'model' => null,
        'view_pdf_patch'=> 'admin.quotes.pdf',
    ];

    //Metodo

    public function openModal(Quote $quote){
        // dd($sale);
        // dd($sale->toArray());
        $this->form['open']=true;
        $this->form['document']= 'Cotización '.$quote->serie.'-'.$quote->correlative;
        $this->form['client']=$quote->customer->document_number.' - '.$quote->customer->name;
        $this->form['email']=$quote->customer->email;
        $this->form['model']=$quote;
    
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
