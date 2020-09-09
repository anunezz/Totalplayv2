<?php

namespace App\Http\Controllers\SICAR;

use App\Http\Controllers\Controller;
use App\Http\Models\SICAR\FormalitiesSicar;
use App\Http\Models\SICAR\UserSicar;
use Illuminate\Http\Request;

class FormalitiesSicarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        if ($request->wantsJson()){
            $data = $request->all();
            $formalities = FormalitiesSicar::orderBy('created_at', 'DESC')
                ->search($data['filters'])
                ->paginate($data['perPage']);

            return response()->json([
                'formalitiesSicar' => $formalities,
                'success' => true
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return response()->json([
                'success' => true,
                'formalitySicar' => FormalitiesSicar::find(decrypt($id))
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function allUserUnitSicar()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $usersId = FormalitiesSicar::select('user_id')->distinct()->pluck('user_id');

        return response()->json([
            'success' => true,
            'users' => UserSicar::whereIn('id',$usersId)->orderBy('name', 'asc')->get()
        ]);
    }
}
