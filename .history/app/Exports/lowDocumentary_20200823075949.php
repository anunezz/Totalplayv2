<?php

namespace App\Exports;

use App\DataForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use function foo\func;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);


class lowDocumentary implements
    FromCollection,
    ShouldAutoSize,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithStrictNullComparison
{

    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    public function __construct($headers, $fields)
    {
        $this->headers = $headers;
        $this->fields = $fields;
    }

    public function headings(): array
    {

        return $this->headers;
    }

    public function title(): string
    {
        return 'Baja documental';
    }

    public function style($sheet,$array){
        $style = [];
        //[ 'cell'=> 'A8:A9', merge=> true, 'border'=> 'setAllBorders','field'=>'No. conse-cutivo'],

        if( isset( $array['border'] ) ){
            $sheet->styleCells(
                $array['cell'],
                [
                    'font' => [
                        'bold' => true,
                        'name' => 'Calibri',
                        'size' => 11
                    ],
                    'alignment' => [
                        'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                        'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        $array['border'] => [
                            'borderStyle' => static::$BORDER::BORDER_THICK,
                            'color' => ['argb' => 'FF000000'],
                        ]
                    ]
                ]
            );
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setShowGridlines(false);  //este donde limpia e excel las celdad

                $event->sheet->mergeCells("A1:P1");
                $event->sheet->setCellValue('A1','Unidad administrativa:');
                $event->sheet->mergeCells("A2:P2");
                $event->sheet->setCellValue('A2','Área productora:');
                $event->sheet->mergeCells("A3:P3");
                $event->sheet->setCellValue('A3','Fondo: SRE Secretaría de Relaciones Exteriores');
                $event->sheet->mergeCells("A4:P4");
                $event->sheet->setCellValue('A4','Sección documental:');
                $event->sheet->mergeCells("A5:P5");
                $event->sheet->setCellValue('A5','Serie documental: ');
                $event->sheet->mergeCells("A6:P6");
                $event->sheet->setCellValue('A6','Subserie documental:');



                $rowsBorder = [
                    [ 'cell'=> 'A8:A9', merge=> true, 'border'=> 'setAllBorders','field'=>'No. conse-cutivo'],
                    ];

                    foreach ($rowsBorder as $e){
                        $this->style($event->sheet ,$e);
                    }




            },
        ];
    }

    public function collection()
    {
        try {

            return collect();

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción' . $e,
                'errror' => $e->getMessage()
            ], 500);
        }
    }
}
