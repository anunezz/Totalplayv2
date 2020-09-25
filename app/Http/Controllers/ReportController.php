<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\User;
use App\CatInventory;
use Cache;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Exports\Proceedings;
use App\Exports\Labels;
use App\Exports\LabelBox;
use App\Exports\lowDocumentary;
use App\Exports\lowAccounting;
use App\Exports\Transfer;
use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Models\Cats\CatSeries;

use App\Http\Models\Formalities;

class ReportController extends Controller
{

    public function Proceedings(Request $request){
        try{

            $data = $request->all();

            $Formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->find( decrypt($data['id']) )->first();
            //$Formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->find( $data['id'] )->first();

            // foreach ($Formalities->serie()->get() as $item) {
            //     $value = $item->primarivalues()->get();
            //     dd($item->primarivalues()->get());
            // }

            //dd($Formalities->serie()->get());

            $results = [
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

            //return (  new Proceedings([],$results)   )->download('invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

            //return Excel::download( new Proceedings([],$results), 'invoices.xlsx');

            $pdf = \PDF::loadView('pdf.caratula_pdf',compact('results'));
            return $pdf->download('caratula.pdf');

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function Label(Request $request){
        try{

            $data = $request->all();
            $Formalities = Formalities::with('serie.primarivalues','SubSerie','section')->find( decrypt($data['id']) )->first();

            $cels = preg_split("/[-]/", $Formalities->sort_code);
            $code = str_replace('SRE.',"", $cels[0]);
            $cels[1] = $cels[1].'-';


            // $data = collect([
            //     [$code,$cels[1],$cels[2],'/DAN','/ET001-01',$legajo, $Formalities->title],
            // ])->chunk(2);

            $data = [];
            for ($i= 1; $i < $Formalities->legajo + 1; $i++) {
                $legajo = $i."/".$Formalities->legajo;
                array_push($data,[$code,$cels[1],$cels[2],'/DAN','/ET001-01',$legajo, $Formalities->title]);
            }

            $data = collect($data)->chunk(2);

           //dd($data);

            // $data = collect([
            //     ['08C.16.01','20166-','/01','/DAN','/ET001-01','1/2','Título del expediente'],
            //     ['08C.16.02','2018-','/01','/DAN','/ET001-01','1/2','Título del expediente'],
            // ])->chunk(2);

            return Excel::download(new Labels([],$data), 'Etiqueta.xlsx');


        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function LabelBox(Request $request){
        try{
            $data = $request->all();
            $unidad = CatAdministrativeUnit::find($data['cat_unit_id']);

            return Excel::download(new LabelBox([],[
                'unidad_admin' => $unidad->name
            ]), 'Etiqueta_de_caja.xlsx');

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function lowDocumentary(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();
                $Formalities = Formalities::with('description','unit','serie.primarivalues','SubSerie','section')->get();

                $sum = 0;
                $data = [];
                foreach ($Formalities as $item) {
                    dd($item);

                    $original = ($item->documentary_tradition_id === 1 || $item->documentary_tradition_id === 3)? 'X':'-';
                    $copia    = ($item->documentary_tradition_id === 2 || $item->documentary_tradition_id === 3)? 'X':'-';

                    $serie = $item->serie()->fiRst();

                    $sum++; //0
                    array_push($data,[
                    $sum, //0
                    //$item->serie()->first()->code, //1
                    $item->sort_code, //1
                    null, //2
                    $item->consecutive, //3
                    $item->description()->first()->description, //4
                    $item->opening_date, //5
                    $item->close_date, //6
                    $original,//7
                    $copia,//8
                    null,//9
                    null,//10
                    null,//1|
                    null,//12
                    $serie->AT,//13
                    $serie->AC,//14
                    $serie->total//15
                    ]);
                }

                //$user = User::with('unit')->find( auth()->user()->id );

                //dd($user);

                $Inventory = CatInventory::find(1);
                return Excel::download(new lowDocumentary([],[
                    "data" => $data,
                    "Inventory" => $Inventory
                ]), 'Baja_documental.xlsx');

            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al mostrar información ' . $e->getMessage()
        ], 300);
        }
    }

    public function lowAccounting(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();

                $Formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->get();

                //[1,   2010, null , 2012,1,2,3,4,5,6,7,8,9,10,11],

                $sum = 0;
                $data = [];
                foreach ($Formalities as $item) {
                    $serie = $item->serie()->first();
                    $sum++;
                    array_push($data,[
                        $sum, //0 No.consecutivo
                        $item->serie()->first()->code, //1 Código de clasificación archivística
                        null, //2 Unidad de Medida y cantidad (Cajas)
                        null, //3 Cantidad de Expedientes
                        $item->title, //4 Título (nombre) del expediente
                        $item->description()->first()->description, //5 Descripción de la documentación anexa
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

                return Excel::download(new lowAccounting([],[
                    "data" => $data
                ]), 'Baja_contable.xlsx');

            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al mostrar información ' . $e->getMessage()
        ], 300);
        }
    }

    public function PrimaryTransfer(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();
                $Formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->get();

                $sum = 0;
                $data = [];
                foreach ($Formalities as $item) {
                    $serie = $item->serie()->first();
                    $original = ($item->documentary_tradition_id === 1 || $item->documentary_tradition_id === 3)? 'X':'-';
                    $copia    = ($item->documentary_tradition_id === 2 || $item->documentary_tradition_id === 3)? 'X':'-';
                    $sum++;

                    $A = '-';
                    $L = '-';
                    $F = '-';
                    $C = '-';

                    foreach ($item->serie()->get() as $serie) {
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

                    array_push($data,[
                        $sum,//0 No. consecutivo
                        $item->serie()->first()->code,//1 Código de clasificación archivística del expediente
                        null,//2 Número consecutivo de caja
                        $item->consecutive,//3 Número consecutivo de expediente
                        $item->title,//4 Título del expediente
                        $item->description()->first()->description,//5 Descripción de la documentación anexa
                        $item->end_folio,//6 Número de folios que integra el expediente
                        $item->opening_date,//7 Año de apertura
                        $item->close_date,//8 Año de cierre
                        $original,//9 Original
                        $copia,//10 Copia
                        $A,//11 A
                        $L,//12 L
                        $F,//13 F
                        $C,//14 C
                        $serie->AT,//15 AT
                        $serie->AC,//16 AC
                        $serie->total,//17 total
                        null,//18 C
                        null,//19 A
                        null,//20 Ubicación topográfica
                        null,//21 Observaciones
                    ]);
                }

                return Excel::download(new Transfer([],[
                    'transfer' => 'Transferencia primaria',
                    'data' => $data
                ]), 'Transferencia_primaria.xlsx');

                return response()->json([
                    'success' => true,
                    'lResults' => [],
                ], 200);
                }else{
                return response()->view('errors.404', [], 404);
                }
            } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
            }
    }

    public function TransferSecondary(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();

                $Formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->get();

                $sum = 0;
                $data = [];
                foreach ($Formalities as $item) {
                    $serie = $item->serie()->first();
                    $original = ($item->documentary_tradition_id === 1 || $item->documentary_tradition_id === 3)? 'X':'-';
                    $copia    = ($item->documentary_tradition_id === 2 || $item->documentary_tradition_id === 3)? 'X':'-';
                    $sum++;

                    $A = '-';
                    $L = '-';
                    $F = '-';
                    $C = '-';

                    foreach ($item->serie()->get() as $serie) {
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

                    array_push($data,[
                        $sum,//0 No. consecutivo
                        $item->serie()->first()->code,//1 Código de clasificación archivística del expediente
                        null,//2 Número consecutivo de caja
                        $item->consecutive,//3 Número consecutivo de expediente
                        $item->title,//4 Título del expediente
                        $item->description()->first()->description,//5 Descripción de la documentación anexa
                        $item->end_folio,//6 Número de folios que integra el expediente
                        $item->opening_date,//7 Año de apertura
                        $item->close_date,//8 Año de cierre
                        $original,//9 Original
                        $copia,//10 Copia
                        $A,//11 A
                        $L,//12 L
                        $F,//13 F
                        $C,//14 C
                        $serie->AT,//15 AT
                        $serie->AC,//16 AC
                        $serie->total,//17 total
                        null,//18 C
                        null,//19 A
                        null,//20 Ubicación topográfica
                        null,//21 Observaciones
                    ]);
                }



                return Excel::download(new Transfer([],[
                    'transfer' => 'Transferencia secundaria',
                    'data' => $data
                ]), 'Transferencia_secundaria.xlsx');

                return response()->json([
                    'success' => true,
                    'lResults' => [],
                ], 200);
                }else{
                return response()->view('errors.404', [], 404);
                }
            } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
            }
    }

