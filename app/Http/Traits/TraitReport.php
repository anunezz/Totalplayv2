<?php

namespace App\Http\Traits;
use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Models\Cats\CatSeries;
use App\User;

class TraitReport
{
    public static function label($Formalities){
        $cels = preg_split("/[-]/", $Formalities->sort_code);
        $code = str_replace('SRE.',"", $cels[0]);
        $cels[1] = $cels[1].'-';

        $data = [];
        for ($i= 1; $i < $Formalities->legajo + 1; $i++) {
            $legajo = $i."/".$Formalities->legajo;
            array_push($data,[$code,$cels[1],$cels[2],'/DAN','/ET001-01',$legajo, $Formalities->title]);
        }

        return collect($data)->chunk(2);
    }

    public static function proceedings($Formalities){
        return [
            //Nivel de descripción documental
            'unidad' => $Formalities->unit()->first()->name, //unidad administrativa
                                                             // area generadora
            'section' => $Formalities->section()->first()->code,  // seccion
            'sectionName' => $Formalities->section()->first()->name,  // seccion nombre
            'serieCode' => $Formalities->serie()->first()->code, //Serie
            'serieName' => $Formalities->serie()->first()->name, // Serie nombre
            'subserieCode' => ( $Formalities->SubSerie()->first() !== null )?$Formalities->SubSerie()->first()->code : 'N/A', //Subserie code
            'subserieName' => ( $Formalities->SubSerie()->first() !== null )?$Formalities->SubSerie()->first()->name : '', // Subserie nombre

            //Código de referencia
            'codeOfReference' => substr($Formalities->sort_code, 4), // ejemplo SRE. 08C.24-2019-2019/1
            'legajo' => "1/".$Formalities->legajo, //Lejajo  ejemplo = 1/15

            //Titulo
            'title' => $Formalities->title, // Título

            //Alcance y contenido (asunto)
            'alcance_y_contenido' => $Formalities->scope_and_content, //Pendiente

            //Fechas
            'opening_date' => $Formalities->opening_date,
            'close_date' => $Formalities->close_date,

            //Volumen y soporte
            'Tradition_or_documentary_form' => $Formalities->documentary_tradition_id,
            'Format' => $Formalities->format_id,
            'initial_folio' => $Formalities->initial_folio,
            'end_folio' => $Formalities->end_folio,

            //Características físicas y requisitos técnicos

            //Valoración, selección y eliminación
            'AC' => $Formalities->serie()->first()->AC,

            //Condiciones de acceso (Leyenda de clasificación de la información y/o de versión pública)
            'Classification_date'=> $Formalities->classification_date,
            'declassification_date' => $Formalities->declassification_date,
            'public_server' => $Formalities->name_public_server,
            'name_titular'=> $Formalities->name_titular,
            'transparency_proceedings' => $Formalities->transparency_proceedings,
            'restricted_parts' => $Formalities->restricted_parts,
            'legal_basis' => $Formalities->legal_basis,
            'primarivalues' => collect( $Formalities->serie->primarivalues )->toArray(),
            'fojas' => $Formalities->total_fojas,
            'question_one' => $Formalities->question_one,
            'Noactaoficio' => $Formalities->Record_official_number,
            'reservation_period' => $Formalities->reservation_period,
            'deadline_extension' => $Formalities->deadline_extension
        ];
    }

    public static function documentaryValue($item){
        $A = '-';
        $L = '-';
        $F = '-';
        $C = '-';

        foreach ($item as $serie) {
            if( count( $serie->primarivalues()->get() ) > 0 ){
                foreach ($serie->primarivalues()->get() as $itm) {
                    $id = $itm->id;
                        switch ($id) {
                            case 1:
                            {
                                $A = "X";
                            break;
                            }
                            case 2:
                            {
                                $L = "X";
                            break;
                            }
                            case 3:
                            {
                                $F = "X";
                            break;
                            }
                            case 4:
                            {
                                $C = "X";
                            break;
                            }
                        }
                }
            }
        }
        return ["A"=>$A, "L"=>$L, "F"=>$F, "C"=>$C];
    }

