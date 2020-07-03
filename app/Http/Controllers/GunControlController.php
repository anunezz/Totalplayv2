<?php

namespace App\Http\Controllers;
use Cache;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Http\Models\Operative;
use App\Http\Models\Consulate;
use App\Http\Models\Cats\CatConsulate;

use phpDocumentor\Reflection\File;

class GunControlController extends Controller
{
    public function registerGunControl(Request $request){
        try {
            if ($request->wantsJson()){
                $data = $request->all();

                foreach ($data as $value) {
                    $value['user_id'] = auth()->user()->id;
                    $results = Operative::create( $value );
                }

                return response()->json([
                    'success' => true,
                    'lResults'=> 'ok'
                ]);
            }else{
                return response()->view('errors.404', [], 404);
            }
        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function getGunControl(){
        try{
        $results = Consulate::get();
        $data = [];
        $totalArmas = [];
        $totalOperativos = [];

        foreach ($results as $value) {

            // where('consulatee_id', $value->consulate_id  )->

            $operative = Operative::get();

            $sum = [];
            foreach ($operative as $v) {

               array_push($sum, $v->short_arms);
               array_push($sum, $v->long_weapons);
               array_push($sum, $v->barret);
               array_push($sum, $v->chargers);
               array_push($sum, $v->explosives);
               array_push($sum, $v->rocket_launcher);
               array_push($sum, $v->parts_accessories);

            }

            //dd($sum);

            array_push($data,[
                "consulate_id"=> $value->consulate_id,
                "consulate" => CatConsulate::find($value->consulate_id)->name,
                "no_operatives" =>  count($operative),
                "no_aseguramientos" => array_sum($sum),
                "status" => 'Active'
            ]);
        }

        return response()->json([
            'success' => true,
            'lResults'=> $data
        ]);


        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }






    public function getOperatives(){
        try{

                $results = Operative::get();

                return response()->json([
                    'success' => true,
                    'lResults'=> $results
                ]);


        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }





}