    public function fileFilter(Request $request){
        try{
            if ($request->wantsJson()){
                $data = $request->all();

                //dd($data);
                //dd(date("d-m-Y"));


               // SELECT close_date, haveQuality
               // FROM `formalities`
               // -- WHERE 1
               // -- WHERE close_date <= '2020-09-18'
               // WHERE close_date <= '2020-09-18' AND haveQuality = 1

                //whereBetween('reservation_from', [, date("Y-m-d")])

                $formalities = collect([]);

                if( $data['documentType'] === "lowDocumentary" ){
                    $formalities = Formalities::with('user.determinant')
                        ->where('haveQuality','=',0)
                        ->whereDate('close_date', '<=', date("Y-m-d"))
                        ->orderBy('created_at', 'DESC')
                        ->paginate($data['perPage']);
                }

                if( $data['documentType'] === "PrimaryTransfer" ){
                    $formalities = Formalities::with('user.determinant','serie')
                        //->whereBetween('reservation_from', [, date("Y-m-d")])
                        ->whereDate('close_date', '<=', date("Y-m-d"))
                        ->orderBy('created_at', 'DESC')
                        ->paginate($data['perPage']);

                    foreach ($formalities as $item) {
                        $serie = $item->serie()->first();
                        $primary = $serie->AT;
                        $secondary = $serie->AC;
                        $newdate = preg_split("/[-]+/", $item->opening_date);

                        $datePrimary = $newdate[0] + $primary.'-'.$newdate[1].'-'.$newdate[2];
                        $dateSecondary = $newdate[0] + $primary + $secondary.'-'.$newdate[1].'-'.$newdate[2];
                       // dd("########: ", $datePrimary ,$dateSecondary);
                    }
                }

                if( $data['documentType'] === "TransferSecondary" ){
                    $formalities = Formalities::with('user.determinant')
                        ->where('haveQuality','=',1)
                        ->whereDate('close_date', '<=', date("Y-m-d"))
                        ->orderBy('created_at', 'DESC')
                        ->paginate($data['perPage']);
                }

                return response()->json([
                    'success' => true,
                    'formalities' => $formalities,
                ], 200);
            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al mostrar información ' . $e->getMessage()
        ], 300);
        }
    }

    public function getCats(){
        try{


            $user = User::with('profile')->find( auth()->user()->id );
            $Profile = $user->profile()->first();

            if( $Profile->id === 1 ){
                $series = CatSeries::get();
            }else{



            }


            // if($idProfile === 1){
            //     $consulates = CatConsulate::where('frontier_id',1)->get(['id','name','isMirror']);
            // }else if($idProfile === 2){
            //     $consulates = $user->consulate()
            //     ->where('frontier_id',1)
            //     ->get(['id','name','isMirror']);
            // }else{
            //     $consulates = [];
            // }









            return response()->json([
                'success' => true,
                'lResults' => [
                    'series' => $series
                ],
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

}
