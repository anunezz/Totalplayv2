<?php

namespace App\Exports;

use App\Http\Models\Formalities;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class FormalitiesExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithCustomStartCell
//    ShouldAutoSize
{

    private $data;
    private $totalRecords;
    private $numRegister;
    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            '#',
            'Determinante',
            'Clasificación',
            'Sección',
            'Serie',
            'Subserie',
            'Fecha de apertura',
            'Fecha de cierre',
            'Consecutivo',
            'Legajo',
            'Asunto/Título',
            'Alcance y contenido',
            'Información adicional',
            'Formato',
            'Tradición documental',
            'Legajo',
            'Folio inicial',
            'Folio final',
            'Total de fojas',
            'A',
            'L',
            'F',
            'C',
            'AT',
            'AC',
            'Solicitud de acceso a la información',
            'Total',
            'E',
            'C',
            'M',
            'Cualidad de la muestra',
            'Resolución del comité de transparencia',
            'Carácter de la información',
            'Razón de clasificación',
            'Fecha de clasificación',
            'Nombre y firma del titular de la unidad administrativa',
            'Acta del comité de transparencia',
            'Partes restringidas (folios)',
            'Fundamento legal',
            'Periodo de reserva (años)',
            'Ampliación del plazo (años)',
            'Número de acta/oficio',
            'Fecha de desclasificación',
            'Nombre completo',
            'Cargo'
        ];
    }

    public function title(): string
    {
        return 'Archivos de trámite';
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        $cols = 'A5:AS5';
        return [
            AfterSheet::class => function(AfterSheet $event) use ($cols) {
                $event->sheet->setShowGridlines(false);
                $event->sheet->getDelegate()->getSheetView()->setZoomScale(50);

                $event->sheet->mergeCells("A1:AS1");
                $event->sheet->setCellValue('A1','LISTA DE EXPEDIENTES');
                $event->sheet->mergeCells("T4:W4");
                $event->sheet->setCellValue('T4','Valores primarios');
                $event->sheet->mergeCells("X4:AA4");
                $event->sheet->setCellValue('X4','Vigencias documentales');
                $event->sheet->mergeCells("AB4:AE4");
                $event->sheet->setCellValue('AB4','Técnicas de selección');
                $event->sheet->mergeCells("AR4:AS4");
                $event->sheet->setCellValue('AR4','Información del servidor público que desclasifica');
                $event->sheet->styleCells(
                    'A1:AS1',
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'fill' => [
                            'fillType' => static::$FILL::FILL_SOLID,
                        ]
                    ]
                );

                $event->sheet->styleCells(
                    $cols,
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'alignment' => [
                            'horizontal' => static::$ALIGNMENT::HORIZONTAL_CENTER,
                            'vertical' => static::$ALIGNMENT::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => static::$FILL::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'FFFFFFFF',
                            ],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    $cols,
                    [
                        'font' => [
                            'bold' => true,
                            'name' =>  'Montserrat',
                            'size' =>  12
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
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A5:AS'.$this->totalRecords,
                    [
                        'font' => [
                            'name' =>  'Montserrat',
                            'size' =>  12
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => static::$BORDER::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ]
                        ]
                    ]
                );

                $event->sheet->autoFilter("B5:AS5");

            },
        ];
    }

    public function collection()
    {
        $relations = ['user.determinant', 'section', 'serie.primarivalues', 'subserie','description'];
        if(auth()->user()->cat_profile_id === 1){
            $formalities = Formalities::with($relations)
                ->search($this->data['filters'])
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $formalities = Formalities::with($relations)
                ->whereUnitId(auth()->user()->cat_unit_id)
                ->search($this->data['filters'])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        $records = $formalities->map(function ($item) {
            ++$this->numRegister;
            ++$this->totalRecords;
            $determinant = '';
            if (isset($item->unit)){
                $determinant .= ' ' . $item->unit->determinant;
            }

            $sort_code = $item->sort_code;

            $section = '';
            if (isset($item->section)){
                $section .= ' ' . $item->section->full_name;
            }

            $serie = '';
            $administrative = '-';
            $legal = '-';
            $fiscal = '-';
            $accountant = '-';

            $AT = 0;
            $AC = 0;
            $soli = 0;
            $totalV = 0;

            $elimT = '-';
            $consT = '-';
            $muestT = '-';
            $cualiT = '-';

            if (isset($item->serie)){
                $serie .= ' ' . $item->serie->full_name;
                if (isset($item->serie->primarivalues)){
                    foreach ($item->serie->primarivalues as $vp){
                        if ($vp->id === 1) $administrative = 'X';
                        if ($vp->id === 2) $legal = 'X';
                        if ($vp->id === 3) $fiscal = 'X';
                        if ($vp->id === 4) $accountant = 'X';
                    }
                }

                $AT = $item->serie->AT;
                $AC = $item->serie->AC;
                $totalV = (int)$item->serie->total;
                if ($item->question_one){
                    $totalV += 2;
                    $soli = 2;
                }else{
                    $soli = '0';
                }

                if ($item->serie->cat_selection_id === 1) {
                    $elimT = 'X';
                }elseif ($item->serie->cat_selection_id === 2) {
                    $consT = 'X';
                }elseif ($item->serie->cat_selection_id === 3) {
                    $muestT = 'X';
                }
                if ($item->haveQuality) {
                    $cualiT = 'X';
                }
            }

            $subserie = '';
            if (isset($item->subserie)){
                $subserie .= ' ' . $item->subserie->full_name;
            }

            $openingDate = $item->opening_date;
            $closeDate = $item->close_date;
            $consecutive = $item->consecutive;
            $legajo = $item->legajo;
            $title = $item->title;

            $description = '';
            if (isset($item->description)){
                $description .= ' ' . $item->description->description;
            }

           $additionalInformation = $item->additional_information;
            $format = $item->format_id === 1 ? 'Electrónico' : 'Físico';
            if ($item->documentary_tradition_id === 1) {
                $documentaryTradition = 'Copia';
            }
            elseif ($item->documentary_tradition_id === 2) {
                $documentaryTradition = 'Original';
            }
            else {
                $documentaryTradition = 'Original y copia';
            }
            /*$documentaryTradition = ($item->documentary_tradition_id === 1 ? 'Copia'
                                    : $item->documentary_tradition_id === 2 ? 'Original'
                                    :'Original y copia');*/
            $legajos = $item->legajos;
            $initialFolio = $item->initial_folio;
            $endFolio = $item->end_folio;
            $totalFojas = $item->total_fojas;
            /*******CONDICIONES DE ACCESO***********/
            $transparencyResolution = '';
            $classificationReason = '';
            $classificationDate = '';
            $nameTitular = '';
            $transparencyProceedings = '';
            $restrictedParts = '';
            $legalBasis = '';
            $reservationPeriod = '';
            $deadlineExtension = '';
            $recordOfficialNumber = '';
            $declassificationDate = '';
            $namePublicServer = '';
            $positionPublicServer = '';
            if ($item->question_two){
                if ($item->transparency_resolution_id === 1){
                    $transparencyResolution = 'Confidencial';
                }elseif ($item->transparency_resolution_id === 2){
                    $transparencyResolution = 'Versión pública';
                }elseif ($item->transparency_resolution_id === 3){
                    $transparencyResolution = 'Reservada';
                }

                if ($item->classification_reason_id === 1){
                    $classificationReason = 'Datos personales';
                }else{
                    $classificationReason = 'Datos sensibles';
                }

                $classificationDate = $item->classification_date;
                $nameTitular = $item->name_titular;
                $transparencyProceedings = $item->transparency_proceedings;
                $restrictedParts = $item->restricted_parts;
                $legalBasis = $item->legal_basis;
                $reservationPeriod = $item->reservation_period;
                $deadlineExtension = $item->deadline_extension;
                $recordOfficialNumber = $item->Record_official_number;
                $declassificationDate = $item->declassification_date;
                $namePublicServer = $item->name_public_server;
                $positionPublicServer = $item->position_public_server;

            }
            /***************************/
            return [
                $this->numRegister,
                $determinant,
                $sort_code,
                $section,
                $serie,
                $subserie,
                $openingDate,
                $closeDate,
                $consecutive,
                $legajo,
                $title,
                $description,
                $additionalInformation,
                $format,
                $documentaryTradition,
                $legajos,
                $initialFolio,
                $endFolio,
                $totalFojas,
                $administrative,
                $legal,
                $fiscal,
                $accountant,
                $AT,
                $AC,
                $soli,
                $totalV,
                $elimT,
                $consT,
                $muestT,
                $cualiT,
                $transparencyResolution,
                $transparencyResolution,
                $classificationReason,
                $classificationDate,
                $nameTitular,
                $transparencyProceedings,
                $restrictedParts,
                $legalBasis,
                $reservationPeriod,
                $deadlineExtension,
                $recordOfficialNumber,
                $declassificationDate,
                $namePublicServer,
                $positionPublicServer
            ];
        });
        $this->totalRecords += 5;

        return $records;
    }
}
