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

    public function border($sheet,$array){
        $style = [];
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

    public function fusion($row,$sum){
        return $row + $sum;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setShowGridlines(false);
                $event->sheet->getDelegate()->getSheetView()->setZoomScale(90);

                //$event->sheet->getColumnDimension('A')->setWidth(40.00);
                //$event->sheet->getColumnDimension('E')->setWidth(50.00);

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
                    [1,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [2,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [3,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [4,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [5,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [6,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [7,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [8,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    [9,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    // [10,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    // [11,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    // [12,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    // [13,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    // [14,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                    // [15,2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12],
                ];

                for ($i=0; $i < count($arrayData); $i++) {
                    $rowData = 9 + $i;
                    foreach ($arrayData[$i] as $item) {

                        $event->sheet->mergeCells("E".$rowData.":J". $rowData);

                        $event->sheet->setCellValue('A'.$rowData,$arrayData[$i][0]);
                        $event->sheet->setCellValue('B'.$rowData,$arrayData[$i][1]);
                        $event->sheet->setCellValue('C'.$rowData,$arrayData[$i][2]);
                        $event->sheet->setCellValue('D'.$rowData,$arrayData[$i][3]);
                        $event->sheet->setCellValue('E'.$rowData,$arrayData[$i][4]);
                        $event->sheet->setCellValue('K'.$rowData,$arrayData[$i][5]);
                        $event->sheet->setCellValue('L'.$rowData,$arrayData[$i][6]);
                        $event->sheet->setCellValue('M'.$rowData,$arrayData[$i][7]);
                        $event->sheet->setCellValue('N'.$rowData,$arrayData[$i][8]);
                        $event->sheet->setCellValue('O'.$rowData,$arrayData[$i][9]);
                        $event->sheet->setCellValue('P'.$rowData,$arrayData[$i][10]);
                        $event->sheet->setCellValue('Q'.$rowData,$arrayData[$i][11]);
                        $event->sheet->setCellValue('R'.$rowData,$arrayData[$i][12]);
                        $event->sheet->setCellValue('S'.$rowData,$arrayData[$i][13]);
                        $event->sheet->setCellValue('T'.$rowData,$arrayData[$i][14]);
                        $event->sheet->setCellValue('U'.$rowData,$arrayData[$i][15]);
                    }
                }

                $rowStar = 9;
                $rowEnd = $rowStar - 1 + count( $arrayData );

                //A= Administrativo. L= Legal. F= Fiscal. C= Contable. AT= Archivo de Trámite. AC= Archivo de Concentración.
                $row1 = $rowEnd + 2;
                $event->sheet->rowHeight($rowEnd + 1, 6);
                $event->sheet->mergeCells('A'.$row1.':U'.$row1);
                $event->sheet->setCellValue('A'.$row1,'A= Administrativo. L= Legal. F= Fiscal. C= Contable. AT= Archivo de Trámite. AC= Archivo de Concentración.');

                //Lugar y fecha
                $row2 = $rowEnd + 3;
                $event->sheet->mergeCells('T'.$row2.':U'.$row2);
                $event->sheet->setCellValue('T'.$row2,'Lugar y fecha');

                $event->sheet->styleCells('T'.$row2.':U'.$row2,
                    array( 'alignment' => ['horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER ])

                );

                //El presente inventario consta de  000   foja(s) y ampara la cantidad de   0000  expedientes de los años   0000  contenidos en   000   cajas,  con un peso aproximado de  0000   kilogramos.
                $row3 = $rowEnd + 5;
                $event->sheet->rowHeight($row3, 18);
                $event->sheet->mergeCells('A'.$row3.':U'.$row3);
                $event->sheet->setCellValue('A'.$row3,'El presente inventario consta de  000   foja(s) y ampara la cantidad de   0000  expedientes de los años   0000  contenidos en   000   cajas,  con un peso aproximado de  0000   kilogramos.');

                //Elaboro
                $row4 = $rowEnd + 7;
                $row4End = $row4 + 9;

                for ($i=0; $i < 3 ; $i++) {
                    //Elaboro
                    $cell = null;
                    $title = null;
                    $cellTitle = null;
                    $cellMerge =  null;
                    $border = null;
                    if($i === 0){
                        $cell = 'B'.$row4.':F'.$row4End;
                        $cellMerge = 'C'.$this->fusion($row4,1).':E'.$this->fusion($row4,3);
                        $cellTitle = 'C'.$this->fusion($row4,1);
                        $title = 'Elaboró Responsable del archivo de concentración';
                        $border = 'C'.$this->fusion($row4,5).':E'.$this->fusion($row4,5);
                        $event->sheet->mergeCells( 'B'.$this->fusion($row4,7).':F'.$this->fusion($row4,7)  );
                        $event->sheet->mergeCells( 'B'.$this->fusion($row4,8).':F'.$this->fusion($row4,8)  );
                        $event->sheet->setCellValue( 'B'.$this->fusion($row4,7) , 'Adrian Núñez Alanis 1');
                        $event->sheet->setCellValue( 'B'.$this->fusion($row4,8) , 'Cargo 1');
                    }
                    if($i === 1){
                        $cell = 'H'.$row4.':L'.$row4End;
                        $cellMerge = 'I'.$this->fusion($row4,1).':K'.$this->fusion($row4,3);
                        $cellTitle = 'I'.$this->fusion($row4,1);
                        $title = 'Revisó Coordinador de Archivos';
                        $border = 'I'.$this->fusion($row4,5).':K'.$this->fusion($row4,5);
                        $event->sheet->mergeCells( 'H'.$this->fusion($row4,7).':L'.$this->fusion($row4,7)  );
                        $event->sheet->mergeCells( 'H'.$this->fusion($row4,8).':L'.$this->fusion($row4,8)  );
                        $event->sheet->setCellValue( 'H'.$this->fusion($row4,7) , 'Adrian Núñez Alanis 2');
                        $event->sheet->setCellValue( 'H'.$this->fusion($row4,8) , 'Cargo 2');
                    }
                    if($i === 2){
                        $cell = 'N'.$row4.':R'.$row4End;
                        $cellMerge = 'O'.$this->fusion($row4,1).':Q'.$this->fusion($row4,3);
                        $cellTitle = 'O'.$this->fusion($row4,1);
                        $title = 'Autorizó Titular de la Unidad administrativa';
                        $border = 'O'.$this->fusion($row4,5).':Q'.$this->fusion($row4,5);
                        $event->sheet->mergeCells( 'N'.$this->fusion($row4,7).':R'.$this->fusion($row4,7)  );
                        $event->sheet->mergeCells( 'N'.$this->fusion($row4,8).':R'.$this->fusion($row4,8)  );
                        $event->sheet->setCellValue( 'N'.$this->fusion($row4,7) , 'Adrian Núñez Alanis 3');
                        $event->sheet->setCellValue( 'N'.$this->fusion($row4,8) , 'Cargo 3');
                    }

                    $event->sheet->mergeCells($cellMerge);
                    $event->sheet->setCellValue($cellTitle, $title);
                    $event->sheet->wrapText( $cellMerge );

                    $event->sheet->styleCells($border,
                        [ 'borders' => [ 'bottom' => [ 'borderStyle' => static::$BORDER::BORDER_THIN,
                                                        'color' => ['argb' => 'FF000000'] ]
                                        ]
                    ]);

                    $event->sheet->styleCells(
                        $cell,
                        [
                            'font' => [
                                'bold' => true,
                                'name' => 'Calibri',
                                'size' => 10
                            ],
                            'alignment' => [
                                'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                                'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                            ],
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => static::$BORDER::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ]
                        ]
                    );
                }


                $rowsBorder = [
                    [ 'cell'=> 'A7:A8', 'bold' => true, 'merge' => true,  'field' => "No. \nconsecutivo", 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'B7:B8', 'bold' => true, 'merge' => true,  'field' => 'Código de clasificación archivística del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'C7:C8', 'bold' => true, 'merge' => true,  'field' => 'Número consecutivo de caja', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'D7:D8', 'bold' => true, 'merge' => true,  'field' => 'Número consecutivo del expe-diente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'E7:J8', 'bold' => true, 'merge' => true,  'field' => 'Descripción del asunto del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'K7:L7', 'bold' => true, 'merge' => true,  'field' => 'Periodo de trámite', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'K8',    'bold' => true, 'merge' => false, 'field' => 'Año de apertura', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'L8',    'bold' => true, 'merge' => false, 'field' => 'Año de cierre', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'M7:N7', 'bold' => true, 'merge' => true,  'field' => 'Tradición documental (documentación en)', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'M8',    'bold' => true, 'merge' => false, 'field' => 'Original', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'N8',    'bold' => true, 'merge' => false, 'field' => 'Copia', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'O7:R7', 'bold' => true, 'merge' => true,  'field' => 'Valor documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'O8',    'bold' => true, 'merge' => false, 'field' => 'A', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'P8',    'bold' => true, 'merge' => false, 'field' => 'L', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'Q8',    'bold' => true, 'merge' => false, 'field' => 'F', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'R8',    'bold' => true, 'merge' => false, 'field' => 'C', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'S7:U7', 'bold' => true, 'merge' => true,  'field' => 'Vigencia documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'S8',    'bold' => true, 'merge' => false, 'field' => 'AT', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'T8',    'bold' => true, 'merge' => false, 'field' => 'AC', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'U8',    'bold' => true, 'merge' => false, 'field' => 'Total', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'A'.$rowStar.':U'.$rowEnd,    'merge' => false, 'fill'=> 'FFFFFF'],
                ];

                foreach ($rowsBorder as $item){
                    $this->style($event->sheet ,$item);
                }
                //$event->sheet->getDelegate()->fromArray($arrayData, null, 'A9', false, false);
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
