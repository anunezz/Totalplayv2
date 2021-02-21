<?php namespace App\Http\Controllers;

use App\Http\Models\Transaction;
use App\User;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public static function saveTransactionLog($type, $action)
    {
        $transaction = new Transaction();

        $transaction->user_id = auth()->user()->id;
        $transaction->cat_transaction_type_id = $type;
        $transaction->action = $action;
        $transaction->save();
    }

    public function getCountRegisters(Request $request)
    {
        try {
            if(auth()->user()->cat_profile_id === 1){
                $registers = Formalities::all()->count();
            }else{
                $registers = Formalities::whereUnitId(auth()->user()->cat_unit_id)->get()->count();
            }

            return response()->json([
                'registers' =>$registers,
                'success'    => true,
            ], 200);
        }
        catch ( Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getNotifications()
    {
        try {
            return response()->json([
                'success'       => true,
            ], 200);
        }
        catch ( Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
