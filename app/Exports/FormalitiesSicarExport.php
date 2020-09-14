<?php

namespace App\Exports;

use App\Http\Models\SICAR\FormalitiesSicar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;



use function foo\func;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class FormalitiesSicarExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents
{
    private $data;
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
            'Determinante',
            'Clasificación',
            'Sección',
            'Serie',
            'subserie',
            'Número de expediente',
            'Año',
            'Fecha de apertura',
            'Creado por',
        ];
    }

    public function title(): string
    {
        return 'Archivos de trámite historicos';
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $event->sheet->getDelegate()->getSheetView()->setZoomScale(90);
            $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $event->sheet->styleCells(
                'A1:I1',
                [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => static::$BORDER::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]
            );

        },
    ];
}

    public function collection()
    {
        $formalities = [];
        if(auth()->user()->cat_profile_id === 1){
            $formalities = FormalitiesSicar::orderBy('created_at', 'DESC')
                ->search($this->data['filters'])
                ->get();

        }else if (!is_null(auth()->user()->cat_unit_id)){
            $formalities = FormalitiesSicar::orderBy('created_at', 'DESC')
                ->where('key_units',auth()->user()->determinant->determinant)
                ->search($this->data['filters'])
                ->get();
        }

        $collection = collect();

        foreach ($formalities as $formality){
            $collection->push(
                [
                    $formality->key_units,
                    $formality->i_topograf,
                    $formality->key_section . ' '. $formality->section->name,
                    $formality->key_serie . ' '. $formality->serie->name,
                    $formality->key_subserie .' '. $formality->subserie->name,
                    $formality->case_file,
                    $formality->date,
                    $formality->open,
                    $formality->user->name
                ]
            );
        }
        return $collection;
    }
}
