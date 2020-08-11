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

use App\Http\Models\Formalities;

class ReportController extends Controller
{

    public function Proceedings(Request $request){
        try{

            $data = $request->all();

            $Formalities = Formalities::with('serie.primarivalues','SubSerie','section')->find($data->id)->first();

            //dd($Formalities);

            $results = [
                        //Nivel de descripción documental
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

                        //Condiciones de acceso (Leyenda de clasificación de la información y/o de versión pública)
                        'Classification_date'=> $Formalities->classification_date,
                        'declassification_date' => $Formalities->declassification_date,
                        'public_server' => $Formalities->public_server,
                        'name_titular'=> $Formalities->name_titular,
                        'transparency_proceedings' => $Formalities->transparency_proceedings,
                        'restricted_parts' => $Formalities->restricted_parts,
                        'legal_basis' => $Formalities->legal_basis,
                        'primarivalues' => collect( $Formalities->serie->primarivalues )->toArray(),
                        'fojas' => $Formalities->total_fojas,
                        'question_one' => $Formalities->question_one
                    ];

            return Excel::download( new Proceedings([],$results), 'invoices.xlsx');


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

            return Excel::download(new Labels([],['holasdjdjdjsdjdsjdsj']), 'invoices.xlsx');


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

            return Excel::download(new LabelBox([],['holasdjdjdjsdjdsjdsj']), 'etiqueta_de_caja.xlsx');


        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

}
