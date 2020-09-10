<?php

namespace App\Http\Controllers;

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

            $results = [
                        //Nivel de descripción documental
                        'unidad' => $Formalities->unit()->first()->name,
                        'serieCode' => $Formalities->serie()->first()->code,
                        'serieName' => $Formalities->serie()->first()->name,
                        'subserieName' => ( $Formalities->SubSerie()->first() !== null )?$Formalities->SubSerie()->first()->name : '',
                        'subserieCode' => ( $Formalities->SubSerie()->first() !== null )?$Formalities->SubSerie()->first()->code : 'N/A',
                        'sectionCode' => $Formalities->section()->first()->code,
                        'sectionName'=> $Formalities->section()->first()->name,

                        //Código de referencia
                        'codeOfReference' => substr($Formalities->sort_code, 4),
                        'legajo' => "1/".$Formalities->legajo,

                        //Titulo
                        'title' => $Formalities->title,

                        //Alcance y contenido (asunto)
                        'alcance_y_contenido' => $Formalities->scope_and_content,

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
            //$pdf->setOptions(['isPhpEnabled' => true]);
            return $pdf->download('caratula.pdf');



            //return Excel::download( new Proceedings([],$results), 'invoices.xlsx');


            //return Excel::download(new Proceedings([],['holasdjdjdjsdjdsjdsj']), 'invoices.xlsx');


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
                $results = Formalities::with('serie.primarivalues','SubSerie','section')->get();

                // $data = $collection->map(function ($item, $key) {
                //     return $item * 2;
                // });

                return Excel::download(new lowDocumentary([],$data), 'Baja_documental.xlsx');

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

                return Excel::download(new lowAccounting([],$data), 'Baja_contable.xlsx');

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

    public function Transfer(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();
                //dd($data);

                if($data['transfer'] === 'primary'){
                    $data['transfer'] = 'Transferencia primaria';
                }
                if($data['transfer'] === 'secondary'){
                    $data['transfer'] = 'Transferencia secundaria';
                }


                return Excel::download(new Transfer([],[
                    'transfer' => $data['transfer']
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

    public function fileFilter(Request $request){
        try{
            if ($request->wantsJson()){
                $data = $request->all();



                if(auth()->user()->cat_profile_id === 1){
                    //dd("Estas aqui..");
                    $formalities = Formalities::with('user.determinant')
                        ->filter($data['filters'])
                        ->whereYear('close_date', '>=', date("Y"))
                        ->orderBy('created_at', 'DESC')
                        ->paginate($data['perPage']);

                    //////dd($formalities);
                }else{
                    //dd(  auth()->user()->admin()->first()->id   );
                    //$unidadid = auth()->user()->admin()->first()->id;
                    // if(auth()->user()->cat_unit_id === 4){
                    // }else{
                    // }
                    // $formalities = Formalities::with('user.determinant')
                    // ->whereUnitId(auth()->user()->cat_unit_id)
                    // ->filter($data['filters'])
                    // ->orderBy('created_at', 'DESC')
                    // ->paginate($data['perPage']);

                    $formalities = Formalities::with('user.determinant')
                    ->filter($data['filters'])
                    ->whereYear('close_date', '>=', date("Y"))
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

            $series = CatSeries::get();

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
