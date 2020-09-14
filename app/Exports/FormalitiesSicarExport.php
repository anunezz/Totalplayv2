<?php

namespace App\Exports;

use App\Http\Models\SICAR\FormalitiesSicar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class FormalitiesSicarExport implements
    FromCollection,
    WithHeadings,
    WithTitle
{
    private $formalities;
    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    public function __construct($formalities)
    {
        $this->formalities = $formalities;
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Nombre',
            'Título',
            'Fecha',
            'Tipo de Información',
            'Tipo de Comunicado',
            'Estatus',
            'Comunicado'
        ];
    }

    public function title(): string
    {
        return 'Archivos de trámite historicos';
    }

    public function collection()
    {

        return $this->formalities;
    }
}
