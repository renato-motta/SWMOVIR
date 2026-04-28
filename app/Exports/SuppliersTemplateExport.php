<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    
     public function array(): array
    {
        return [
            [   
                'tipo de documento del proveedor de ejemplo',
                'Numero de documento del proveedor de ejemplo',
                'Nombre del proveedor de ejemplo',
                'Direccion del proveedor de ejemplo',
                'Correo electronico del proveedor de ejemplo',
                'Teléfono del proveedor de ejemplo',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $fullRange = 'A1:'.$lastColumn.$lastRow;

        return [
            1=>[
                'font'=>[
                    'bold'=>true,
                ],
                'fill'=>[
                    'fillType'=> \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor'=>[
                        'argb'=>'FFCCCCCC',
                    ],
                ],
                'alignment'=>[
                    'horizontal'=>\PhpOffice\phpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],

            $fullRange =>[
                'borders' =>[
                    'allBorders'=>[
                        'borderStyle' => \PhpOffice\phpSpreadsheet\Style\Border::BORDER_THIN,
                        'color'=>[
                            'argb'=>'FF000000'
                        ],
                    ],
                ]
            ]
        ];
    }


    public function headings(): array
    {
        return [
            [
                'identity_id',
                'document_number',
                'name',
                'address',
                'email',
                'phone',
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [    
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getDelegate()->setSelectedCell('A1');
            }
        ];
    }
}
