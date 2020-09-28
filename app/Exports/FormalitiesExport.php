<?php

namespace App\Exports;

use App\Http\Models\Formalities;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class FormalitiesExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithCustomStartCell,
    ShouldAutoSize
{

    private $data;
    private $totalRecords;
    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Determinante',
            'Clasificación',
            'Sección',
            'Serie',
            'Subserie',
            'Fecha de apertura',
            'Fecha de cierre',
            'Consecutivo',
            'Legajo',
            'Asunto/Título'
        ];
    }

    public function title(): string
    {
        return 'Archivos de trámite';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        $cols = 'A3:J3';
        return [
            AfterSheet::class => function(AfterSheet $event) use ($cols) {
                $event->sheet->setShowGridlines(false);
                $event->sheet->getDelegate()->getSheetView()->setZoomScale(90);

                $event->sheet->mergeCells("A1:J1");
                $event->sheet->setCellValue('A1','LISTA DE EXPEDIENTES');
                $event->sheet->styleCells(
                    'A1:I1',
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'fill' => [
                            'fillType' => static::$FILL::FILL_SOLID,
                        ]
                    ]
                );

                $event->sheet->styleCells(
                    $cols,
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'alignment' => [
                            'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                            'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => static::$FILL::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'FFFFFFFF',
                            ],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    $cols,
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'alignment' => [
                            'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                            'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => static::$FILL::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'FFCCD1D1',
                            ],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A3:J'.$this->totalRecords,
                    [
                        'font' => [
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => static::$BORDER::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ]
                        ]
                    ]
                );

                $event->sheet->autoFilter($cols);

            },
        ];
    }

    public function collection()
    {
        $relations = ['user.determinant', 'section', 'serie', 'subserie'];
        if(auth()->user()->cat_profile_id === 1){
            $formalities = Formalities::with($relations)
                ->search($this->data['filters'])
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $formalities = Formalities::with($relations)
                ->whereUnitId(auth()->user()->cat_unit_id)
                ->search($this->data['filters'])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        $records = $formalities->map(function ($item) {
            ++$this->totalRecords;
            $determinant = '';
            if (isset($item->unit)){
                $determinant .= ' ' . $item->unit->determinant;
            }

            $sort_code = $item->sort_code;

            $section = '';
            if (isset($item->section)){
                $section .= ' ' . $item->section->full_name;
            }

            $serie = '';
            if (isset($item->serie)){
                $serie .= ' ' . $item->serie->full_name;
            }

            $subserie = '';
            if (isset($item->subserie)){
                $subserie .= ' ' . $item->subserie->full_name;
            }

            $openingDate = $item->opening_date;
            $closeDate = $item->close_date;
            $consecutive = $item->consecutive;
            $legajo = $item->legajo;
            $title = $item->title;

            return [
                $determinant,
                $sort_code,
                $section,
                $serie,
                $subserie,
                $openingDate,
                $closeDate,
                $consecutive,
                $legajo,
                $title
            ];
        });
        $this->totalRecords += 3;

        return $records;
    }
}
