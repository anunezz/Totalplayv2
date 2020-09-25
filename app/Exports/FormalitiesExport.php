<?php

namespace App\Exports;

use App\Http\Models\Formalities;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 0);

class FormalitiesExport implements
    FromCollection,
    WithHeadings,
    WithTitle
{

    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

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
        return 'Archivos de trámite';
    }

    public function collection()
    {
        return Formalities::all();
    }
}
