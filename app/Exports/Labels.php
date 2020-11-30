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
use App\Http\Traits\Macros;

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

    public function style($sheet,$array){
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->setShowGridlines(false);

                $event->sheet->getColumnDimension('A')->setWidth(2.00);
                $event->sheet->getColumnDimension('B')->setWidth(2.00);

                $event->sheet->getColumnDimension('C')->setWidth(1.00);
                $event->sheet->getColumnDimension('D')->setWidth(4.00);
                $event->sheet->getColumnDimension('E')->setWidth(3.00);
                $event->sheet->getColumnDimension('F')->setWidth(11.00);
                $event->sheet->getColumnDimension('G')->setWidth(3.00);
                $event->sheet->getColumnDimension('H')->setWidth(11.00);
                $event->sheet->getColumnDimension('I')->setWidth(11.00);
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
                $event->sheet->getColumnDimension('U')->setWidth(11.00);
                $event->sheet->getColumnDimension('V')->setWidth(7.00);
                $event->sheet->getColumnDimension('W')->setWidth(11.00);
                $event->sheet->getColumnDimension('X')->setWidth(4.00);
                $event->sheet->getColumnDimension('Y')->setWidth(2.00);


                $data = $this->fields;

                // $data = collect([
                //     ['08C.16.01','20166-','/01','/DAN','/ET001-01','1/2','Título del expediente'],
                //     ['08C.16.02','2018-','/01','/DAN','/ET001-01','1/2','Título del expediente'],
                // ])->chunk(2);

                //dd($data);

                $row = 3;
                foreach ($data as $item) {
                    $i = 0;
                    foreach ($item as $data) {
                        $x = ($i === 0)? 'C':'O';
                        $y = ($i === 0)? 'M':'Y';
                        $sum = $row + 2;

                        $Cella = ($i === 0)? 'D': 'P';
                        $Cellb = ($i === 0)? 'E': 'Q';
                        $Cellc = ($i === 0)? 'F': 'R';
                        $Celld = ($i === 0)? 'G': 'S';
                        $Celle = ($i === 0)? 'H': 'T';
                        $Cellf = ($i === 0)? 'I': 'U';
                        $Cellg = ($i === 0)? 'J': 'V';
                        $Cellh = ($i === 0)? 'K': 'W';
                        $Celli = ($i === 0)? 'L': 'X';
                        $row1 = $row + 1;
                        $row2 = $row + 2;

                        $event->sheet->setCellValue( $Cella.$row, 'SRE');
                        $event->sheet->wrapText( $Cella.$row );
                        $event->sheet->setCellValue( $Cellb.$row, '.');
                        $event->sheet->wrapText( $Cellb.$row );
                        $event->sheet->setCellValue( $Cellc.$row, $data[0]);
                        $event->sheet->wrapText( $Cellc.$row );
                        $event->sheet->setCellValue( $Celld.$row, '/');
                        $event->sheet->wrapText( $Celld.$row );
                        $event->sheet->setCellValue( $Celle.$row, $data[1]);
                        $event->sheet->wrapText( $Celle.$row );
                        $event->sheet->setCellValue( $Cellf.$row, $data[2]);
                        $event->sheet->wrapText( $Cellf.$row );
                        $event->sheet->setCellValue( $Cellg.$row, $data[3]);
                        $event->sheet->wrapText( $Cellg.$row );
                        $event->sheet->setCellValue( $Cellh.$row, $data[4]);
                        $event->sheet->wrapText( $Cellh.$row );
                        $event->sheet->setCellValue( $Celli.$row, $data[5]);
                        $event->sheet->wrapText( $Celli.$row );

                        $strlen = strlen($data[6]) / 6;
                        $roww = (  $strlen > 35 )? $strlen : 35;
                        $event->sheet->rowHeight($row1, $roww);

                        $event->sheet->mergeCells( $Cella.$row1.':'.$Celli.$row2 );
                        $event->sheet->setCellValue( $Cella.$row1, $data[6]);
                        $event->sheet->wrapText( $Cella.$row1.':'.$Celli.$row2 );

                        $rowsBorder = [
                        [ 'cell'=> $x.$row.':'.$y.$row, 'border'=> 'top'],
                        [ 'cell'=> $x.$sum.':'.$y.$sum, 'border'=> 'bottom'],
                        [ 'cell'=> $x.$row.':'.$x.$sum, 'border'=> 'left'],
                        [ 'cell'=> $y.$row.':'.$y.$sum, 'border'=> 'right']
                        ];

                        foreach ($rowsBorder as $e){
                            $this->style($event->sheet ,$e);
                        }

                        $i = $i +1;
                    }
                    $row = $row + 4;
                }

                //$hola =  Macros::border('ejemplo');




            }
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
