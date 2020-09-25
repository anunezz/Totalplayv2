<?php

namespace App\Exports;

use App\Http\Models\SICAR\FormalitiesSicar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;


use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use function foo\func;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class FormalitiesSicarExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithCustomStartCell
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
            'subserie',
            'Número de expediente',
            'Año',
            'Fecha de apertura',
            'Creado por',
        ];
    }

    public function title(): string
    {
        return 'Archivos de trámite historicos' . $this->totalRecords;
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function registerEvents(): array
{
    $cols = 'A6:I6';
    return [
        AfterSheet::class => function(AfterSheet $event) use ($cols) {
            $event->sheet->setShowGridlines(false);
            $event->sheet->getDelegate()->getSheetView()->setZoomScale(90);

            $event->sheet->mergeCells("E1:AB1");
            $event->sheet->setCellValue('E1','REGISTROS HISTORICOS');

            /*$event->sheet->mergeCells("A2:F4");
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo');
            $drawing->setResizeProportional(false);
            $drawing->setWidth(379);
            $drawing->setHeight(49);
            $drawing->setOffsetX(13);
            $drawing->setOffsetY(7);
            $drawing->setPath(public_path('/img/RelacionesExterioresExcelEtqueta.png'));
            $drawing->setCoordinates('A2');
            $drawing->setWorksheet($event->sheet->getDelegate());*/


            $event->sheet->styleCells(
                $cols,
                [
                    'font' => [
                        'bold' => true,
                        'name' =>  'Montserrat',
                        'size' =>  13
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
                        'size' =>  13
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
                'A6:I'.$this->totalRecords,
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
        $formalities = [];
        if(auth()->user()->cat_profile_id === 1){
            $formalities = FormalitiesSicar::orderBy('created_at', 'DESC')
                ->search($this->data['filters'])
                ->get();

        }else if (!is_null(auth()->user()->cat_unit_id)){
            $formalities = FormalitiesSicar::orderBy('created_at', 'DESC')
                ->where('key_units',auth()->user()->determinant->determinant)
                ->search($this->data['filters'])
                ->get();
        }

        $records = $formalities->map(function ($item) {
            ++$this->totalRecords;
            $determinant = $item->key_units;
            $classification = $item->i_topograf;
            $section = $item->key_section;

            if (isset($item->section)){
                $section .= ' ' . $item->section->name;
            }
            $serie = $item->key_serie;
            if (isset($item->serie)){
                $serie .= ' ' . $item->serie->name;
            }

            $subserie = $item->key_subserie;
            if (isset($item->subserie)){
                $subserie .= ' '. $item->subserie->name;
            }

            $fileNumber = $item->case_file;
            $date = $item->date;
            $openDate = $item->open;
            $creator = '';
            if (isset($item->user)){
                $creator .= $item->user->name;
            }

            return [$determinant,$classification,$section,$serie,$subserie,$fileNumber,$date,$openDate,$creator];
        });
        ++$this->totalRecords;

        return $records;
    }
}
