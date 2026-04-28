<?php

namespace App\Imports;

use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuppliersImport implements ToCollection, WithHeadingRow
{
    private array $errors=[];
    private int $importedCount = 0; 
    /**
    * @param Collection $collection
    */
    
    public function collection(Collection $rows)
    {
        foreach($rows as $index => $row){
            $data=$row->toArray();
            // dd($row);
            $validator= Validator::make($data,[
            'identity_id' =>'required|string|max:255',
            'document_number'=> 'required|string|max:255|unique:suppliers,document_number',
            'name'=> 'required|string|max:255',
            'address'=> 'nullable|string|max:255',
            'email' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            ]);

            if($validator->fails()){
                $this->errors[]=[
                    'row'=>$index+1,
                    'errors'=>$validator->errors()->all(),
                ];
                continue;
            }
            
            Supplier::create($data);
            $this->importedCount++;
        }
    }

    public function getErrors(){
        return $this->errors;
    }

    public function getImportedCount(){
        return $this->importedCount;
    }
}
