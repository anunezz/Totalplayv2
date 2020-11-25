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
use App\Http\Traits\TraitReport;
use App\Http\Models\Formalities;

class ReportController extends Controller
{
    public $alphanumeric = "/^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,\()\-\s]+$/";

    public function Proceedings(Request $request){
        try{

            $data = $request->all();
            $Formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section','description')->find( decrypt($data['id']) );
            $results = TraitReport::proceedings( $Formalities );
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
            $Formalities = Formalities::with('serie.primarivalues','SubSerie','section')->find( decrypt($data['id']) );
            //dd($Formalities->unit()->first()->determinant);
            return Excel::download(new Labels([], TraitReport::label( $Formalities )  ), 'Etiqueta.xlsx');

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
                $data['filters']['unidad'] = TraitReport::series( $data['filters']['unidad'] );
                $data['filters']['documentType'] = TraitReport::documentType( $data['documentType'] );
                $formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->filter($data['filters'])->get();

                $Inventory = CatInventory::find(1);
                return Excel::download(new lowDocumentary([],[
                    "data" => TraitReport::documentary( $formalities ),
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
                $data['filters']['unidad'] = TraitReport::series( $data['filters']['unidad'] );
                $data['filters']['documentType'] = TraitReport::documentType( $data['documentType'] );
                $formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->filter($data['filters'])->get();

                return Excel::download(new lowAccounting([],[
                    "data" => TraitReport::accounting( $formalities )
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
                $data['filters']['unidad'] = TraitReport::series( $data['filters']['unidad'] );
                $data['filters']['documentType'] = TraitReport::documentType( $data['documentType'] );
                $formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->filter($data['filters'])->get();

                return Excel::download(new Transfer([],[
                    'transfer' => 'Transferencia primaria',
                    'data' => TraitReport::transfer( $formalities )
                ]), 'Transferencia_primaria.xlsx');

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
                $data['filters']['unidad'] = TraitReport::series( $data['filters']['unidad'] );
                $data['filters']['documentType'] = TraitReport::documentType( $data['documentType'] );
                $formalities = Formalities::with('unit','serie.primarivalues','SubSerie','section')->filter($data['filters'])->get();

                return Excel::download(new Transfer([],[
                    'transfer' => 'Transferencia secundaria',
                    'data' => TraitReport::transfer( $formalities )
                ]), 'Transferencia_secundaria.xlsx');

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

                $request->validate([
                    'page' => 'required|numeric',
                    'perPage' => 'required|numeric',
                    'documentType' => 'required|regex:'.$this->alphanumeric.'im',
                    'filters' => 'required|array',
                    'filters.*show' => 'required|boolean',
                    'filters.*year' => 'nullable|numeric',
                    'filters.*user' => 'nullable|numeric',
                    'filters.*serie_id' => 'nullable|numeric',
                    'filters.*unidad' => 'nullable|numeric',
                ]);

                $data['filters']['unidad'] = TraitReport::series( $data['filters']['unidad'] );
                $data['filters']['documentType'] = TraitReport::documentType( $data['documentType'] );

                $formalities = Formalities::with('user.determinant')
                    ->filter($data['filters'])
                    ->paginate($data['perPage']);

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

    // public static function series_id($data){
    //     $user = User::with('profile','unit')->find( auth()->user()->id );
    //     $Profile = $user->profile()->first();
    //     $series = [];

    //     if( $Profile->id === 1 ){
    //         $series = CatSeries::get();
    //     }else{
    //         $unit = CatAdministrativeUnit::with('series')->find($data);
    //         $series = $unit->series;
    //     }

    //     return $series;
    // }

    public function getCats(Request $request){
        try{
            $data = $request->all();
            return response()->json([
                'success' => true,
                'lResults' => [
                    'series' => TraitReport::series_id($data['unidad'])
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
