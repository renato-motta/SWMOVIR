<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfSuppliers extends Component
{
    use WithFileUploads;

    public $file;
    public $errors=[];
    public $importedCount = 0;

    public function downloadTemplate(){
        return Excel::download(new \App\Exports\SuppliersTemplateExport(),'suppliers_template.xlsx');
    }

    public function importSuppliers(){
        $this->validate([
            'file'=> 'required|file|mimes:xlsx,csv',
        ]);

        $categoriesImport = new \App\Imports\SuppliersImport();

        Excel::import($categoriesImport, $this->file);

        $this->errors=$categoriesImport->getErrors();
        $this->importedCount=$categoriesImport->getImportedCount();

        if(count($this->errors) == 0){
            session()->flash('swal',[
                'icon' => 'success',
                'title' => 'Importacion Exitosa',
                'text' => "Se han importado {$this->importedCount} proveedores.",
            ]);

            return redirect()->route('admin.suppliers.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.import-of-suppliers');
    }
}
