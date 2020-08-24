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


class LabelBox implements
    FromCollection,
    ShouldAutoSize,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithStrictNullComparison//,
   // WithDrawings
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

                $event->sheet->getColumnDimension('B')->setWidth(2.00);
                $event->sheet->getColumnDimension('C')->setWidth(15.00);
                $event->sheet->getColumnDimension('D')->setWidth(15.00);
                $event->sheet->getColumnDimension('F')->setWidth(15.00);
                $event->sheet->getColumnDimension('F')->setWidth(15.00);
                $event->sheet->getColumnDimension('G')->setWidth(2.00);

                $event->sheet->rowHeight('6', 60);

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');

                $drawing->setResizeProportional(false);
                $drawing->setWidth(379);
                $drawing->setHeight(49);
                $drawing->setOffsetX(13);
                $drawing->setOffsetY(7);
                $drawing->setPath(public_path('/img/RelacionesExterioresExcelEtqueta.png'));
                $drawing->setCoordinates('B3');
                $drawing->setWorksheet($event->sheet->getDelegate());


                $event->sheet->mergeCells( 'B2:G2' );
                $event->sheet->mergeCells( 'B3:G3' );
                $event->sheet->rowHeight('3', 50);
                $event->sheet->setCellValue('B4','Unidad Administrativa');
                $event->sheet->mergeCells( 'B4:G4' );

                $event->sheet->rowHeight('5', 30);
                $event->sheet->mergeCells( 'B5:G5' );
                //$event->sheet->mergeCells( 'B5:G5' );

                // for ($i=2; $i < 25; $i++) {
                //     $event->sheet->mergeCells( 'B'.$i.':G'.$i );
                // }

                $data = [
                    [ 'cell'=>'B2:G2', 'border'=> 'top', 'typeBorder'=> static::$BORDER::BORDER_DOUBLE],
                    [ 'cell'=>'B25:G25', 'border'=> 'bottom','typeBorder'=> static::$BORDER::BORDER_DOUBLE],
                    [ 'cell'=>'B2:B25', 'border'=> 'left','typeBorder'=> static::$BORDER::BORDER_DOUBLE],
                    [ 'cell'=>'G2:G25', 'border'=> 'right','typeBorder'=> static::$BORDER::BORDER_DOUBLE],

                    [ 'cell'=>'D14:D14', 'border'=> 'bottom','typeBorder'=> static::$BORDER::BORDER_THIN],
                    [ 'cell'=>'F14:F14', 'border'=> 'bottom','typeBorder'=> static::$BORDER::BORDER_THIN],

                    [ 'cell'=>'D16:F16', 'border'=> 'bottom','typeBorder'=> static::$BORDER::BORDER_THIN],
                    [ 'cell'=>'C22:F22', 'border'=> 'bottom','typeBorder'=> static::$BORDER::BORDER_THIN],
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
                                    'borderStyle' => $i['typeBorder'],
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ]
                        ]
                    );
                }

                $fontUnidad = ( strlen($this->fields['Unidad']) > 15  )? 14:24;
                $fontSection = ( strlen($this->fields['section']) > 12 )? 10:14;
                $fontSerie = ( strlen($this->fields['serie']) > 12 )? 10:14;
                $fontSubserie = ( strlen( $this->fields['subserie'] ) > 12 )? 10:14;
                $data = [
                    [ 'cell'=>'B4:G4',   'bold'=> true, 'fontSize'=> $fontUnidad,  'field' => $this->fields['Unidad']],
                    [ 'cell'=>'B5:G5',   'bold'=> true, 'fontSize'=> 26,  'field' => $this->fields['Determinante']],
                    [ 'cell'=>'C6',      'bold'=> true, 'fontSize'=> 14,  'field' => 'Fondo:'],
                    [ 'cell'=>'D6:F6',   'bold'=> true, 'fontSize'=> 18,  'field' => 'SRE Secretaría de Relaciones Exteriores.'],
                    [ 'cell'=>'C7',      'bold'=> true, 'fontSize'=> 14,  'field' => 'Sección:'],
                    //[ 'cell'=>'D7:F7',   'bold'=> true, 'fontSize'=> 18,  'field' => '000 Xxxx.'],
                    [ 'cell'=>'D7:F7',   'bold'=> true, 'fontSize'=> $fontSection,  'field' => $this->fields['section']],

                    [ 'cell'=>'C8',      'bold'=> true, 'fontSize'=> 14,  'field' => 'Serie:'],
                    [ 'cell'=>'D8:F8',   'bold'=> true, 'fontSize'=> $fontSerie,  'field' => $this->fields['serie']],
                    //[ 'cell'=>'D8:F8',   'bold'=> true, 'fontSize'=> 18,  'field' => '000 Xxxx.'],
                    [ 'cell'=>'C9',      'bold'=> true, 'fontSize'=> 14,  'field' => 'Subserie:'],
                    [ 'cell'=>'D9:F9',   'bold'=> true, 'fontSize'=> $fontSubserie,  'field' => $this->fields['subserie']],
                    [ 'cell'=>'B11:G11', 'bold'=> true, 'fontSize'=> 34,  'field' => '[00]'],
                    [ 'cell'=>'B12:G12', 'bold'=> true, 'fontSize'=> 20,  'field' => 'Expedientes'],
                    [ 'cell'=>'C14',     'bold'=> true, 'fontSize'=> 20,  'field' => 'Del:'],
                    [ 'cell'=>'E14',     'bold'=> true, 'fontSize'=> 20,  'field' => 'Al:'],
                    [ 'cell'=>'C16',     'bold'=> true, 'fontSize'=> 20,  'field' => 'Perido'],
                    [ 'cell'=>'C18:F18', 'bold'=> true, 'fontSize'=> 18,  'field' => 'Caja'],
                    [ 'cell'=>'C19:F19', 'bold'=> true, 'fontSize'=> 60,  'field' => '0'],
                    [ 'cell'=>'C21:F21', 'bold'=> true, 'fontSize'=> 16,  'field' => 'No. de transferencia'],
                ];
                foreach ($data as $i) {
                    $cel = preg_split("/[:]+/", $i['cell']);
                    $event->sheet->setCellValue($cel[0],$i['field']);
                    $event->sheet->wrapText( $i['cell'] );
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
