<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Models\Contact;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class exportContacts implements
    WithTitle,
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Contactos';
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Ciudad',
            'Código postal',
            'Correo eléctronico',
            'Teléfono',
            'Paquete',
            'Categoria paquete',
            'Código de promoción'
        ];
    }

    public function collection()
    {
        $Contact =  Contact::with(['city','pack'])->orderBy('id','desc')->get();

        $Contact = $Contact->map(function ($item) {
            return [
                "name" => $item->name,
                "city" => $item->city->name,
                "zip_code" => $item->zip_code,
                "email" => $item->email,
                "phone" => $item->phone,
                "promotion" => $this->promotion( optional($item->pack)->type ),
                "category_pack" => optional( $item->pack )->name,
                "code" => $item->promotion_code
            ];
        });

        return $Contact;

    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true,'size' => 13]],

            // Styling a specific cell by coordinate.
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            //'C'  => ['font' => ['size' => 16]],
        ];
    }

    public static function promotion($val){
        $aux = '';
        switch ($val) {
            case 1:
                $aux = 'Paquete hogar';
            break;
            case 2:
                $aux = 'Paquete amazon';
            break;
            case 3:
                $aux = 'Paquete netflix';
            break;
            default:
                $aux = '';
            break;
        }

        return $aux;
    }

}
