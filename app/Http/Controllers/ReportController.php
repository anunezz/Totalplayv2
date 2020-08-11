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

class ReportController extends Controller
{

    public function Proceedings(Request $request){
        try{

            $data = $request->all();
            $data = array_keys($data);

            return Excel::download(new Proceedings([],['holasdjdjdjsdjdsjdsj']), 'invoices.xlsx');


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
