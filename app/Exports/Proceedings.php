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


class Proceedings implements
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
        return 'Expediente';
    }

    public function TraditionDocumentary($val){
        switch ($val) {
            case 1:
            {
                $val = "Copia";
            break;
            }
            case 2:
            {
                $val = "Original";
            break;
            }
            case 3:
            {
                $val = "Original y copia";
            break;
            }
            default:
            {
                $val = "";
            break;
            }

        }
        return $val;
    }

    public function Format($val){
        switch ($val) {
            case 1:
            {
                $val = "Electrónico";
            break;
            }
            case 2:
            {
                $val = "Físico";
            break;
            }
            default:
            {
                $val = "";
            break;
            }

        }
        return $val;
    }

    public function dateMonth($date){
        $date = preg_split("/[-]+/", $date);
        $date = $date[1];
        $months = [ ['id'=> '01','name' => 'Enero'],
                    ['id'=> '02','name' => 'Febrero'],
                    ['id'=> '03','name' => 'Marzo'],
                    ['id'=> '04','name' => 'Abril'],
                    ['id'=> '05','name' => 'Mayo'],
                    ['id'=> '06','name' => 'Junio'],
                    ['id'=> '07','name' => 'Julio'],
                    ['id'=> '08','name' => 'Agosto'],
                    ['id'=> '09','name' => 'Septiembre'],
                    ['id'=> '10','name' => 'Octubre'],
                    ['id'=> '11','name' => 'Noviembre'],
                    ['id'=> '12','name' => 'Diciembre']
                ];

            foreach ($months as $i) {
                if($i['id'] === $date){
                    $date = $i['name'];
                }
            }

        return $date;
    }

    public function question_one($action,$value){
        if($action === true ){
            $value = ( $value === 1 )? 'X': '';
        }else{
            $value = ( $value === 0 )? 'X': '';
        }
        return $value;
    }

    public function imgValidatr($event,$cell,$action){
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setResizeProportional(false);
        $drawing->setWidth(16);
        $drawing->setHeight(17);
        $drawing->setOffsetX(3);
        $drawing->setOffsetY(6);
        $pathImg = ($action === true)?'/img/correcto.png':'/img/tache.png';
        $drawing->setPath(public_path($pathImg));
        $drawing->setCoordinates($cell);
        $drawing->setWorksheet($event->getDelegate());
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                //imagenes
                $this->imgValidatr($event->sheet,'Z10',true);

                $Administrativo = array_search('Administrativo', array_column($this->fields['primarivalues'], 'name') ) === false ? '-':'X';
                $Legal          = array_search('Legal', array_column($this->fields['primarivalues'], 'name') ) === false ? '-':'X';
                $Fiscal         = array_search('Fiscal', array_column($this->fields['primarivalues'], 'name') ) === false ? '-':'X';
                $Contable       = array_search('Contable', array_column($this->fields['primarivalues'], 'name') ) === false ? '-':'X';



                $word = ['F','G','H','I','J','K','M','N','L','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                foreach ($word as $item) {
                    $event->sheet->getColumnDimension($item)->setWidth( $item === "W" ? 1.00 : 3.00 );
                }

                //Categorias
                $event->sheet->getColumnDimension('C')->setWidth(18.00);
                $topic = [
                    [ 'cell' => 'C3:C4',    'field' => 'Productor/a'],
                    [ 'cell' => 'C6:C10',   'field' => 'Nivel de descripción documental'],
                    [ 'cell' => 'C12:C13' , 'field' => 'Código de referencia'],
                    [ 'cell' => 'C15:C15' , 'field' => 'Título'],
                    [ 'cell' => 'C17:C17' , 'field' => 'Alcance y contenido (asunto)'],
                    [ 'cell' => 'C19:C21' , 'field' => 'Fecha(s)'],
                    [ 'cell' => 'C23:C26' , 'field' => 'Volumen y soporte'],
                    [ 'cell' => 'C28:C31' , 'field' => 'Características físicas y requisitos técnicos'],
                    [ 'cell' => 'C33:C36' , 'field' => 'Valoración, selección y eliminación'],
                    [ 'cell' => 'C38:C46' , 'field' => 'Condiciones de acceso (Leyenda de clasificación de la información y/o de versión pública)'],
                    [ 'cell' => 'C48:C50' , 'field' => 'Nota(s)'],
                ];

                foreach ($topic as $i) {
                    $cel = preg_split("/[:]+/", $i['cell']);
                    $event->sheet->wrapText( $i['cell'] );
                    $event->sheet->mergeCells( $i['cell'] );
                    $event->sheet->setCellValue($cel[0], $i['field']);
                    $event->sheet->styleCells(
                        $i['cell'],
                        [
                            'font' => [
                                'bold' => true,
                                'name' => 'Calibri',
                                'size' => 9
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
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => static::$BORDER::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ]
                        ]
                    );
                }

                $event->sheet->getColumnDimension('D')->setWidth(8.00);
                $event->sheet->getColumnDimension('E')->setWidth(8.00);

                $data = [
                    //Productor/a
                    [ 'cell'=>'D3:E3' , 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Unidad Administrativa'],
                    [ 'cell'=>'F3:Z3' , 'select' => false, 'bold'=> true,  'fontSize'=> 10, 'field' => $this->fields['unidad']],
                    [ 'cell'=>'D4:E4' , 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Área generadora'],
                    [ 'cell'=>'F4:Z4' , 'select' => false, 'bold'=> true,  'fontSize'=> 10,  'field' => 'DIRECCIÓN DE HISTORIA DIPLOMÁTICA Y PUBLICACIONES'],
                    //Nivel
                    [ 'cell'=> 'D6',    'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' => 'Fondo'],
                    [ 'cell'=> 'E6',    'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => 'SRE'],
                    [ 'cell'=> 'F6:Y6', 'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => 'Secretaría de Relaciones Exteriores'],
                    [ 'cell'=> 'Z6' ,   'select' => false, 'bold'=> false, 'fontSize'=> 9,'field' => '-'],

                    ['cell'=>'D7',    'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' => 'Sección'],
                    ['cell'=>'E7',    'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['sectionCode']],
                    ['cell'=>'F7:Y7', 'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['sectionName']],
                    ['cell'=>'Z7',    'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' => '-'],

                    ['cell'=>'D8',    'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' =>'Serie'],
                    ['cell'=>'E8',    'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['serieCode']],
                    ['cell'=>'F8:Y8', 'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['serieName']],
                    ['cell'=>'Z8',    'select' => false, 'bold'=> false, 'fontSize'=> 9, 'field' =>'-'],

                    ['cell'=>'D9',    'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' => 'Subserie'],
                    ['cell'=>'E9',    'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['subserieCode']],
                    ['cell'=>'F9:Y9', 'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['subserieName']],
                    ['cell'=>'Z9',    'select' => false, 'bold'=> false, 'fontSize'=> 9, 'field' => '-'],

                    [ 'cell'=>'D10',     'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' => 'Expediente'],
                    [ 'cell'=>'E10' ,    'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => '1'],
                    [ 'cell'=>'F10:Y10', 'select' => false, 'bold'=> true,  'fontSize'=> 9, 'field' => 'COMISIÓN EDITORIAL'],
                    [ 'cell'=>'Z10' ,    'select' => false, 'bold'=> false, 'fontSize'=> 7, 'field' => ''], //imagen
                    //Código de referencia
                    ['cell'=>'D12:D13','select' => false,  'bold'=> false, 'fontSize'=> 7, 'field' => 'Clasificación Archivística'],
                    //['cell'=>'E12',     'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'SRE'],
                    //['cell'=>'F12',     'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => '.'],
                    ['cell'=>'G12:V12', 'select' => false, 'bold'=> true,  'fontSize'=> 16, 'field' => $this->fields['codeOfReference']],
                    ['cell'=>'X12:Z12', 'select' => false, 'bold'=> true,  'fontSize'=> 16, 'field' => $this->fields['legajo']],
                    ['cell'=>'E13:F13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Fondo (.)'],
                    ['cell'=>'G13:I13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Sección (.)'],
                    ['cell'=>'J13:K13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Serie (.)'],
                    ['cell'=>'L13:N13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Subserie (/)'],
                    ['cell'=>'O13:S13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Año inicio (-) y cierre/'],
                    ['cell'=>'T13:V13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Consecutivo'],
                    ['cell'=>'X13:Z13', 'select' => false, 'bold'=> false, 'fontSize'=> 7,  'field' => 'Legajo'],

                    //Titulo
                    ['cell'=>'D15:Z15', 'select' => false, 'bold'=> true,'fontSize'=> 15.5, 'field' => $this->fields['title'] ],
                    ['cell'=>'D17:Z17', 'select' => false, 'bold'=> false,'fontSize'=> 10.5,'field' => $this->fields['alcance_y_contenido']],

                    //Fechas
                    //['cell'=>'D19:D19', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Día (00)'],
                    ['cell'=>'D20:D20', 'select' => false ,'bold'=> true  , 'fontSize'=> 7, 'field' =>   preg_split("/[-]+/", $this->fields['opening_date'])[2] ],
                    //['cell'=>'E19:H19', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Mes (letra)'],
                    ['cell'=>'E20:H20', 'select' => true  ,'bold'=> true  , 'fontSize'=> 7, 'field' =>    $this->dateMonth($this->fields['opening_date']) ],
                    //['cell'=>'I19:L19', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Año (0000)'],
                    ['cell'=>'I20:L20', 'select' => false ,'bold'=> true  , 'fontSize'=> 7, 'field' => preg_split("/[-]+/", $this->fields['opening_date'])[0]],
                    //['cell'=>'M19:N19', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Día (00)'],
                    ['cell'=>'M20:N20', 'select' => false ,'bold'=> true  , 'fontSize'=> 7, 'field' => preg_split("/[-]+/", $this->fields['close_date'])[2]],
                    //['cell'=>'O19:U19', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Mes (letra)'],
                    ['cell'=>'O20:U20', 'select' => true  ,'bold'=> true  , 'fontSize'=> 7, 'field' => $this->dateMonth($this->fields['close_date'])],
                    //['cell'=>'V19:Z19', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Año (0000)'],
                    ['cell'=>'V20:Z20', 'select' => false ,'bold'=> true  , 'fontSize'=> 7, 'field' => preg_split("/[-]+/", $this->fields['close_date'])[2]],
                    ['cell'=>'D21:L21', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Inicio del trámite o asunto'],
                    ['cell'=>'M21:Z21', 'select' => false ,'bold'=> false , 'fontSize'=> 7, 'field' => 'Cierre del trámite o asunto'],
                    //Volumen y Soporte
                    ['cell'=>'D23:H23', 'select' => false ,'bold'=> true , 'fontSize'=> 9, 'field' => 'Papel'],
                    ['cell'=>'D24:H24', 'select' => false ,'bold'=> false, 'fontSize'=> 7, 'field' => 'Soporte'],
                    ['cell'=>'D25:H25', 'select' => false ,'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['initial_folio']],
                    ['cell'=>'D26:H26', 'select' => false ,'bold'=> false, 'fontSize'=> 7, 'field' => 'Folio inicial'],
                    ['cell'=>'I23:R23', 'select' => false ,'bold'=> true , 'fontSize'=> 9, 'field' => $this->Format($this->fields['Format'])],
                    ['cell'=>'I24:R24', 'select' => false ,'bold'=> false, 'fontSize'=> 7, 'field' => 'Formato'],
                    ['cell'=>'I25:R25', 'select' => false ,'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['end_folio']],
                    ['cell'=>'I26:R26', 'select' => false ,'bold'=> false, 'fontSize'=> 7, 'field' => 'Folio final'],
                    ['cell'=>'S23:Z23', 'select' => false ,'bold'=> true , 'fontSize'=> 9, 'field' => $this->TraditionDocumentary($this->fields['Tradition_or_documentary_form'])],
                    ['cell'=>'S24:Z24', 'select' => false ,'bold'=> false, 'fontSize'=> 7, 'field' => 'Tradición o forma documental'],
                    ['cell'=>'S25:Z25', 'select' => false ,'bold'=> true,  'fontSize'=> 9, 'field' => $this->fields['fojas']],
                    ['cell'=>'S26:Z26', 'select' => false ,'bold'=> false, 'fontSize'=> 7, 'field' => 'Total Fojas útiles al cierre del expediente '],
                    //Características físicas y requisitos técnicos
                    ['cell'=>'D28:D31', 'select' => false ,'bold'=> false, 'fontSize'=> 6.5, 'field' => 'Electrónico'],
                    ['cell'=>'E28:I28', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Vínculo a anexos'],
                    ['cell'=>'J28:Z28', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => ''],
                    ['cell'=>'E29:I29', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Formato en que se captura'],
                    ['cell'=>'J29:Z29', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => ''],
                    ['cell'=>'E30:I30', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Requisitos para interpretar'],
                    ['cell'=>'J30:Z30', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => ''],
                    ['cell'=>'E31:I31', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Ubicación o directorio raíz'],
                    ['cell'=>'J31:Z31', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => ''],
                    //Valoración, selección y eliminación
                    ['cell'=>'D33:E33', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Administrativo'],
                    ['cell'=>'F33',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => $Administrativo],
                    ['cell'=>'G33:I33', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Legal'],
                    ['cell'=>'J33',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => $Legal],
                    ['cell'=>'K33:M33', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Contable'],
                    ['cell'=>'N33',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => $Contable],
                    ['cell'=>'O33:R33', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Fiscal'],
                    ['cell'=>'S33',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => $Fiscal],
                    ['cell'=>'T33:Z33', 'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => ''],
                    ['cell'=>'D34:Z34', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Valor documental primario'],
                    ['cell'=>'D35',     'select' => false ,'bold'=> true,  'fontSize'=> 10,  'field' => '1'],
                    ['cell'=>'E35:F35', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'años'],
                    ['cell'=>'G35:K35', 'select' => false ,'bold'=> true,  'fontSize'=> 10,  'field' => '1'],
                    ['cell'=>'L35:M35', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'años'],
                    ['cell'=>'N35',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => 'AC'],
                    ['cell'=>'O35:S35', 'select' => false ,'bold'=> false, 'fontSize'=> 10,  'field' => $this->fields['AC']],
                    ['cell'=>'T35',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => 'AH'],
                    ['cell'=>'U35:Z35', 'select' => false ,'bold'=> true,  'fontSize'=> 9,   'field' => '0'],
                    ['cell'=>'D36:F36', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Vigencia archivo de trámite'],
                    ['cell'=>'G36:M36', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Vigencia archivo de concentración'],
                    ['cell'=>'N36:Z36', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Plazo total de conservación'],
                    //Condiciones de acceso (Leyenda de clasificación de la información y/o de versión pública)
                    ['cell'=>'D38:F38', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => ''],
                    ['cell'=>'G38:J38', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Pública'],
                    ['cell'=>'K38',     'select' => false ,'bold'=> true,  'fontSize'=> 9,   'field' => 'X'],
                    ['cell'=>'L38:P38', 'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => 'Confidencial'],
                    ['cell'=>'Q38',     'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'DP'],
                    ['cell'=>'R38',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => ''],
                    ['cell'=>'S38',     'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'DS'],
                    ['cell'=>'T38',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => ''],
                    ['cell'=>'U38:Y38', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Reservada'],
                    ['cell'=>'Z38',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => ''],

                    ['cell'=>'D39:F39', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Fecha de clasificación'],
                    ['cell'=>'G39:P39', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => $this->fields['Classification_date']],
                    ['cell'=>'Q39:Y39', 'select' => false ,'bold'=> false, 'fontSize'=> 8,   'field' => 'Versión pública'],
                    ['cell'=>'Z39',     'select' => false ,'bold'=> false, 'fontSize'=> 9,   'field' => ''],

                    ['cell'=>'D40:F40', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Nombre y firma del Titular de la Unidad Administrativa'],
                    ['cell'=>'G40:P40', 'select' => false ,'bold'=> false, 'fontSize'=> 7,   'field' => 'Resolución del Comité de Transparencia'],
                    ['cell'=>'Q40:Z40', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => $this->fields['name_titular']],
                    ['cell'=>'D41:F41', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Acta del Comité de Transp.'],
                    ['cell'=>'G41:Z41', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->fields['transparency_proceedings']],

                    ['cell'=>'D42:F42', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Partes restringidas '],
                    ['cell'=>'G42:T42', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->fields['restricted_parts']],
                    ['cell'=>'U42:V42', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Foja(s)'],
                    ['cell'=>'W42:Z42', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->fields['fojas']],

                    ['cell'=>'D43:F43', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Fundamento Legal'],
                    ['cell'=>'G43:Z43', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->fields['legal_basis']],

                    ['cell'=>'D44:F44', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Periodoo de reserva'],
                    ['cell'=>'G44',     'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->fields['reservation_period']],
                    ['cell'=>'H44:I44', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'años'],
                    ['cell'=>'J44:M44', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Ampliación del plazo'],
                    ['cell'=>'N44',     'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => $this->fields['deadline_extension']],
                    ['cell'=>'O44:Q44', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'años'],
                    ['cell'=>'R44:U44', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'No. Acta / Oficio'],
                    ['cell'=>'V44:Z44', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->fields['Noactaoficio']],

                    ['cell'=>'D45:F45', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Fecha de desclasificación'],
                    ['cell'=>'G45:K45', 'select' => false ,'bold'=> false,  'fontSize'=> 10,  'field' => $this->fields['declassification_date']],
                    ['cell'=>'L45:P45', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Nombre, cargo y firma del servidor público que desclasifica'],
                    ['cell'=>'Q45:Z45', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => $this->fields['public_server']],

                    ['cell'=>'D46:L46', 'select' => false ,'bold'=> false,  'fontSize'=> 7,   'field' => 'Fue objeto de solicitud de acceso a información'],
                    ['cell'=>'M46:O46', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => 'Sí'],
                    ['cell'=>'P46',     'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' =>  $this->question_one(true , $this->fields['question_one'])  ],
                    ['cell'=>'Q46:S46', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => ''],
                    ['cell'=>'T46:W46', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => 'No'],
                    ['cell'=>'X46',     'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => $this->question_one(false , $this->fields['question_one'])],
                    ['cell'=>'Y46:Z46', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => ''],
                    //Notas
                    ['cell'=>'D48:Z48', 'select' => false ,'bold'=> false,  'fontSize'=> 8,   'field' => ''],

                    ['cell'=>'D49:L49', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => ''],
                    ['cell'=>'M49:R49', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => ''],
                    ['cell'=>'S49:Z49', 'select' => false ,'bold'=> false,  'fontSize'=> 9,   'field' => ''],

                    ['cell'=>'D50:L50', 'select' => false ,'bold'=> false,  'fontSize'=> 8,   'field' => 'Nota del archivero (elaboró)'],
                    ['cell'=>'M50:R50', 'select' => false ,'bold'=> false,  'fontSize'=> 8,   'field' => 'Fecha de elaboración'],
                    ['cell'=>'S50:Z50', 'select' => false ,'bold'=> false,  'fontSize'=> 8,   'field' => 'Reglas o normas (número de CDD)'],

                ];
                foreach ($data as $i) {
                    $cel = preg_split("/[:]+/", $i['cell']);
                    $event->sheet->setCellValue($cel[0],$i['field']);
                    //$event->sheet->wrapText('B3:B51');
                    $event->sheet->wrapText($i['cell']);
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
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => static::$BORDER::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ]
                            ]
                        ]
                    );

                    if( $i['select'] === true ){
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setType(DataValidation::TYPE_LIST);
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setErrorStyle(DataValidation::STYLE_INFORMATION);
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setAllowBlank(false);
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setShowInputMessage(true);
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setShowErrorMessage(true);
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setShowDropDown(true);
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setErrorTitle('Error de entrada');
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setError('El valor no está en la lista.');
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setPromptTitle('Elegir de la lista.');
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setPrompt('Elija un valor de la lista desplegable.');
                        $event->sheet->getCell( $cel[0] )->getDataValidation()->setFormula1('"Enero,Febrero,Marzo,Abril,Mayo,Abril,Mayo,Junio,Juio,Agosto,Setptiembre,Octubre,Noviembre,Diciembre"');
                        $event->sheet->mergeCells( $i['cell'] );
                    }

                }


                $event->sheet->textRotation('B3:B52', 90);
                $event->sheet->getColumnDimension('B')->setWidth(4.00);

                $allBorder = [
                    'allBorders' => [
                        'borderStyle' => static::$BORDER::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ]
                ];

                $dataa = [
                    ['cell'=>'E12',     'border'  => [],  'bold'=> true,   'fontSize'=> 16,  'field' => 'SRE'],
                    ['cell'=>'F12',     'border'  => [],  'bold'=> false,  'fontSize'=> 7,   'field' => '.'],
                    ['cell'=>'D19',     'border'  => [ $allBorder ],  'bold'=> false,  'fontSize'=> 7,   'field' => 'Día (00)'],
                    ['cell'=>'E19:H19', 'border'  => [ $allBorder ],  'bold'=> false,  'fontSize'=> 7,   'field' => 'Mes (letra)'],
                    ['cell'=>'I19:L19', 'border'  => [ $allBorder ],  'bold'=> false,  'fontSize'=> 7,   'field' => 'Año (0000)'],
                    ['cell'=>'M19:N19', 'border'  => [ $allBorder ],  'bold'=> false,  'fontSize'=> 7,   'field' => 'Día (00)'],
                    ['cell'=>'O19:U19', 'border'  => [ $allBorder ],  'bold'=> false,  'fontSize'=> 7,   'field' => 'Mes (letra)'],
                    ['cell'=>'V19:Z19', 'border'  => [ $allBorder ],  'bold'=> false,  'fontSize'=> 7,   'field' => 'Año (0000)'],
                    ['cell'=>'B3:B52',  'border'  => [],  'bold'=> false,  'fontSize'=> 8.5, 'field' => 'Formato basado en la LFA, los LGOCAPEF, los LOCA, los LGCDIVP, el MAPF, Recomendaciones del INAI para Datos Personales, y la ISAD (G)'],
                    ['cell'=>'C52:Z52', 'border' =>  [],  'bold'=> false,  'fontSize'=> 8.5, 'field' => 'AC= Archivo de concentración. AH= Archivo histórico. DP=Datos personales básicos. DS=Datos personales sensibles.'],
                    ['cell'=>'B54:Z57', 'border'  => [],  'bold'=> false,  'fontSize'=> 8.5, 'field' => 'Formato basado en la Ley Federal de Archivos; los Lineamientos Generales para la Organización y Conservación de Archivos del Poder Ejecutivo Federal; los Lineamientos para la Organización y Conservación de Archivos, Disposiciones Generales en las materias de Archivos y de Gobierno Abierto para la Administración Pública Federal y su Anexo Único [el Manual en la materia de archivos para la Administración Pública Federal]; los Lineamientos Generales en materia de Clasificación y Desclasificación de la Información, así como para la elaboración de Versiones Públicas; Recomendaciones del INAI para Datos Personales; y la ISAD (G).'],
                ];

                foreach ($dataa as $i) {
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
                            ],
                            'borders' => $i['border']
                        ]
                    );
                }



                //$event->sheet->autoFilter('A1:V1');
                $event->sheet->getColumnDimension('A')->setWidth(10.00);
                $event->sheet->textRotation('D28:D31', 90);

                $event->sheet->rowHeight('5', 6);
                $event->sheet->rowHeight('11', 6);
                $event->sheet->rowHeight('14', 6);
                $event->sheet->rowHeight('16', 6);
                $event->sheet->rowHeight('18', 6);
                $event->sheet->rowHeight('22', 6);
                $event->sheet->rowHeight('24', 11);
                $event->sheet->rowHeight('26', 23);
                $event->sheet->rowHeight('27', 6);

                $event->sheet->rowHeight('32', 6);
                $event->sheet->rowHeight('37', 6);
                $event->sheet->rowHeight('40', 30);
                $event->sheet->rowHeight('45', 30);
                $event->sheet->rowHeight('48', 30);
                $event->sheet->rowHeight('43', 25);
                $event->sheet->rowHeight('44', 20);
                $event->sheet->rowHeight('47', 6);
                $event->sheet->rowHeight('51', 6);

                $event->sheet->rowHeight('4', 22);
                $event->sheet->rowHeight('7', 22);
                $event->sheet->rowHeight('8', 22);
                $event->sheet->rowHeight('9', 22);
                $event->sheet->rowHeight('10', 22);
                $event->sheet->rowHeight('12', 25);
                $event->sheet->rowHeight('13', 12);
                $event->sheet->rowHeight('15', 28);
                $event->sheet->rowHeight('17', 90);


                //$event->sheet->setBorder('solid', 'none', 'none', 'solid');

                // $event->sheet('B3:B50', function($cells) {

                //     $cells->setBorder('solid', 'none', 'none', 'solid');

                // });
                #Set ba


                //siguiente
                //$event->sheet->rowHeight('6', 22);
                //$event->sheet->rowHeight('5', 5);
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
