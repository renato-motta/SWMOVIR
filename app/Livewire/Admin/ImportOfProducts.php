<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfProducts extends Component
{
    use WithFileUploads;

    public $file;
    public $errors=[];
    public $importedCount = 0;

    public function render()
    {
        return view('livewire.admin.import-of-products');
    }

    public function downloadTemplate(){
        return Excel::download(new \App\Exports\ProductsTemplateExport(),'products_template.xlsx');
    }

    public function importProducts(){
        $this->validate([
            'file'=> 'required|file|mimes:xlsx,csv',
        ]);

        $productsImport = new \App\Imports\ProductsImport();

        // try{
            Excel::import($productsImport, $this->file);
        //     session()->flash('message','productos importados correctamente');
        // } catch(\Exception $e){
        //     session()->flash('error','Error al importar los productos');
        // }
        // $this->reset('file')

        $this->errors=$productsImport->getErrors();
        $this->importedCount=$productsImport->getImportedCount();

        if(count($this->errors) == 0){
            session()->flash('swal',[
                'icon' => 'success',
                'title' => 'Importacion Exitosa',
                'text' => "Se han importado {$this->importedCount} productos.",
            ]);

            return redirect()->route('admin.products.index');
        }



    }
}
