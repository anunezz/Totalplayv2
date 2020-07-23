<?php

namespace App\Http\Controllers;

use Cache;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Exports\Proceedings;

class ReportController extends Controller
{

    public function Proceedings(Request $request){
        try{

            $data = $request->all();
            return Excel::download(new Proceedings([],['holasdjdjdjsdjdsjdsj']), 'invoices.xlsx');


        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

}
