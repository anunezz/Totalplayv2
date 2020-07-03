<?php

namespace App\Http\Controllers;

use App\Http\Models\Strategy;
use App\Http\Models\Cats\CatConsulate;
use App\Http\Models\Recommendation;
use Cache;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\User;



class StrategiesController extends Controller
{


    public function index(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $data = $request->all();

                $strategies = Strategy::with('user', 'consulate')
                    ->where('isActive', true)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate($data['perPage']);

                return response()->json([
                    'strategies' => $strategies,
                    'success' => true
                ]);
            } else {
                return response()->view('errors.404', [], 404);
            }
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function create(Request $request)
    {
        try {
            if ($request->wantsJson()) {

                $consulates = CatConsulate::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                return response()->json([
                    'consulates' => $consulates,
                    'success' => true
                ]);

            } else {
                return response()->view('errors.404', [], 404);
            }

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->strategy;

            $stategy = new Strategy();
            $stategy->user_id = auth()->user()->id;
            $stategy->fill($data);
            $stategy->save();

            GeneralController::saveTransactionLog(2,
                'Crea una nueva recomendación con id: ' . $stategy->id);

            DB::commit();
            Cache::forget('dashboard');
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
