<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            [
                'Producto de ejemplo',
                'Descripcion del prodcuto de ejemplo',
                'SKU12345',
                '10.99',
                '1'
            ]
        ];
    }

    public function headings(): array
    {
        // return [
        //     [
        //         'Nombre del producto',
        //         'Descripcion',
        //         'SKU',
        //         'Precio',
        //         'Categoria ID'
        //     ]
        // ];

        return [
            [
                'name',
                'description',
                'SKU',
                'price',
                'category_id'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
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

            'A1:E2' =>[
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

    public function registerEvents(): array
    {
        return [    
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getDelegate()->setSelectedCell('A1');
            }
        ];
    }
}
