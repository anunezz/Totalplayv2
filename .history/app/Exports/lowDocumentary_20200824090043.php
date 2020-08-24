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

        if ( isset( $array['field'] ) ) {
            $sheet->setCellValue($cel[0], $array['field']);
        }

        $sheet->wrapText( $array['cell'] );

        if( $array['merge'] === true ){
            $sheet->mergeCells( $array['cell'] );
        }

        $sheet->styleCells(
            $array['cell'],
            [
                'font' => [
                    'bold' => isset( $array['bold'] )? true: false,
                    'name' => 'Calibri',
                    'size' => 9
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
                $event->sheet->setShowGridlines(false);
                $event->sheet->getDelegate()->getSheetView()->setZoomScale(90);

                $event->sheet->getColumnDimension('A')->setWidth(40.00);
                $event->sheet->getColumnDimension('E')->setWidth(50.00);

                $event->sheet->rowHeight('7', 35);
                $event->sheet->rowHeight('8', 35);

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


                $arrayData = [
                    [89999, 2010, 2011, 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [89999, 2010, 2011, 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [89999, 2010, 2011, 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [89999, 2010, 2011, 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [89999, 2010, 2011, 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                ];

                $rowStar = 9;
                $rowEnd = $rowStar - 1 + count( $arrayData );

                $rowsBorder = [
                    [ 'cell'=> 'A7:A8', 'merge' => true,  'field' => 'No. consecutivo', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'B7:B8', 'merge' => true,  'field' => 'Código de clasificación archivística del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'C7:C8', 'merge' => true,  'field' => 'Número consecutivo de caja', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'D7:D8', 'merge' => true,  'field' => 'Número consecutivo del expe-diente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'E7:E8', 'merge' => true,  'field' => 'Descripción del asunto del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'F7:G7', 'merge' => true,  'field' => 'Periodo de trámite', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'F8',    'merge' => false, 'field' => 'Año de apertura', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'G8',    'merge' => false, 'field' => 'Año de cierre', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'H7:I7', 'merge' => true,  'field' => 'Tradición documental (documentación en)', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'H8',    'merge' => false, 'field' => 'Original', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'I8',    'merge' => false, 'field' => 'Copia', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'J7:M7', 'merge' => true,  'field' => 'Valor documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'J8',    'merge' => false, 'field' => 'A', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'K8',    'merge' => false, 'field' => 'L', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'L8',    'merge' => false, 'field' => 'F', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'M8',    'merge' => false, 'field' => 'C', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'N7:P7', 'merge' => true,  'field' => 'Vigencia documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'N8',    'merge' => false, 'field' => 'AT', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'O8',    'merge' => false, 'field' => 'AC', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'P8',    'merge' => false, 'field' => 'Total', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'A'.$rowStar.':P'.$rowEnd,    'merge' => false, 'fill'=> 'FFFFFF'],
                ];

                foreach ($rowsBorder as $item){
                    $this->style($event->sheet ,$item);
                }

                $event->sheet->getDelegate()->fromArray($arrayData, null, 'A9', false, false);

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
