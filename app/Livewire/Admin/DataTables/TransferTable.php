<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;


class TransferTable extends DataTableComponent
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

            Column::make("Almacén Origen", "originWarehouse.name")
                ->searchable()
                ->sortable(),

            Column::make("Almacén Destino", "destinationWarehouse.name")
                ->searchable()
                ->sortable(),

            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ '.number_format($value,2,'.',',')),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.transfers.actions', ['transfer'=>$row]);
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

        $transfers= count($selected)
            ? Transfer::whereIn('id', $selected)->with(['originWarehouse','destinationWarehouse'])->get()
            : Transfer::with(['originWarehouse','destinationWarehouse'])->get();
        // dd($products->toArray());

        return Excel::download(new \App\Exports\TransfersExport($transfers),'transfers.xlsx');
    }

    public function builder(): Builder
    {
        return Transfer::query()
        ->with(['originWarehouse','destinationWarehouse', ]);
    }

    //propiedades
    public $form = [
        'open'=>false,
        'document'=>'',
        'client'=>'',
        'email'=>'',
        'model' => null,
        'view_pdf_patch'=> 'admin.transfers.pdf',
    ];

    //Metodo

    public function openModal(Transfer $transfer){
        // dd($transfer);
        // dd($transfer->toArray());
        $this->form['open']=true;
        $this->form['document']= 'Transferencia '.$transfer->serie.'-'.$transfer->correlative;
        $this->form['client']=$transfer->originWarehouse->name.' - '.$transfer->destinationWarehouse->name;
        $this->form['email']='';
        $this->form['model']=$transfer;
    
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
