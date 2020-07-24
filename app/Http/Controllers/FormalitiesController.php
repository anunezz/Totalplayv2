<?php

namespace App\Http\Controllers;

use App\Http\Models\Cats\CatSection;
use App\Http\Models\Cats\CatSeries;
use App\Http\Models\Cats\CatSubseries;
use App\Http\Models\Formalities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormalitiesController extends Controller
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
            $formalities = Formalities::search($data['filters'])
                                        ->paginate($data['perPage']);

            return response()->json([
               'formalities' => $formalities,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {

            DB::beginTransaction();
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;

            $formality = new Formalities();
            $formality->fill($data);
            $formality->save();

            GeneralController::saveTransactionLog(2,
                'El usuario con id: '.auth()->user()->id.' Crea un nuevo trámite con id: '. $formality->id);

            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $formality = Formalities::find(decrypt($id));
            $formality->primariValues = $formality->serie->primarivalues;
            return response()->json([
                'success' => true,
                'formality' =>$formality
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

    public function allSection()
    {
        try {
            return response()->json([
                'success' => true,
                'sections' =>CatSection::orderBy('name')->get()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allSeries(Request $request)
    {
        try {
            $serie = $request->all();
            return response()->json([
                'success' => true,
                'series' =>CatSeries::with('primarivalues')->whereCatSectionId($serie['id'])->get()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allSubSeries(Request $request)
    {
        try {

            $subSerie = $request->all();

            return response()->json([
                'success' => true,
                'subSeries' =>CatSubseries::orderBy('name')->whereCatSeriesId($subSerie['id'])->get()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function SortCode(Request $request)
    {
        try {
            $data = $request->all();

            return response()->json([
                'success' => true,
                'total' =>Formalities::where('sort_code', 'like', $data['code'].'%')->count()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
