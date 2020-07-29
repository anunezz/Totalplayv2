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


ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);


class Labels implements
    FromCollection,
    ShouldAutoSize,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithStrictNullComparison
    //Coordinate,
    //DataValidation
{

    //private $lastRow;
    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    //public function __construct($headers, $fields)
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
        return 'Etiqueta de expediente';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                //$event->sheet->getColumnDimension('A')->setWidth(6.00);
                $event->sheet->getColumnDimension('A')->setWidth(2.00);
                $event->sheet->getColumnDimension('B')->setWidth(2.00);

                $event->sheet->getColumnDimension('C')->setWidth(1.00);
                $event->sheet->getColumnDimension('D')->setWidth(4.00);
                $event->sheet->getColumnDimension('E')->setWidth(3.00);
                $event->sheet->getColumnDimension('F')->setWidth(11.00);
                $event->sheet->getColumnDimension('G')->setWidth(3.00);
                $event->sheet->getColumnDimension('H')->setWidth(11.00);
                $event->sheet->getColumnDimension('I')->setWidth(7.00);
                $event->sheet->getColumnDimension('J')->setWidth(7.00);
                $event->sheet->getColumnDimension('K')->setWidth(11.00);
                $event->sheet->getColumnDimension('L')->setWidth(4.00);
                $event->sheet->getColumnDimension('M')->setWidth(2.00);

                $event->sheet->getColumnDimension('N')->setWidth(2.50);

                $event->sheet->getColumnDimension('O')->setWidth(1.00);
                $event->sheet->getColumnDimension('P')->setWidth(4.00);
                $event->sheet->getColumnDimension('Q')->setWidth(3.00);
                $event->sheet->getColumnDimension('R')->setWidth(11.00);
                $event->sheet->getColumnDimension('S')->setWidth(3.00);
                $event->sheet->getColumnDimension('T')->setWidth(11.00);
                $event->sheet->getColumnDimension('U')->setWidth(7.00);
                $event->sheet->getColumnDimension('V')->setWidth(7.00);
                $event->sheet->getColumnDimension('W')->setWidth(11.00);
                $event->sheet->getColumnDimension('X')->setWidth(4.00);
                $event->sheet->getColumnDimension('Y')->setWidth(2.00);


                $data = [
                    [ 'cell'=>'C3:M3', 'border'=> 'top'],
                    [ 'cell'=>'C5:M5', 'border'=> 'bottom'],
                    [ 'cell'=>'C3:C5', 'border'=> 'left'],
                    [ 'cell'=>'M3:M5', 'border'=> 'right'],

                    [ 'cell'=>'O3:Y3', 'border'=> 'top'],
                    [ 'cell'=>'O5:Y5', 'border'=> 'bottom'],
                    [ 'cell'=>'O3:O5', 'border'=> 'left'],
                    [ 'cell'=>'Y3:Y5', 'border'=> 'right'],

                    [ 'cell'=>'C7:M7', 'border'=> 'top'],
                    [ 'cell'=>'C9:M9', 'border'=> 'bottom'],
                    [ 'cell'=>'C7:C9', 'border'=> 'left'],
                    [ 'cell'=>'M7:M9', 'border'=> 'right'],

                    [ 'cell'=>'O7:Y7', 'border'=> 'top'],
                    [ 'cell'=>'O9:Y9', 'border'=> 'bottom'],
                    [ 'cell'=>'O7:O9', 'border'=> 'left'],
                    [ 'cell'=>'Y7:Y9', 'border'=> 'right'],

                    [ 'cell'=>'C11:M11', 'border'=> 'top'],
                    [ 'cell'=>'C13:M13', 'border'=> 'bottom'],
                    [ 'cell'=>'C11:C13', 'border'=> 'left'],
                    [ 'cell'=>'M11:M13', 'border'=> 'right'],

                    [ 'cell'=>'O11:Y11', 'border'=> 'top'],
                    [ 'cell'=>'O13:Y13', 'border'=> 'bottom'],
                    [ 'cell'=>'O11:O13', 'border'=> 'left'],
                    [ 'cell'=>'Y11:Y13', 'border'=> 'right'],

                    [ 'cell'=>'C15:M15', 'border'=> 'top'],
                    [ 'cell'=>'C17:M17', 'border'=> 'bottom'],
                    [ 'cell'=>'C15:C17', 'border'=> 'left'],
                    [ 'cell'=>'M15:M17', 'border'=> 'right'],

                    [ 'cell'=>'O15:Y15', 'border'=> 'top'],
                    [ 'cell'=>'O17:Y17', 'border'=> 'bottom'],
                    [ 'cell'=>'O15:O17', 'border'=> 'left'],
                    [ 'cell'=>'Y15:Y17', 'border'=> 'right'],
                ];

                foreach ($data as $i) {
                    $event->sheet->styleCells(
                        $i['cell'],
                        [
                            'alignment' => [
                                'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                                'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                            ],
                            'borders' => [
                                $i['border'] => [
                                    'borderStyle' => static::$BORDER::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ]
                        ]
                    );
                }


                $data = [
                    [ 'cell'=>'D3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'E3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'F3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '08C.16.01'],
                    [ 'cell'=>'G3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'H3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '2018-'],
                    [ 'cell'=>'I3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/001'],
                    [ 'cell'=>'J3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/DAN'],
                    [ 'cell'=>'K3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/ET001-01'],
                    [ 'cell'=>'L3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '1/2'],
                    [ 'cell'=>'D4:L5',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'P3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'Q3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'R3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '08C.16.01'],
                    [ 'cell'=>'S3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'T3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '2018-'],
                    [ 'cell'=>'U3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/001'],
                    [ 'cell'=>'V3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/DAN'],
                    [ 'cell'=>'W3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/ET001-01'],
                    [ 'cell'=>'X3' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '1/2'],
                    [ 'cell'=>'O4:X5',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'D7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'E7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'F7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'G7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'H7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'I7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'J7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'K7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'L7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'D8:L9',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'P7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'Q7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'R7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'S7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'T7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'U7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'V7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'W7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'X7' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'O8:X9',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'D11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'E11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'F11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'G11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'H11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'I11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'J11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'K11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'L11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'D12:L13',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'P11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'Q11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'R11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'S11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'T11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'U11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'V11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'W11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'X11' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'O12:X13',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'D15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'E15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'F15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'G15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'H15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'I15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'J15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'K15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'L15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'D16:L17',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                    [ 'cell'=>'P15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => 'SRE'],
                    [ 'cell'=>'Q15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '.'],
                    [ 'cell'=>'R15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'S15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => '/'],
                    [ 'cell'=>'T15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'U15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'V15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'W15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'X15' ,    'select' => false, 'bold'=> true, 'fontSize'=> 11,  'field' => ''],
                    [ 'cell'=>'O16:X17',  'select' => false, 'bold'=> true, 'fontSize'=> 10.5,  'field' => 'Título del expediente'],

                ];
                foreach ($data as $i) {
                    $cel = preg_split("/[:]+/", $i['cell']);
                    $event->sheet->setCellValue($cel[0],$i['field']);
                    $event->sheet->wrapText('B3:B51');
                    if( count($cel) === 2 ){
                        $event->sheet->mergeCells( $i['cell'] );
                    }
                    $event->sheet->styleCells(
                        $i['cell'],
                        [
                            'font' => [
                                'bold' => $i['bold'],
                                'name' => 'Calibri',
                                'size' => $i['fontSize']
                            ],
                            'alignment' => [
                                'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                                'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                            ]
                        ]
                    );

                }


            },
        ];
    }

    public function collection()
    {
        try {

            $collection = collect();
            //$row = 2;

            // foreach ($this->fields as $key => $field) {
            //     $array = [];
            //     foreach ($this->headers as $header) {

            //         if (isset($field[$header])) {
            //             $array[$header] = $field[$header];
            //         } else if(is_int($field['cat_procedure_id'])){

            //             $array[$header] = [];
            //         } else {
            //             $array[$header] = 'N/A';
            //         }
            //     }
            //     $collection->push($array);
            //     $row++;
            // }

           // $this->lastRow = $row;
            return $collection;

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción' . $e,
                'errror' => $e->getMessage()
            ], 500);
        }
    }



}
