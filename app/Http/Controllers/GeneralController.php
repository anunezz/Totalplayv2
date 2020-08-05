<?php namespace App\Http\Controllers;

use App\Http\Models\Cats\CatConsulate;
use App\Http\Models\Cats\CatOrganism;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Notice;
use App\Http\Models\Recommendation;
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
//            $registers = Recommendation::where('isActive', true)->get()->count();

            return response()->json([
                'registers' =>0,
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
