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


class Transfer implements
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
        return $this->fields['transfer'];
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
                $event->sheet->getDelegate()->getSheetView()->setZoomScale(70);

                $event->sheet->getColumnDimension('AC')->setWidth(18.00);
                $event->sheet->getColumnDimension('AD')->setWidth(23.00);

                $event->sheet->rowHeight('12', 40);
                $event->sheet->rowHeight('13', 40);

                $event->sheet->mergeCells("E1:AB1");
                $event->sheet->setCellValue('E1','INVENTARIO DOCUMENTAL');

                $event->sheet->styleCells("E1:AB1",
                    array( 'alignment' => ['horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER ],
                                'font' => [ 'bold' => true,
                                            'name' => 'Calibri', 'size' => 16 ],
                                            'font' => [ 'bold' => true, 'name' => 'Calibri','size' => 12 ]
                    )
                );



                $event->sheet->mergeCells("AC1:AD1");
                $event->sheet->setCellValue('AC1','Secretaría de Relaciones Exteriores');

                $event->sheet->mergeCells("AB3:AC3");
                $event->sheet->setCellValue('AB3','No. de Foja(s):');
                $event->sheet->mergeCells("AB4:AC4");
                $event->sheet->setCellValue('AB4','Fecha de Transferencia:');
                $event->sheet->mergeCells("AB5:AC5");
                $event->sheet->setCellValue('AB5','No. de Transferencia:');

                $event->sheet->mergeCells("S3:U3");
                $event->sheet->setCellValue('S3','Transferencia primaria');
                $primary = $this->fields['transfer'] === 'Transferencia primaria' ? 'X': null;
                $event->sheet->setCellValue('V3',$primary);

                $event->sheet->mergeCells("S4:U4");
                $event->sheet->setCellValue('S4','Transferencia secundaria');
                $secondary = $this->fields['transfer'] === 'Transferencia secundaria' ? 'X': null;
                $event->sheet->setCellValue('V4',$secondary);

                foreach (['V3','V4'] as $itm) {
                    $event->sheet->styleCells(
                        $itm,
                        [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => static::$BORDER::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ],
                            'alignment' => [
                                'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                                'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                            ]
                        ]
                    );
                }

                foreach (['AD3','AD4','AD5'] as $itm) {
                    $event->sheet->styleCells(
                        $itm,
                        ['borders' => [
                                'bottom' => [
                                    'borderStyle' => static::$BORDER::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ]
                        ]
                    );
                }


                $event->sheet->mergeCells("A2:F4");
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
                $drawing->setWorksheet($event->sheet->getDelegate());

                $event->sheet->mergeCells("A5:W5");
                $event->sheet->setCellValue('A5','Unidad administrativa:');
                $event->sheet->mergeCells("A6:W6");
                $event->sheet->setCellValue('A6','Área productora:');
                $event->sheet->mergeCells("A7:W7");
                $event->sheet->setCellValue('A7','Fondo: SRE Secretaría de Relaciones Exteriores');
                $event->sheet->setCellValue('A8','Sección documental:');
                $event->sheet->mergeCells("A8:R8");
                $event->sheet->setCellValue('A9','Serie documental:');
                $event->sheet->mergeCells("A9:R9");
                $event->sheet->setCellValue('A10','Subserie documental:');
                $event->sheet->mergeCells("A10:R10");

                $arrayData = [
                    [1,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [2,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [3,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [4,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [5,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [6,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [7,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [8,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [9,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [10,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [11,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [12,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [13,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [14,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    [15,  2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                ];

                for ($i=0; $i < count($arrayData); $i++) {
                    $rowData = 14 + $i;
                    foreach ($arrayData[$i] as $item) {

                        $event->sheet->mergeCells("F".$rowData.":I". $rowData);
                        $event->sheet->mergeCells("J".$rowData.":N". $rowData);

                        $event->sheet->setCellValue('A'.$rowData,$arrayData[$i][0]);
                        $event->sheet->setCellValue('B'.$rowData,$arrayData[$i][1]);
                        $event->sheet->setCellValue('C'.$rowData,$arrayData[$i][2]);
                        $event->sheet->setCellValue('D'.$rowData,$arrayData[$i][3]);
                        $event->sheet->setCellValue('E'.$rowData,$arrayData[$i][4]);
                        $event->sheet->setCellValue('F'.$rowData,$arrayData[$i][5]);
                        $event->sheet->setCellValue('J'.$rowData,$arrayData[$i][6]);
                        $event->sheet->setCellValue('O'.$rowData,$arrayData[$i][6]);
                        $event->sheet->setCellValue('P'.$rowData,$arrayData[$i][7]);
                        $event->sheet->setCellValue('Q'.$rowData,$arrayData[$i][8]);
                        $event->sheet->setCellValue('R'.$rowData,$arrayData[$i][9]);
                        $event->sheet->setCellValue('S'.$rowData,$arrayData[$i][10]);
                        $event->sheet->setCellValue('T'.$rowData,$arrayData[$i][11]);
                        $event->sheet->setCellValue('U'.$rowData,$arrayData[$i][12]);
                        $event->sheet->setCellValue('V'.$rowData,$arrayData[$i][13]);
                        $event->sheet->setCellValue('W'.$rowData,$arrayData[$i][14]);
                        $event->sheet->setCellValue('X'.$rowData,$arrayData[$i][15]);
                        $event->sheet->setCellValue('Y'.$rowData,$arrayData[$i][16]);
                        $event->sheet->setCellValue('Z'.$rowData,$arrayData[$i][17]);
                        $event->sheet->setCellValue('AA'.$rowData,$arrayData[$i][18]);
                        $event->sheet->setCellValue('AB'.$rowData,$arrayData[$i][19]);
                        $event->sheet->setCellValue('AC'.$rowData,$arrayData[$i][20]);
                        $event->sheet->setCellValue('AD'.$rowData,$arrayData[$i][21]);
                    }
                }

                $rowStar = 14;
                $rowEnd = $rowStar - 1 + count( $arrayData );

                //El presente inventario consta de  000   foja(s) y ampara la cantidad de   0000  expedientes de los años   0000  contenidos en  000   cajas,  con un peso aproximado de  0000  kilogramos.
                    $row1 = $rowEnd + 2;
                    $event->sheet->mergeCells('A'.$this->fusion($row1 , 1).':W'.$this->fusion($row1 , 1));
                    $event->sheet->setCellValue('A'.$this->fusion($row1 , 1),'El presente inventario consta de  000   foja(s) y ampara la cantidad de   0000  expedientes de los años   0000  contenidos en  000   cajas,  con un peso aproximado de  0000  kilogramos.');

                //Elaboro
                $row5 = $rowEnd + 6;
                $row5End = $row5 + 9;

                for ($i=0; $i < 4; $i++) {
                    $cell = null;
                    $title = null;
                    $cellTitle = null;
                    $cellMerge =  null;
                    $border = null;
                    if($i === 0){
                        $cell = 'A'.$row5.':E'.$row5End;
                        $cellMerge = 'B'.$this->fusion($row5,1).':D'.$this->fusion($row5,3);
                        $cellTitle = 'B'.$this->fusion($row5,1);
                        $title = 'Elaboró Responsable del Archivo de Concentración';
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
                        $title = 'Revisó Coordinador de Archivos';
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
                        $title = 'Autorizó Titular de la Unidad Administrativa';
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
                        $title = 'Autorizó Titular de la Unidad Administrativa';
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

                $rowsBorder = [
                    [ 'cell'=> 'A12:A13', 'bold' => true, 'merge' => true,  'field' => "No.\nconsecutivo", 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'B12:C13', 'bold' => true, 'merge' => true,  'field' => 'Código de clasificación archivística del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'D12:D13', 'bold' => true, 'merge' => true,  'field' => ' Número consecutivo de caja', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'E12:E13', 'bold' => true, 'merge' => true,  'field' => 'Número consecutivo de expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'F12:I13', 'bold' => true, 'merge' => true,  'field' => 'Título del expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'J12:N13', 'bold' => true, 'merge' => true,  'field' => 'Descripción de la documentación anexa', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'O12:O13', 'bold' => true, 'merge' => true,  'field' => 'Número de folios que integra el expediente', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'P12:Q12', 'bold' => true, 'merge' => true,  'field' => 'Periodo de trámite', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'P13',     'bold' => true, 'merge' => false, 'field' => 'Año de apertura', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'Q13',     'bold' => true, 'merge' => false, 'field' => 'Año de cierre', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'R12:S12', 'bold' => true, 'merge' => true,  'field' => 'Tradición documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'R13',     'bold' => true, 'merge' => false, 'field' => 'Original', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'S13',     'bold' => true, 'merge' => false, 'field' => 'Copia', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'T12:W12', 'bold' => true, 'merge' => true,  'field' => 'Valor documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'T13',     'bold' => true, 'merge' => false, 'field' => 'A', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'U13',     'bold' => true, 'merge' => false, 'field' => 'L', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'V13',     'bold' => true, 'merge' => false, 'field' => 'F', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'W13',     'bold' => true, 'merge' => false, 'field' => 'C', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'X12:Z12', 'bold' => true, 'merge' => true,  'field' => 'Vigencia documental', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'X13',     'bold' => true, 'merge' => false, 'field' => 'AT', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'Y13',     'bold' => true, 'merge' => false, 'field' => 'AC', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'Z13',     'bold' => true, 'merge' => false, 'field' => 'Total', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'AA12:AB12', 'bold' => true, 'merge' => true,  'field' => 'Condiciones de acceso', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'AA13',     'bold' => true, 'merge' => false, 'field' => 'C', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'AB13',     'bold' => true, 'merge' => false, 'field' => 'R', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'AC12:AC13',     'bold' => true, 'merge' => true, 'field' => 'Ubicación topográfica', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'AD12:AD13',     'bold' => true, 'merge' => true, 'field' => 'Observaciones', 'fill'=> 'FFCCD1D1'],
                    [ 'cell'=> 'A'.$rowStar.':AD'.$rowEnd,    'merge' => false, 'fill'=> 'FFFFFF']
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
