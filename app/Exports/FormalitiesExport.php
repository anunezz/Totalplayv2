<?php

namespace App\Exports;

use App\Http\Models\Formalities;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class FormalitiesExport implements
    FromCollection,
    WithTitle
{

    private static $ALIGNMENT = '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment';
    private static $FILL = '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill';
    private static $BORDER = '\\PhpOffice\\PhpSpreadsheet\\Style\\Border';

    public function title(): string
    {
        return 'Archivos de trámite';
    }

    public function collection()
    {
        return Formalities::all();
    }
}
