<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales=$sales;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->sales->map(function ($sale){
            return[
                $sale->id,
                $sale->date,
                $sale->serie,
                $sale->correlative,
                $sale->customer->identity->name,
                $sale->customer->document_number,
                $sale->customer->name,
                $sale->total,
            ];
        });
    }

    public function headings(): array
    {
        return [
            [
                'ID',
                'Fecha',
                'Serie',
                'Correlativo',
                'Proveedor(Identidad)',
                'N° Documento',
                'Nombre del Proveedor',
                'Total',
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

    public function registerEvents(): array
    {
        return [    
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getDelegate()->setSelectedCell('A1');
            }
        ];
    }
}