    public static function documentary($Formalities){
        $sum = 0;
        $data = [];
        foreach ($Formalities as $item) {
            $original = ($item->documentary_tradition_id === 1 || $item->documentary_tradition_id === 3)? 'X':'-';
            $copia    = ($item->documentary_tradition_id === 2 || $item->documentary_tradition_id === 3)? 'X':'-';
            $serie = $item->serie()->first();
            $sum++;
            $primarivalues = self::documentaryValue( $item->serie()->get() );

            //$item->serie()->first()->code, //1
            array_push($data,[
            $sum, //0  No. consecutivo
            $item->sort_code, //1 Código de clasificación archivística del expediente
            null, //2 Número consecutivo de caja
            $item->consecutive, //3 Número consecutivo del expe-diente
            $item->description()->first()->description, //4 Descripción del asunto del expediente
            $item->opening_date, //5 Año de apertura
            $item->close_date, //6 Año de cierre
            $original,//7 Original
            $copia,//8 Copia
            $primarivalues['A'],//9 A
            $primarivalues['L'],//10 L
            $primarivalues['F'],//1| F
            $primarivalues['C'],//12 C
            $serie->AT,//13 AT
            $serie->AC,//14 AC
            $serie->total//15 total
            ]);
        }
        return $data;
    }

    public static function accounting($Formalities){
        $sum = 0;
        $data = [];
        foreach ($Formalities as $item) {
            $serie = $item->serie()->first();
            $sum++;
            array_push($data,[
                $sum, //0 No.consecutivo
                $item->sort_code, //1 Código de clasificación archivística
                null, //2 Unidad de Medida y cantidad (Cajas)
                null, //3 Cantidad de Expedientes
                $item->title, //4 Título (nombre) del expediente
                null, //5 Descripción de la documentación anexa
                $item->opening_date, //6 Año de apertura
                $item->close_date, //7 Año de cierre
                null, //8 Corriente
                null, //9 Inversión
                null, //10 Ingreso
                null, //11 Otro
                $serie->AT, //12 AT
                $serie->AC, //13 AC
                $serie->total, //14 Total
            ]);
        }
        return $data;
    }

    public static function transfer($Formalities){

        $sum = 0;
        $data = [];
        foreach ($Formalities as $item) {
            $serie = $item->serie()->first();
            $original = ($item->documentary_tradition_id === 1 || $item->documentary_tradition_id === 3)? 'X':'-';
            $copia    = ($item->documentary_tradition_id === 2 || $item->documentary_tradition_id === 3)? 'X':'-';
            $sum++;

            $primarivalues = self::documentaryValue( $item->serie()->get() );

            array_push($data,[
                $sum,//0 No. consecutivo
                $item->sort_code,//1 Código de clasificación archivística del expediente
                null,//2 Número consecutivo de caja
                $item->consecutive,//3 Número consecutivo de expediente
                $item->title,//4 Título del expediente
                null,//5 Descripción de la documentación anexa
                $item->end_folio,//6 Número de folios que integra el expediente
                $item->opening_date,//7 Año de apertura
                $item->close_date,//8 Año de cierre
                $original,//9 Original
                $copia,//10 Copia
                $primarivalues['A'],//11 A
                $primarivalues['L'],//12 L
                $primarivalues['F'],//13 F
                $primarivalues['C'],//14 C
                $serie->AT,//15 AT
                $serie->AC,//16 AC
                $serie->total,//17 total
                null,//18 C
                null,//19 A
                null,//20 Ubicación topográfica
                null,//21 Observaciones
            ]);
        }

        return $data;
    }

    public static function documentType($data){

        switch ($data) {
            case 'lowDocumentary':
            {
                $data = 1;
            break;
            }
            case 'lowAccounting':
            {
                $data = 2;
            break;
            }
            case 'PrimaryTransfer':
            {
                $data = 3;
            break;
            }
            case 'TransferSecondary':
            {
                $data = 4;
            break;
            }
        }

        return $data;
    }

    public static function series_id($data){
        $user = User::with('profile','unit')->find( auth()->user()->id );
        $Profile = $user->profile()->first();
        $series = [];

        if( $Profile->id === 1 ){
            $series = CatSeries::get();
        }else{
            $unit = CatAdministrativeUnit::with('series')->find($data);
            $series = $unit->series;
        }

        return $series;
    }

    public static function series($data){
        $user = User::with('profile','unit')->find( auth()->user()->id );
        return ($user->profile()->first()->id)? false : $this->series_id( $data )->pluck('id');
    }


}
