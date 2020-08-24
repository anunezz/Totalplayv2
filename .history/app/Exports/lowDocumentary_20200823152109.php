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

        $cel = preg_split("/[:]+/", $array['cell']);
        $sheet->setCellValue($cel[0], $array['field']);
        $sheet->wrapText( $array['cell'] );

        if( $array['merge'] === true ){
            $sheet->mergeCells( $array['cell'] );
        }

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
                    'allBorders' => [
                        'borderStyle' => static::$BORDER::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ]
                ],
                'fill' => [
                    'fillType' => static::$FILL::FILL_SOLID,
                    'startColor' => [
                        'argb' => isset($array['fill'])? $array['fill']: 'FFFFFF',
                    ],
                ],
            ]
        );

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setShowGridlines(false);  //este donde limpia e excel las celdad

                $event->sheet->getColumnDimension('A')->setWidth(40.00);

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
                    [ 'cell'=> 'A7:A8', 'merge' => true,'field'=>'No. consecutivo', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'B8:B9', 'merge' => true,'field'=>'Código de clasificación archivística del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'B8:B9', 'merge' => true,'field'=>'Código de clasificación archivística del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'C8:C9', 'merge' => true,'field'=>'Número consecutivo de caja', 'fill'=> 'FFCCD1D1'],
                ];

                foreach ($rowsBorder as $item){
                    $this->style($event->sheet ,$item);
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
