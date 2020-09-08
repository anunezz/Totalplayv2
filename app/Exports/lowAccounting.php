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


class lowAccounting implements
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

                $event->sheet->rowHeight('8', 8);
                $event->sheet->rowHeight('9', 30);
                $event->sheet->rowHeight('10',30);

                $event->sheet->mergeCells("A1:W1");
                $event->sheet->setCellValue('A1','Unidad administrativa productora:');
                $event->sheet->mergeCells("A2:W2");
                $event->sheet->setCellValue('A2','Área productora:');
                $event->sheet->mergeCells("A3:W3");
                $event->sheet->setCellValue('A3','Área tramitadora: Coordinación de Archivos');
                $event->sheet->mergeCells("A4:W4");
                $event->sheet->setCellValue('A4','Fondo: SRE Secretaría de Relaciones Exteriores');
                $event->sheet->mergeCells("A5:W5");
                $event->sheet->setCellValue('A5','Sección documental:');
                $event->sheet->mergeCells("A6:R6");
                $event->sheet->setCellValue('A6','Serie documental: ');

                $event->sheet->mergeCells("S6:T6");
                $event->sheet->setCellValue('S6','Valor documental: ');
                $event->sheet->styleCells("S6:T6",
                    array( 'alignment' => ['horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER ])
                );

                $event->sheet->mergeCells("U6:W6");
                $event->sheet->setCellValue('U6','Contable');
                $event->sheet->styleCells('U6:W6',
                    array(
                    'alignment' => [
                        'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                        'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => static::$BORDER::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ]
                    ])
                );

                $event->sheet->mergeCells("A7:P7");
                $event->sheet->setCellValue('A7','Subserie documental:');

                $arrayData = [
                    [1,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [2,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [3,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [4,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [5,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [6,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [7,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [8,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [9,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [10,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [11,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [12,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [13,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [14,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                    [15,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],
                ];

                for ($i=0; $i < count($arrayData); $i++) {
                    $rowData = 11 + $i;
                    foreach ($arrayData[$i] as $item) {

                        $event->sheet->mergeCells("E".$rowData.":I". $rowData);
                        $event->sheet->mergeCells("J".$rowData.":N". $rowData);

                        $event->sheet->setCellValue('A'.$rowData,$arrayData[$i][0]);
                        $event->sheet->setCellValue('B'.$rowData,$arrayData[$i][1]);
                        $event->sheet->setCellValue('C'.$rowData,$arrayData[$i][2]);
                        $event->sheet->setCellValue('D'.$rowData,$arrayData[$i][3]);
                        $event->sheet->setCellValue('E'.$rowData,$arrayData[$i][4]);
                        $event->sheet->setCellValue('J'.$rowData,$arrayData[$i][5]);
                        $event->sheet->setCellValue('O'.$rowData,$arrayData[$i][6]);
                        $event->sheet->setCellValue('P'.$rowData,$arrayData[$i][7]);
                        $event->sheet->setCellValue('Q'.$rowData,$arrayData[$i][8]);
                        $event->sheet->setCellValue('R'.$rowData,$arrayData[$i][9]);
                        $event->sheet->setCellValue('S'.$rowData,$arrayData[$i][10]);
                        $event->sheet->setCellValue('T'.$rowData,$arrayData[$i][11]);
                        $event->sheet->setCellValue('U'.$rowData,$arrayData[$i][12]);
                        $event->sheet->setCellValue('V'.$rowData,$arrayData[$i][13]);
                        $event->sheet->setCellValue('W'.$rowData,$arrayData[$i][14]);
                    }
                }

                $rowStar = 11;
                $rowEnd = $rowStar - 1 + count( $arrayData );

                //A= Administrativo. L= Legal. F= Fiscal. C= Contable. AT= Archivo de Trámite. AC= Archivo de Concentración.
                    $row1 = $rowEnd + 2;
                    $event->sheet->mergeCells('A'.$this->fusion($row1 , 1).':W'.$this->fusion($row1 , 1));
                    $event->sheet->setCellValue('A'.$this->fusion($row1 , 1),'AT= Archivo de Trámite. AC= Archivo de Concentración.');

                //Lugar y fecha
                    $row2 = $rowEnd + 4;
                    $event->sheet->mergeCells('V'.$row2.':W'.$row2);
                    $event->sheet->setCellValue('V'.$row2,'Lugar y fecha');
                    $event->sheet->styleCells('V'.$row2.':W'.$row2,
                        array( 'alignment' => ['horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER ])
                    );
                    $event->sheet->wrapText('V'.$row2.':W'.$row2);

                //El presente inventario consta de 000 foja(s) y ampara la cantidad de 0000 expedientes de los años 0000 contenidos en 000 cajas,  con un peso aproximado de 0000 kilogramos.
                    $row3 = $rowEnd + 6;
                    $event->sheet->rowHeight($row3, 18);
                    $event->sheet->mergeCells('A'.$row3.':W'.$row3);
                    $event->sheet->setCellValue('A'.$row3,'El presente inventario consta de 000 foja(s) y ampara la cantidad de 0000 expedientes de los años 0000 contenidos en 000 cajas,  con un peso aproximado de 0000 kilogramos.');

                //Nota(s): Las CLC'S no incluidas en este inventario corresponden a gastos de inversión, mismas que se encuentran bajo resguardo de la Dirección de Contabilidad de la Secretaría de Relaciones Exteriores.
                    $row4 = $rowEnd + 8;
                    $event->sheet->rowHeight($row4, 18);
                    $event->sheet->mergeCells('A'.$row4.':W'.$row4);
                    $event->sheet->setCellValue('A'.$row4,'Nota(s): Las CLC"S no incluidas en este inventario corresponden a gastos de inversión, mismas que se encuentran bajo resguardo de la Dirección de Contabilidad de la Secretaría de Relaciones Exteriores.');
                    $event->sheet->styleCells('A'.$row4.':W'.$row4,
                        array( 'font' => [ 'bold' => true,
                                            'name' => 'Calibri', 'size' => 12 ])
                    );

                //Elaboro
                $row5 = $rowEnd + 10;
                $row5End = $row5 + 9;

                for ($i=0; $i < 4; $i++) {
                    //Elaboro
                    $cell = null;
                    $title = null;
                    $cellTitle = null;
                    $cellMerge =  null;
                    $border = null;
                    if($i === 0){
                        $cell = 'A'.$row5.':E'.$row5End;
                        $cellMerge = 'B'.$this->fusion($row5,1).':D'.$this->fusion($row5,3);
                        $cellTitle = 'B'.$this->fusion($row5,1);
                        $title = 'Elaboró';
                        $border = 'B'.$this->fusion($row5,5).':D'.$this->fusion($row5,5);
                        $event->sheet->mergeCells( 'A'.$this->fusion($row5,7).':E'.$this->fusion($row5,7)  );
                        $event->sheet->mergeCells( 'A'.$this->fusion($row5,8).':E'.$this->fusion($row5,8)  );
                        $event->sheet->setCellValue( 'A'.$this->fusion($row5,7) , 'Adrian Núñez Alanis 1');
                        $event->sheet->setCellValue( 'A'.$this->fusion($row5,8) , 'Cargo 1');
                    }
                    if($i === 1){
                        $cell = 'G'.$row5.':K'.$row5End;
                        $cellMerge = 'H'.$this->fusion($row5,1).':J'.$this->fusion($row5,3);
                        $cellTitle = 'H'.$this->fusion($row5,1);
                        $title = 'Visto Bueno Área Productora';
                        $border = 'H'.$this->fusion($row5,5).':J'.$this->fusion($row5,5);
                        $event->sheet->mergeCells( 'G'.$this->fusion($row5,7).':K'.$this->fusion($row5,7)  );
                        $event->sheet->mergeCells( 'G'.$this->fusion($row5,8).':K'.$this->fusion($row5,8)  );
                        $event->sheet->setCellValue( 'G'.$this->fusion($row5,7) , 'Adrian Núñez Alanis 2');
                        $event->sheet->setCellValue( 'G'.$this->fusion($row5,8) , 'Cargo 2');
                    }
                    if($i === 2){
                        $cell = 'M'.$row5.':Q'.$row5End;
                        $cellMerge = 'N'.$this->fusion($row5,1).':P'.$this->fusion($row5,3);
                        $cellTitle = 'N'.$this->fusion($row5,1);
                        $title = 'Revisó Área Tramitadora';
                        $border = 'N'.$this->fusion($row5,5).':P'.$this->fusion($row5,5);
                        $event->sheet->mergeCells( 'M'.$this->fusion($row5,7).':Q'.$this->fusion($row5,7)  );
                        $event->sheet->mergeCells( 'M'.$this->fusion($row5,8).':Q'.$this->fusion($row5,8)  );
                        $event->sheet->setCellValue( 'M'.$this->fusion($row5,7) , 'Adrian Núñez Alanis 3');
                        $event->sheet->setCellValue( 'M'.$this->fusion($row5,8) , 'Cargo 3');
                    }
                    if($i === 3){
                        $cell = 'S'.$row5.':W'.$row5End;
                        $cellMerge = 'T'.$this->fusion($row5,1).':V'.$this->fusion($row5,3);
                        $cellTitle = 'T'.$this->fusion($row5,1);
                        $title = 'Autorizó Unidad Administrativa Productora';
                        $border = 'T'.$this->fusion($row5,5).':V'.$this->fusion($row5,5);
                        $event->sheet->mergeCells( 'S'.$this->fusion($row5,7).':W'.$this->fusion($row5,7)  );
                        $event->sheet->mergeCells( 'S'.$this->fusion($row5,8).':W'.$this->fusion($row5,8)  );
                        $event->sheet->setCellValue( 'S'.$this->fusion($row5,7) , 'Adrian Núñez Alanis 4');
                        $event->sheet->setCellValue( 'S'.$this->fusion($row5,8) , 'Cargo 4');
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








                //Total
                $rowTotal = $rowEnd + 1;
                $event->sheet->setCellValue('B'.$rowTotal,'Total');
                $event->sheet->styleCells('B'.$rowTotal,
                array( 'alignment' => ['horizontal' => static::$ALIGNMENT::HORIZONTAL_RIGHT ])
            );

                $rowsBorder = [
                    [ 'cell'=> 'A9:A10', 'bold' => true, 'merge' => true,  'field' => "No.\nconsecutivo", 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'B9:B10', 'bold' => true, 'merge' => true,  'field' => 'Código de clasificación archivística', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'C9:C10', 'bold' => true, 'merge' => true,  'field' => 'Unidad de Medida y cantidad (Cajas)', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'D9:D10', 'bold' => true, 'merge' => true,  'field' => 'Cantidad de Expedientes', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'E9:I10', 'bold' => true, 'merge' => true,  'field' => 'Título (nombre) del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'J9:N10', 'bold' => true, 'merge' => true,  'field' => 'Descripción de la documentación anexa', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'O9:P9', 'bold' => true, 'merge' => true,  'field' => 'Periodo de trámite', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'O10',    'bold' => true, 'merge' => false, 'field' => 'Año de apertura', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'P10',    'bold' => true, 'merge' => false, 'field' => 'Año de cierre', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'Q9:T9', 'bold' => true, 'merge' => true,  'field' => 'Tipo de documentación', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'Q10',    'bold' => true, 'merge' => false, 'field' => 'Corriente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'R10',    'bold' => true, 'merge' => false, 'field' => 'Inversión', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'S10',    'bold' => true, 'merge' => false, 'field' => 'Ingreso', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'T10',    'bold' => true, 'merge' => false, 'field' => 'Otro', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'U9:W9', 'bold' => true, 'merge' => true,  'field' => 'Vigencia documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'U10',    'bold' => true, 'merge' => false, 'field' => 'AT', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'V10',    'bold' => true, 'merge' => false, 'field' => 'AC', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'W10',    'bold' => true, 'merge' => false, 'field' => 'Total', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'A'.$rowStar.':W'.$rowEnd,    'merge' => false, 'fill'=> 'FFFFFF'],
                    [ 'cell'=> 'C'.$rowTotal, 'merge' => false, 'fill'=> 'FFFFFF'],
                    [ 'cell'=> 'D'.$rowTotal, 'merge' => false, 'fill'=> 'FFFFFF'],
                ];

                foreach ($rowsBorder as $item){
                    $this->style($event->sheet ,$item);
                }

                //$event->sheet->getDelegate()->fromArray($arrayData, null, 'A11', false, false);

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
